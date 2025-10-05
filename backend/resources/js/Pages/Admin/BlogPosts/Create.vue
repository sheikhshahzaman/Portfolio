<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Checkbox from '@/Components/Checkbox.vue';
import { ref } from 'vue';

const form = useForm({
    title: '',
    slug: '',
    excerpt: '',
    content: '',
    tags: [],
    is_published: false,
    published_at: '',
    image: null,
});

const tagInput = ref('');

const addTag = () => {
    if (tagInput.value.trim()) {
        form.tags.push(tagInput.value.trim());
        tagInput.value = '';
    }
};

const removeTag = (index) => {
    form.tags.splice(index, 1);
};

const handleFileChange = (event) => {
    form.image = event.target.files[0];
};

const submit = () => {
    form.post(route('admin.blog-posts.store'));
};
</script>

<template>
    <Head title="Create Blog Post" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Create New Blog Post
                </h2>
                <Link :href="route('admin.blog-posts.index')" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                    Back to Blog Posts
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <form @submit.prevent="submit" class="p-6 space-y-6">
                        <div>
                            <InputLabel for="title" value="Title *" />
                            <TextInput
                                id="title"
                                v-model="form.title"
                                type="text"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError :message="form.errors.title" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="slug" value="Slug (leave empty to auto-generate)" />
                            <TextInput
                                id="slug"
                                v-model="form.slug"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="url-friendly-slug"
                            />
                            <InputError :message="form.errors.slug" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="excerpt" value="Excerpt" />
                            <textarea
                                id="excerpt"
                                v-model="form.excerpt"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                rows="3"
                                placeholder="A brief summary of the blog post..."
                            />
                            <InputError :message="form.errors.excerpt" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="content" value="Content *" />
                            <textarea
                                id="content"
                                v-model="form.content"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm font-mono text-sm"
                                rows="15"
                                required
                                placeholder="Write your blog post content here... You can use Markdown for formatting."
                            />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Supports Markdown formatting
                            </p>
                            <InputError :message="form.errors.content" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="tags" value="Tags" />
                            <div class="flex gap-2 mt-1">
                                <TextInput
                                    v-model="tagInput"
                                    type="text"
                                    class="flex-1"
                                    placeholder="e.g., Laravel, Vue.js"
                                    @keyup.enter="addTag"
                                />
                                <button type="button" @click="addTag" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                                    Add
                                </button>
                            </div>
                            <div v-if="form.tags.length > 0" class="flex flex-wrap gap-2 mt-2">
                                <span
                                    v-for="(tag, index) in form.tags"
                                    :key="index"
                                    class="inline-flex items-center px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-sm"
                                >
                                    {{ tag }}
                                    <button type="button" @click="removeTag(index)" class="ml-2 text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200">
                                        ×
                                    </button>
                                </span>
                            </div>
                            <InputError :message="form.errors.tags" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="image" value="Featured Image" />
                            <input
                                id="image"
                                type="file"
                                @change="handleFileChange"
                                accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-indigo-50 file:text-indigo-700
                                    hover:file:bg-indigo-100
                                    dark:file:bg-indigo-900 dark:file:text-indigo-300"
                            />
                            <InputError :message="form.errors.image" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-6">
                            <div class="flex-1">
                                <InputLabel for="published_at" value="Publish Date" />
                                <TextInput
                                    id="published_at"
                                    v-model="form.published_at"
                                    type="datetime-local"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.published_at" class="mt-2" />
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Leave empty to use current date when publishing
                                </p>
                            </div>
                        </div>

                        <div>
                            <label class="flex items-center">
                                <Checkbox v-model:checked="form.is_published" />
                                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Publish Immediately</span>
                            </label>
                        </div>

                        <div class="flex items-center gap-4">
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Create Blog Post
                            </PrimaryButton>
                            <Link :href="route('admin.blog-posts.index')" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                Cancel
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
