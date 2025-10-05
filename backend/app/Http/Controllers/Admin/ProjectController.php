<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::orderBy('order')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return Inertia::render('Admin/Projects/Index', [
            'projects' => $projects,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Projects/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:projects,slug',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'category' => 'nullable|string|max:100',
            'technologies' => 'nullable|array',
            'demo_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'order' => 'nullable|integer',
            'image' => 'nullable|image|max:2048',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $project = Project::create($validated);

        // Handle image upload
        if ($request->hasFile('image')) {
            $project->addMediaFromRequest('image')
                ->toMediaCollection('featured');
        }

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return Inertia::render('Admin/Projects/Show', [
            'project' => $project->load('media'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return Inertia::render('Admin/Projects/Edit', [
            'project' => $project->load('media'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:projects,slug,' . $project->id,
            'short_description' => 'required|string',
            'description' => 'required|string',
            'category' => 'nullable|string|max:100',
            'technologies' => 'nullable|array',
            'demo_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'order' => 'nullable|integer',
            'image' => 'nullable|image|max:2048',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $project->update($validated);

        // Handle image upload
        if ($request->hasFile('image')) {
            $project->clearMediaCollection('featured');
            $project->addMediaFromRequest('image')
                ->toMediaCollection('featured');
        }

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}
