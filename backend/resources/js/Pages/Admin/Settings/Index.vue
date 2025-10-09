<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    settings: Object,
});

const form = useForm({
    // General Settings
    name: props.settings.name || '',
    title: props.settings.title || '',
    bio: props.settings.bio || '',
    email: props.settings.email || '',
    phone: props.settings.phone || '',
    location: props.settings.location || '',
    resume_url: props.settings.resume_url || '',

    // SEO Settings
    meta_title: props.settings.meta_title || '',
    meta_description: props.settings.meta_description || '',
    meta_keywords: props.settings.meta_keywords || '',
    og_title: props.settings.og_title || '',
    og_description: props.settings.og_description || '',
    og_image: props.settings.og_image || '',
    twitter_card: props.settings.twitter_card || 'summary_large_image',
    twitter_handle: props.settings.twitter_handle || '',
    canonical_url: props.settings.canonical_url || '',
    robots: props.settings.robots || '',

    // Social Links
    social_links: props.settings.social_links || {
        github: '',
        linkedin: '',
        twitter: '',
        facebook: '',
        instagram: '',
        youtube: '',
    },
});

const submit = () => {
    form.post(route('admin.settings.update'));
};
</script>

<template>
    <Head title="Settings" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Site Settings
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <form @submit.prevent="submit" class="p-6 space-y-8">
                        <!-- Profile Information -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Profile Information</h3>

                            <div>
                                <InputLabel for="name" value="Name" />
                                <TextInput
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    class="mt-1 block w-full"
                                />
                            </div>

                            <div>
                                <InputLabel for="title" value="Professional Title" />
                                <TextInput
                                    id="title"
                                    v-model="form.title"
                                    type="text"
                                    class="mt-1 block w-full"
                                />
                            </div>

                            <div>
                                <InputLabel for="bio" value="Bio" />
                                <textarea
                                    id="bio"
                                    v-model="form.bio"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    rows="4"
                                />
                            </div>

                            <div>
                                <InputLabel for="email" value="Email" />
                                <TextInput
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                    class="mt-1 block w-full"
                                />
                            </div>

                            <div>
                                <InputLabel for="phone" value="Phone" />
                                <TextInput
                                    id="phone"
                                    v-model="form.phone"
                                    type="text"
                                    class="mt-1 block w-full"
                                />
                            </div>

                            <div>
                                <InputLabel for="location" value="Location" />
                                <TextInput
                                    id="location"
                                    v-model="form.location"
                                    type="text"
                                    class="mt-1 block w-full"
                                />
                            </div>

                            <div>
                                <InputLabel for="resume_url" value="Resume URL" />
                                <TextInput
                                    id="resume_url"
                                    v-model="form.resume_url"
                                    type="url"
                                    class="mt-1 block w-full"
                                    placeholder="https://example.com/resume.pdf"
                                />
                            </div>
                        </div>

                        <!-- Social Links -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Social Links</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Enter full URLs for your social media profiles</p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <InputLabel for="github_url" value="GitHub URL" />
                                    <TextInput
                                        id="github_url"
                                        v-model="form.social_links.github"
                                        type="url"
                                        class="mt-1 block w-full"
                                        placeholder="https://github.com/username"
                                    />
                                </div>

                                <div>
                                    <InputLabel for="linkedin_url" value="LinkedIn URL" />
                                    <TextInput
                                        id="linkedin_url"
                                        v-model="form.social_links.linkedin"
                                        type="url"
                                        class="mt-1 block w-full"
                                        placeholder="https://linkedin.com/in/username"
                                    />
                                </div>

                                <div>
                                    <InputLabel for="twitter_url" value="Twitter/X URL" />
                                    <TextInput
                                        id="twitter_url"
                                        v-model="form.social_links.twitter"
                                        type="url"
                                        class="mt-1 block w-full"
                                        placeholder="https://twitter.com/username"
                                    />
                                </div>

                                <div>
                                    <InputLabel for="instagram_url" value="Instagram URL" />
                                    <TextInput
                                        id="instagram_url"
                                        v-model="form.social_links.instagram"
                                        type="url"
                                        class="mt-1 block w-full"
                                        placeholder="https://instagram.com/username"
                                    />
                                </div>

                                <div>
                                    <InputLabel for="facebook_url" value="Facebook URL" />
                                    <TextInput
                                        id="facebook_url"
                                        v-model="form.social_links.facebook"
                                        type="url"
                                        class="mt-1 block w-full"
                                        placeholder="https://facebook.com/username"
                                    />
                                </div>

                                <div>
                                    <InputLabel for="youtube_url" value="YouTube URL" />
                                    <TextInput
                                        id="youtube_url"
                                        v-model="form.social_links.youtube"
                                        type="url"
                                        class="mt-1 block w-full"
                                        placeholder="https://youtube.com/@username"
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- SEO Settings -->
                        <div class="space-y-6">
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    Portfolio Page SEO
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Search engine and social media optimization for your portfolio homepage
                                </p>
                            </div>

                            <!-- Basic SEO -->
                            <div class="space-y-4">
                                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Basic SEO</h4>

                                <div>
                                    <InputLabel for="meta_title" value="Meta Title" />
                                    <TextInput
                                        id="meta_title"
                                        v-model="form.meta_title"
                                        type="text"
                                        class="mt-1 block w-full"
                                        maxlength="60"
                                    />
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        {{ form.meta_title?.length || 0 }}/60 characters (optimal: 50-60)
                                    </p>
                                    <InputError :message="form.errors.meta_title" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="meta_description" value="Meta Description" />
                                    <textarea
                                        id="meta_description"
                                        v-model="form.meta_description"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                        rows="3"
                                        maxlength="160"
                                    />
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        {{ form.meta_description?.length || 0 }}/160 characters (optimal: 150-160)
                                    </p>
                                    <InputError :message="form.errors.meta_description" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="meta_keywords" value="Meta Keywords" />
                                    <TextInput
                                        id="meta_keywords"
                                        v-model="form.meta_keywords"
                                        type="text"
                                        class="mt-1 block w-full"
                                        placeholder="developer, portfolio, full stack, web development"
                                    />
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        Comma-separated keywords
                                    </p>
                                    <InputError :message="form.errors.meta_keywords" class="mt-2" />
                                </div>
                            </div>

                            <!-- Open Graph -->
                            <div class="space-y-4">
                                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Open Graph (Facebook, LinkedIn)</h4>

                                <div>
                                    <InputLabel for="og_title" value="OG Title" />
                                    <TextInput
                                        id="og_title"
                                        v-model="form.og_title"
                                        type="text"
                                        class="mt-1 block w-full"
                                        placeholder="Leave empty to use Meta Title"
                                    />
                                    <InputError :message="form.errors.og_title" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="og_description" value="OG Description" />
                                    <textarea
                                        id="og_description"
                                        v-model="form.og_description"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                        rows="3"
                                        placeholder="Leave empty to use Meta Description"
                                    />
                                    <InputError :message="form.errors.og_description" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="og_image" value="OG Image URL" />
                                    <TextInput
                                        id="og_image"
                                        v-model="form.og_image"
                                        type="url"
                                        class="mt-1 block w-full"
                                        placeholder="https://example.com/images/og-image.jpg"
                                    />
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        Recommended size: 1200x630px
                                    </p>
                                    <InputError :message="form.errors.og_image" class="mt-2" />
                                </div>
                            </div>

                            <!-- Twitter Card -->
                            <div class="space-y-4">
                                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Twitter Card</h4>

                                <div>
                                    <InputLabel for="twitter_card" value="Twitter Card Type" />
                                    <select
                                        id="twitter_card"
                                        v-model="form.twitter_card"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    >
                                        <option value="summary">Summary</option>
                                        <option value="summary_large_image">Summary with Large Image</option>
                                    </select>
                                    <InputError :message="form.errors.twitter_card" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="twitter_handle" value="Twitter Handle" />
                                    <TextInput
                                        id="twitter_handle"
                                        v-model="form.twitter_handle"
                                        type="text"
                                        class="mt-1 block w-full"
                                        placeholder="@username"
                                    />
                                    <InputError :message="form.errors.twitter_handle" class="mt-2" />
                                </div>
                            </div>

                            <!-- Advanced SEO -->
                            <div class="space-y-4">
                                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Advanced SEO</h4>

                                <div>
                                    <InputLabel for="canonical_url" value="Canonical URL" />
                                    <TextInput
                                        id="canonical_url"
                                        v-model="form.canonical_url"
                                        type="url"
                                        class="mt-1 block w-full"
                                        placeholder="https://example.com"
                                    />
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        Preferred URL for your portfolio homepage
                                    </p>
                                    <InputError :message="form.errors.canonical_url" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="robots" value="Robots Meta Tag" />
                                    <select
                                        id="robots"
                                        v-model="form.robots"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    >
                                        <option value="">Default (index, follow)</option>
                                        <option value="index, follow">Index, Follow</option>
                                        <option value="noindex, follow">No Index, Follow</option>
                                        <option value="index, nofollow">Index, No Follow</option>
                                        <option value="noindex, nofollow">No Index, No Follow</option>
                                    </select>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        Controls how search engines crawl and index your homepage
                                    </p>
                                    <InputError :message="form.errors.robots" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 pt-4">
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Save Settings
                            </PrimaryButton>
                            <span v-if="form.recentlySuccessful" class="text-sm text-green-600 dark:text-green-400">
                                Settings saved successfully!
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
