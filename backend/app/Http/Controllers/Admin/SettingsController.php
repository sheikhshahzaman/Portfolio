<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            // General Settings
            'name' => Setting::get('name', ''),
            'title' => Setting::get('title', ''),
            'bio' => Setting::get('bio', ''),
            'email' => Setting::get('email', ''),
            'phone' => Setting::get('phone', ''),
            'location' => Setting::get('location', ''),
            'resume_url' => Setting::get('resume_url', ''),

            // SEO Settings
            'meta_title' => Setting::get('meta_title', ''),
            'meta_description' => Setting::get('meta_description', ''),
            'meta_keywords' => Setting::get('meta_keywords', ''),
            'og_title' => Setting::get('og_title', ''),
            'og_description' => Setting::get('og_description', ''),
            'og_image' => Setting::get('og_image', ''),
            'twitter_card' => Setting::get('twitter_card', 'summary_large_image'),
            'twitter_handle' => Setting::get('twitter_handle', ''),
            'canonical_url' => Setting::get('canonical_url', ''),
            'robots' => Setting::get('robots', ''),

            // Social Links
            'social_links' => json_decode(Setting::get('social_links', '{}'), true),
        ];

        return Inertia::render('Admin/Settings/Index', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            // General Settings
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'resume_url' => 'nullable|url',

            // SEO Settings
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:500',
            'og_image' => 'nullable|url',
            'twitter_card' => 'nullable|string|in:summary,summary_large_image',
            'twitter_handle' => 'nullable|string|max:50',
            'canonical_url' => 'nullable|url',
            'robots' => 'nullable|string|max:100',

            // Social Links
            'social_links' => 'nullable|array',
        ]);

        // Save each setting
        foreach ($validated as $key => $value) {
            if ($key === 'social_links') {
                Setting::set($key, json_encode($value), 'json', 'social');
            } elseif (in_array($key, ['meta_title', 'meta_description', 'meta_keywords', 'og_title', 'og_description', 'og_image', 'twitter_card', 'twitter_handle', 'canonical_url', 'robots'])) {
                Setting::set($key, $value, 'text', 'seo');
            } else {
                Setting::set($key, $value, 'text', 'general');
            }
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}
