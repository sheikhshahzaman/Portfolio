<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project;
use App\Models\Experience;
use App\Models\Skill;
use App\Models\Education;
use App\Models\Testimonial;
use App\Models\BlogPost;

class SyncTranslationKeys extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:sync {--model=all : The model to sync (all, projects, experiences, skills, education, testimonials, blog)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync all content to translation keys system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $model = $this->option('model');

        $this->info('Starting translation keys sync...');

        if ($model === 'all' || $model === 'projects') {
            $this->syncProjects();
        }

        if ($model === 'all' || $model === 'experiences') {
            $this->syncExperiences();
        }

        if ($model === 'all' || $model === 'skills') {
            $this->syncSkills();
        }

        if ($model === 'all' || $model === 'education') {
            $this->syncEducation();
        }

        if ($model === 'all' || $model === 'testimonials') {
            $this->syncTestimonials();
        }

        if ($model === 'all' || $model === 'blog') {
            $this->syncBlogPosts();
        }

        $this->info('Translation keys sync completed!');
    }

    protected function syncProjects()
    {
        $this->info('Syncing projects...');
        $projects = Project::all();
        $bar = $this->output->createProgressBar($projects->count());

        foreach ($projects as $project) {
            $project->syncTranslationKeys();
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Synced {$projects->count()} projects.");
    }

    protected function syncExperiences()
    {
        $this->info('Syncing experiences...');
        $experiences = Experience::all();
        $bar = $this->output->createProgressBar($experiences->count());

        foreach ($experiences as $experience) {
            if (method_exists($experience, 'syncTranslationKeys')) {
                $experience->syncTranslationKeys();
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Synced {$experiences->count()} experiences.");
    }

    protected function syncSkills()
    {
        $this->info('Syncing skills...');
        $skills = Skill::all();
        $bar = $this->output->createProgressBar($skills->count());

        foreach ($skills as $skill) {
            if (method_exists($skill, 'syncTranslationKeys')) {
                $skill->syncTranslationKeys();
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Synced {$skills->count()} skills.");
    }

    protected function syncEducation()
    {
        $this->info('Syncing education...');
        $education = Education::all();
        $bar = $this->output->createProgressBar($education->count());

        foreach ($education as $item) {
            if (method_exists($item, 'syncTranslationKeys')) {
                $item->syncTranslationKeys();
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Synced {$education->count()} education items.");
    }

    protected function syncTestimonials()
    {
        $this->info('Syncing testimonials...');
        $testimonials = Testimonial::all();
        $bar = $this->output->createProgressBar($testimonials->count());

        foreach ($testimonials as $testimonial) {
            if (method_exists($testimonial, 'syncTranslationKeys')) {
                $testimonial->syncTranslationKeys();
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Synced {$testimonials->count()} testimonials.");
    }

    protected function syncBlogPosts()
    {
        $this->info('Syncing blog posts...');
        $posts = BlogPost::all();
        $bar = $this->output->createProgressBar($posts->count());

        foreach ($posts as $post) {
            if (method_exists($post, 'syncTranslationKeys')) {
                $post->syncTranslationKeys();
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Synced {$posts->count()} blog posts.");
    }
}
