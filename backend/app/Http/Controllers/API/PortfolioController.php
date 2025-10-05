<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Experience;
use App\Models\Skill;
use App\Models\Education;
use App\Models\Testimonial;
use App\Models\BlogPost;
use App\Models\Setting;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index()
    {
        return response()->json([
            'profile' => [
                'name' => Setting::get('name', 'Shahzaman'),
                'title' => Setting::get('title', 'Full-Stack Developer'),
                'bio' => Setting::get('bio'),
                'email' => Setting::get('email'),
                'phone' => Setting::get('phone'),
                'location' => Setting::get('location'),
                'avatar' => Setting::get('avatar'),
                'resume_url' => Setting::get('resume_url'),
                'social_links' => json_decode(Setting::get('social_links', '{}'), true),
            ],
            'projects' => Project::published()->featured()->orderBy('order')->limit(6)->get(),
            'experiences' => Experience::orderBy('order')->orderBy('start_date', 'desc')->get(),
            'skills' => Skill::orderBy('order')->get()->groupBy('category'),
            'education' => Education::orderBy('order')->orderBy('start_date', 'desc')->get(),
            'testimonials' => Testimonial::where('is_featured', true)->orderBy('order')->get(),
            'recent_posts' => BlogPost::published()->orderBy('published_at', 'desc')->limit(3)->get(),
        ]);
    }

    public function projects()
    {
        return response()->json(Project::published()->orderBy('order')->get());
    }

    public function project($slug)
    {
        $project = Project::where('slug', $slug)->where('is_published', true)->firstOrFail();
        return response()->json($project);
    }

    public function experiences()
    {
        return response()->json(Experience::orderBy('order')->orderBy('start_date', 'desc')->get());
    }

    public function skills()
    {
        return response()->json(Skill::orderBy('order')->get()->groupBy('category'));
    }

    public function blog()
    {
        return response()->json(BlogPost::published()->orderBy('published_at', 'desc')->paginate(10));
    }

    public function blogPost($slug)
    {
        $post = BlogPost::where('slug', $slug)->where('is_published', true)->firstOrFail();
        $post->increment('views');
        return response()->json($post);
    }
}
