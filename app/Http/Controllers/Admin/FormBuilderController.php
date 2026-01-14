<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormItem;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser;
use PhpOffice\PhpWord\IOFactory;

class FormBuilderController extends Controller
{
    // --- FORM BUILDER ---
    public function index()
    {
        $forms = Form::latest()->get();
        return view('admin.forms.index', compact('forms'));
    }

    public function create()
    {
        // We need all questions to populate the dropdown in the builder
        $questions = Question::all();
        return view('admin.forms.create', compact('questions'));
    }

    public function store(Request $request)
    {
        $request->validate(['form_name' => 'required']);

        $form = Form::create([
            'name' => $request->form_name,
            'amount' => $request->amount ?? 0, // NEW
            'currency' => 'usd',
            'submit_btn_text' => $request->btn_text ?? 'Submit',
            'btn_color' => $request->btn_color ?? '#000000',
        ]);

        if ($request->has('items')) {
            foreach ($request->items as $index => $item) {
                FormItem::create([
                    'form_id' => $form->id,
                    'type' => $item['type'],
                    'label' => $item['label'],
                    'question_id' => $item['question_id'] ?? null,
                    'order_index' => $index
                ]);
            }
        }

        return redirect()->route('admin.forms.index')->with('success', 'Form created successfully!');
    }

    public function edit($id)
    {
        $form = Form::findOrFail($id);
        $questions = Question::all();
        if (!$form) {
            return redirect()->route('admin.forms.index')->with('error', 'Form not found.');
        }
        return view('admin.forms.edit', compact('form', 'questions'));
    }

    public function update(Request $request, $id)
    {
        // 1. Validation (Matches your store method)
        $request->validate([
            'form_name' => 'required|string|max:255',
            'items' => 'nullable|array', // Ensure items is an array if present
        ]);

        try {
            // 2. Start a Database Transaction
            DB::beginTransaction();

            $form = Form::findOrFail($id);

            // 3. Update the Parent Form
            $form->update([
                'name' => $request->form_name,
                'amount' => $request->amount ?? 0,
                'currency' => 'usd',
                'submit_btn_text' => $request->btn_text ?? 'Submit',
                'btn_color' => $request->btn_color ?? '#000000',
            ]);

            // 4. Sync Items (Delete old ones, recreate new ones)
            // This is the cleanest way to handle re-ordering or removed items.

            // Remove existing items linked to this form
            FormItem::where('form_id', $form->id)->delete();

            // Re-create items from the request
            if ($request->has('items')) {
                foreach ($request->items as $index => $item) {
                    FormItem::create([
                        'form_id' => $form->id,
                        'type' => $item['type'],
                        'label' => $item['label'],
                        'question_id' => $item['question_id'] ?? null,
                        'order_index' => $index // Maintains the sort order
                    ]);
                }
            }

            // 5. Commit the transaction (Save changes)
            DB::commit();

            return redirect()->route('admin.forms.index')
                ->with('success', 'Form updated successfully!');

        } catch (\Exception $e) {
            // 6. Rollback if error (Undo changes)
            DB::rollBack();

            // Log the error for debugging
            Log::error("Error updating form ID $id: " . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Something went wrong while updating the form.')
                ->withInput(); // Keep the user's input so they don't lose work
        }
    }
}
