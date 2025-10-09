<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Project;
use App\Models\BlogPost;
use App\Models\Testimonial;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'recentMessages' => ContactMessage::query()
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(),
            'unreadMessagesCount' => ContactMessage::unread()->count(),
            'stats' => [
                'projects' => Project::count(),
                'blogPosts' => BlogPost::count(),
                'testimonials' => Testimonial::count(),
                'totalMessages' => ContactMessage::count(),
            ],
        ]);
    }
}
