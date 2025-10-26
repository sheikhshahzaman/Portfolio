<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Experience;
use App\Models\Skill;
use App\Models\Service;
use App\Models\Education;
use App\Models\Testimonial;
use App\Models\BlogPost;
use App\Models\Setting;
use App\Models\Language;
use App\Models\TranslationKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $langCode = $request->get('lang', 'en');
        $language = Language::where('code', $langCode)->where('is_active', true)->first();

        if (!$language) {
            $language = Language::where('is_default', true)->first();
        }

        $projects = Project::published()->featured()->with('translations')->orderBy('order')->limit(6)->get();
        $experiences = Experience::with('translations')->orderBy('order')->orderBy('start_date', 'desc')->get();
        $skills = Skill::with('translations')->orderBy('order')->get();
        $education = Education::with('translations')->orderBy('order')->orderBy('start_date', 'desc')->get();
        $testimonials = Testimonial::with('translations')->where('is_featured', true)->orderBy('order')->get();

        // Apply translations
        if ($language && $language->code !== 'en') {
            $projects = $this->applyTranslations($projects, $language->id, 'project');
            $experiences = $this->applyTranslations($experiences, $language->id, 'experience');
            $skills = $this->applyTranslations($skills, $language->id, 'skill');
            $education = $this->applyTranslations($education, $language->id, 'education');
            $testimonials = $this->applyTranslations($testimonials, $language->id, 'testimonial');
        }

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
            'seo' => [
                'meta_title' => Setting::get('meta_title'),
                'meta_description' => Setting::get('meta_description'),
                'meta_keywords' => Setting::get('meta_keywords'),
                'og_title' => Setting::get('og_title'),
                'og_description' => Setting::get('og_description'),
                'og_image' => Setting::get('og_image'),
                'twitter_card' => Setting::get('twitter_card', 'summary_large_image'),
                'twitter_handle' => Setting::get('twitter_handle'),
                'canonical_url' => Setting::get('canonical_url'),
                'robots' => Setting::get('robots'),
            ],
            'projects' => $projects,
            'experiences' => $experiences,
            'skills' => $skills->groupBy('category'),
            'education' => $education,
            'testimonials' => $testimonials,
            'recent_posts' => BlogPost::published()->orderBy('published_at', 'desc')->limit(3)->get(),
            'available_languages' => Language::active()->orderBy('order')->get(['code', 'name', 'native_name']),
            'current_language' => $language ? $language->code : 'en',
        ]);
    }

    private function applyTranslations($items, $languageId, $type)
    {
        return $items->map(function ($item) use ($languageId, $type) {
            $translation = $item->translation($languageId);

            if ($translation) {
                switch ($type) {
                    case 'project':
                        $item->title = $translation->title ?? $item->title;
                        $item->short_description = $translation->short_description ?? $item->short_description;
                        $item->description = $translation->description ?? $item->description;
                        break;
                    case 'experience':
                        $item->position = $translation->position ?? $item->position;
                        $item->description = $translation->description ?? $item->description;
                        if ($translation->achievements) {
                            $item->achievements = json_decode($translation->achievements, true);
                        }
                        break;
                    case 'skill':
                        $item->name = $translation->name ?? $item->name;
                        $item->category = $translation->category ?? $item->category;
                        break;
                    case 'education':
                        $item->degree = $translation->degree ?? $item->degree;
                        $item->description = $translation->description ?? $item->description;
                        break;
                    case 'testimonial':
                        $item->client_position = $translation->client_position ?? $item->client_position;
                        $item->client_company = $translation->client_company ?? $item->client_company;
                        $item->content = $translation->content ?? $item->content;
                        break;
                }
            }

            unset($item->translations);
            return $item;
        });
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

    public function services()
    {
        return response()->json(Service::active()->orderBy('order')->get());
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

    public function languages()
    {
        $languages = Language::where('is_active', true)
            ->orderBy('order')
            ->get(['id', 'code', 'name', 'native_name', 'is_default']);

        return response()->json($languages);
    }

    public function translations(Request $request)
    {
        $langCode = $request->get('lang', 'en');
        $translations = TranslationKey::getTranslations($langCode);

        return response()->json([
            'translations' => $translations,
            'language' => $langCode,
        ]);
    }
}
