<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogPosts = BlogPost::orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return Inertia::render('Admin/BlogPosts/Index', [
            'blogPosts' => $blogPosts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/BlogPosts/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:blog_posts,slug',
            'excerpt' => 'required|string',
            'content' => 'required|string',
            'tags' => 'nullable|array',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Set published_at to now if publishing
        if (!empty($validated['is_published']) && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $blogPost = BlogPost::create($validated);

        // Handle image upload
        if ($request->hasFile('image')) {
            $blogPost->addMediaFromRequest('image')
                ->toMediaCollection('featured');
        }

        return redirect()->route('admin.blog-posts.index')
            ->with('success', 'Blog post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogPost $blogPost)
    {
        return Inertia::render('Admin/BlogPosts/Show', [
            'blogPost' => $blogPost->load('media'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogPost $blogPost)
    {
        return Inertia::render('Admin/BlogPosts/Edit', [
            'blogPost' => $blogPost->load('media'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogPost $blogPost)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:blog_posts,slug,' . $blogPost->id,
            'excerpt' => 'required|string',
            'content' => 'required|string',
            'tags' => 'nullable|array',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Set published_at to now if publishing for the first time
        if (!empty($validated['is_published']) && empty($blogPost->published_at) && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $blogPost->update($validated);

        // Handle image upload
        if ($request->hasFile('image')) {
            $blogPost->clearMediaCollection('featured');
            $blogPost->addMediaFromRequest('image')
                ->toMediaCollection('featured');
        }

        return redirect()->route('admin.blog-posts.index')
            ->with('success', 'Blog post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogPost $blogPost)
    {
        $blogPost->delete();

        return redirect()->route('admin.blog-posts.index')
            ->with('success', 'Blog post deleted successfully.');
    }
}
