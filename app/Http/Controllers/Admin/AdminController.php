<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.profile');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore(auth()->id()),
            ],
        ]);

        try {
            $admin = User::where(['id' => $id, 'role' => 'admin'])->firstOrFail();
            if ($admin) {
                $admin->update($validated);
            }
            // 3. Success
            return back()->with('success', 'Profile updated successfully!');

        } catch (\Exception $e) {
            // 4. Handle Errors
            // Log the actual error for the developer to see in storage/logs/laravel.log
            \Log::error('Admin Profile Update Error: ' . $e->getMessage());

            // Return a friendly error message to the user
            return back()
                ->withInput() // Keep the typed data in the form
                ->with('error', $e->getMessage() ?: 'An error occurred while updating the profile. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
