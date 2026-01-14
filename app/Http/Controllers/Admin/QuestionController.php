<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;
use PhpOffice\PhpWord\IOFactory;

class QuestionController extends Controller
{
    public function index()
    {
        // Fetch all questions to show in the list
        $questions = Question::with('options')->latest()->paginate(10);
        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        return view('admin.questions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'type' => 'required|in:text,radio,checkbox',
            // Options are required only if it is NOT a text question
            'options' => 'required_if:type,radio,checkbox|array',
        ]);

        $q = Question::create([
            'title' => $request->title,
            'type' => $request->type,
            // If text, save the base score. If radio/checkbox, score is 0 (calculated from options)
            'score' => $request->type === 'text' ? ($request->text_score ?? 0) : 0
        ]);

        // Save Options (Only for Radio/Checkbox)
        if (in_array($request->type, ['radio', 'checkbox']) && $request->has('options')) {
            foreach ($request->options as $opt) {
                if (!empty($opt['text'])) {
                    QuestionOption::create([
                        'question_id' => $q->id,
                        'option_text' => $opt['text'],
                        'score' => $opt['score'] ?? 0
                    ]);
                }
            }
        }

        return redirect()->route('admin.questions.index')->with('success', 'Question created successfully!');
    }

    public function importQuestions(Request $request)
    {
        $request->validate([
            'document' => 'required|mimes:pdf,docx,doc|max:5000'
        ]);

        $file = $request->file('document');
        $extension = $file->getClientOriginalExtension();
        $text = '';

        // 1. Extract Text based on file type
        if ($extension === 'pdf') {
            $parser = new Parser();
            $pdf = $parser->parseFile($file->getPathname());
            $text = $pdf->getText();
        } elseif ($extension === 'docx') {
            $phpWord = IOFactory::load($file->getPathname());
            foreach ($phpWord->getSections() as $section) {
                foreach ($section->getElements() as $element) {
                    if (method_exists($element, 'getText')) {
                        $text .= $element->getText() . "\n";
                    }
                }
            }
        }

        // 2. Parse the text and save to DB
        $this->parseAndSave($text);

        return back()->with('success', 'Questions imported successfully!');
    }

    private function parseAndSave($text)
    {
        // Normalize newlines
        $lines = explode("\n", $text);
        $currentQuestion = null;

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line))
                continue;

            // CHECK IF LINE IS A QUESTION
            if (str_starts_with($line, 'Q:')) {
                $title = trim(substr($line, 2)); // Remove "Q:"

                // Create the question (Default to radio, updated if 'Type:' is found next)
                $currentQuestion = Question::create([
                    'title' => $title,
                    'type' => 'radio',
                    'score' => 0
                ]);
            }

            // CHECK IF LINE IS A TYPE DEFINITION
            elseif (str_starts_with($line, 'Type:') && $currentQuestion) {
                $type = strtolower(trim(substr($line, 5))); // Remove "Type:"
                if (in_array($type, ['text', 'radio', 'checkbox'])) {
                    $currentQuestion->update(['type' => $type]);
                }
            }

            // CHECK IF LINE IS A TEXT SCORE (For Text questions)
            elseif (str_starts_with($line, 'Score:') && $currentQuestion) {
                $score = (int) trim(substr($line, 6));
                $currentQuestion->update(['score' => $score]);
            }

            // CHECK IF LINE IS AN OPTION (Starts with -)
            elseif (str_starts_with($line, '-') && $currentQuestion) {
                // Format: "- Option Text [10]"
                // Regex to separate text from score
                if (preg_match('/- (.*) \[(\d+)\]/', $line, $matches)) {
                    $optionText = trim($matches[1]);
                    $score = (int) $matches[2];

                    QuestionOption::create([
                        'question_id' => $currentQuestion->id,
                        'option_text' => $optionText,
                        'score' => $score
                    ]);
                }
                // Fallback for options without score (default 0)
                else {
                    $optionText = trim(substr($line, 1));
                    QuestionOption::create([
                        'question_id' => $currentQuestion->id,
                        'option_text' => $optionText,
                        'score' => 0
                    ]);
                }
            }
        }
    }

    public function edit($id)
    {
        $question = Question::with('options')->findOrFail($id);
        return view('admin.questions.edit', compact('question'));
    }

    // --- UPDATE QUESTION ---
    public function update(Request $request, $id)
    {
        $question = Question::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'type' => 'required',
        ]);

        // 1. Update Basic Info
        $question->update([
            'title' => $request->title,
            'type' => $request->type,
            'score' => $request->type === 'text' ? ($request->text_score ?? 0) : 0
        ]);

        // 2. Sync Options (Delete old, create new)
        // Simpler approach: Delete all existing options for this question and re-create them.
        // This avoids complex ID matching logic on frontend.
        if (in_array($request->type, ['radio', 'checkbox'])) {
            $question->options()->delete(); // Clear old options

            if ($request->has('options')) {
                foreach ($request->options as $opt) {
                    if (!empty($opt['text'])) {
                        QuestionOption::create([
                            'question_id' => $question->id,
                            'option_text' => $opt['text'],
                            'score' => $opt['score'] ?? 0
                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin.questions.index')->with('success', 'Question updated successfully!');
    }

    // --- DELETE QUESTION ---
    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete(); // Cascading delete will remove options automatically
        return back()->with('success', 'Question deleted successfully.');
    }
}
