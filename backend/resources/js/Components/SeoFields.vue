<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

defineProps({
    form: {
        type: Object,
        required: true,
    },
    title: {
        type: String,
        default: '',
    },
    description: {
        type: String,
        default: '',
    },
});
</script>

<template>
    <div class="space-y-6 border-t border-gray-200 dark:border-gray-700 pt-6">
        <div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">SEO & Social Media</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                Optimize how your content appears in search engines and social media. Leave fields empty to use default values.
            </p>
        </div>

        <!-- Meta Title -->
        <div>
            <InputLabel for="meta_title" value="Meta Title" />
            <TextInput
                id="meta_title"
                v-model="form.meta_title"
                type="text"
                class="mt-1 block w-full"
                :placeholder="title || 'Default: Page Title'"
                maxlength="60"
            />
            <div class="mt-1 flex justify-between">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Recommended: 50-60 characters
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ form.meta_title?.length || 0 }}/60
                </p>
            </div>
            <InputError :message="form.errors.meta_title" class="mt-2" />
        </div>

        <!-- Meta Description -->
        <div>
            <InputLabel for="meta_description" value="Meta Description" />
            <textarea
                id="meta_description"
                v-model="form.meta_description"
                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                rows="3"
                :placeholder="description || 'Default: Page Description'"
                maxlength="160"
            />
            <div class="mt-1 flex justify-between">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Recommended: 150-160 characters
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ form.meta_description?.length || 0 }}/160
                </p>
            </div>
            <InputError :message="form.errors.meta_description" class="mt-2" />
        </div>

        <!-- Meta Keywords -->
        <div>
            <InputLabel for="meta_keywords" value="Meta Keywords" />
            <TextInput
                id="meta_keywords"
                v-model="form.meta_keywords"
                type="text"
                class="mt-1 block w-full"
                placeholder="e.g., web development, laravel, vue.js"
            />
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Comma-separated keywords (optional, rarely used by search engines)
            </p>
            <InputError :message="form.errors.meta_keywords" class="mt-2" />
        </div>

        <!-- Canonical URL -->
        <div>
            <InputLabel for="canonical_url" value="Canonical URL" />
            <TextInput
                id="canonical_url"
                v-model="form.canonical_url"
                type="url"
                class="mt-1 block w-full"
                placeholder="https://example.com/page"
            />
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Preferred URL for this content (prevents duplicate content issues)
            </p>
            <InputError :message="form.errors.canonical_url" class="mt-2" />
        </div>

        <!-- Robots Meta -->
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
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Controls how search engines crawl and index this page
            </p>
            <InputError :message="form.errors.robots" class="mt-2" />
        </div>

        <!-- Open Graph Title -->
        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
            <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-3">Open Graph (Facebook, LinkedIn)</h4>

            <div class="mb-4">
                <InputLabel for="og_title" value="OG Title" />
                <TextInput
                    id="og_title"
                    v-model="form.og_title"
                    type="text"
                    class="mt-1 block w-full"
                    :placeholder="form.meta_title || title || 'Default: Meta Title or Page Title'"
                />
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Leave empty to use Meta Title
                </p>
                <InputError :message="form.errors.og_title" class="mt-2" />
            </div>

            <!-- Open Graph Description -->
            <div>
                <InputLabel for="og_description" value="OG Description" />
                <textarea
                    id="og_description"
                    v-model="form.og_description"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    rows="2"
                    :placeholder="form.meta_description || description || 'Default: Meta Description'"
                />
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Leave empty to use Meta Description
                </p>
                <InputError :message="form.errors.og_description" class="mt-2" />
            </div>
        </div>

        <!-- Twitter Card Type -->
        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
            <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-3">Twitter Card</h4>

            <div>
                <InputLabel for="twitter_card" value="Card Type" />
                <select
                    id="twitter_card"
                    v-model="form.twitter_card"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                >
                    <option value="summary_large_image">Summary with Large Image</option>
                    <option value="summary">Summary</option>
                </select>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    How your content will appear on Twitter/X
                </p>
                <InputError :message="form.errors.twitter_card" class="mt-2" />
            </div>
        </div>

        <!-- Preview Note -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-md p-4">
            <p class="text-sm text-blue-800 dark:text-blue-300">
                <strong>Note:</strong> Featured image will be used as OG image and Twitter card image automatically.
            </p>
        </div>
    </div>
</template>
