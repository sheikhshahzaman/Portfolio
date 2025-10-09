<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Language;
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
        $languages = Language::where('is_active', true)->orderBy('order')->get();

        return Inertia::render('Admin/Projects/Create', [
            'languages' => $languages,
        ]);
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
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:500',
            'twitter_card' => 'nullable|string|in:summary,summary_large_image',
            'canonical_url' => 'nullable|url',
            'robots' => 'nullable|string|max:100',
            'translations' => 'nullable|array',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Remove fields handled separately
        $translations = $validated['translations'] ?? [];
        unset($validated['image']);
        unset($validated['translations']);

        $project = Project::create($validated);

        // Handle image upload
        if ($request->hasFile('image')) {
            $project->addMediaFromRequest('image')
                ->toMediaCollection('featured');
        }

        // Save translations
        $this->saveTranslations($project, $translations);

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
        $languages = Language::where('is_active', true)->orderBy('order')->get();

        // Load translations
        $translations = [];
        foreach ($languages as $lang) {
            if (!$lang->is_default) {
                $translation = $project->translation($lang->id);
                $translations[$lang->code] = $translation ? $translation->toArray() : null;
            }
        }

        return Inertia::render('Admin/Projects/Edit', [
            'project' => $project->load('media'),
            'languages' => $languages,
            'translations' => $translations,
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
            '_method' => 'nullable|string', // Allow _method field
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:500',
            'twitter_card' => 'nullable|string|in:summary,summary_large_image',
            'canonical_url' => 'nullable|url',
            'robots' => 'nullable|string|max:100',
            'translations' => 'nullable|array',
        ]);

        // Remove fields handled separately
        $translations = $validated['translations'] ?? [];
        unset($validated['_method']);
        unset($validated['image']);
        unset($validated['translations']);

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

        // Save translations
        $this->saveTranslations($project, $translations);

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

    /**
     * Save translations for the project
     */
    private function saveTranslations(Project $project, array $translations)
    {
        foreach ($translations as $langCode => $data) {
            if (empty($data)) {
                continue;
            }

            $language = Language::where('code', $langCode)->first();
            if (!$language) {
                continue;
            }

            $project->translations()->updateOrCreate(
                ['language_id' => $language->id],
                [
                    'title' => $data['title'] ?? null,
                    'short_description' => $data['short_description'] ?? null,
                    'description' => $data['description'] ?? null,
                    'category' => $data['category'] ?? null,
                ]
            );
        }
    }
}
