<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $education = Education::orderBy('order')
            ->orderBy('start_date', 'desc')
            ->paginate(10);

        return Inertia::render('Admin/Education/Index', [
            'education' => $education,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Education/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'institution' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
            'description' => 'nullable|string',
            'grade' => 'nullable|string|max:100',
            'order' => 'nullable|integer',
        ]);

        Education::create($validated);

        return redirect()->route('admin.education.index')
            ->with('success', 'Education entry created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Education $education)
    {
        return Inertia::render('Admin/Education/Show', [
            'education' => $education,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Education $education)
    {
        return Inertia::render('Admin/Education/Edit', [
            'education' => $education,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Education $education)
    {
        $validated = $request->validate([
            'institution' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
            'description' => 'nullable|string',
            'grade' => 'nullable|string|max:100',
            'order' => 'nullable|integer',
        ]);

        $education->update($validated);

        return redirect()->route('admin.education.index')
            ->with('success', 'Education entry updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Education $education)
    {
        $education->delete();

        return redirect()->route('admin.education.index')
            ->with('success', 'Education entry deleted successfully.');
    }
}
