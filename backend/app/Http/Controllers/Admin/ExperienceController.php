<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $experiences = Experience::orderBy('order')
            ->orderBy('start_date', 'desc')
            ->paginate(10);

        return Inertia::render('Admin/Experiences/Index', [
            'experiences' => $experiences,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Experiences/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
            'description' => 'nullable|string',
            'achievements' => 'nullable|array',
            'order' => 'nullable|integer',
        ]);

        Experience::create($validated);

        return redirect()->route('admin.experiences.index')
            ->with('success', 'Experience created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Experience $experience)
    {
        return Inertia::render('Admin/Experiences/Show', [
            'experience' => $experience,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Experience $experience)
    {
        return Inertia::render('Admin/Experiences/Edit', [
            'experience' => $experience,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Experience $experience)
    {
        $validated = $request->validate([
            'company' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
            'description' => 'nullable|string',
            'achievements' => 'nullable|array',
            'order' => 'nullable|integer',
        ]);

        $experience->update($validated);

        return redirect()->route('admin.experiences.index')
            ->with('success', 'Experience updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Experience $experience)
    {
        $experience->delete();

        return redirect()->route('admin.experiences.index')
            ->with('success', 'Experience deleted successfully.');
    }
}
