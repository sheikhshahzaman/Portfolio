<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Checkbox from '@/Components/Checkbox.vue';

const form = useForm({
    title: '',
    slug: '',
    short_description: '',
    description: '',
    category: '',
    technologies: [],
    demo_url: '',
    github_url: '',
    is_featured: false,
    is_published: false,
    order: 0,
    image: null,
});

const techInput = ref('');

const addTechnology = () => {
    if (techInput.value.trim()) {
        form.technologies.push(techInput.value.trim());
        techInput.value = '';
    }
};

const removeTechnology = (index) => {
    form.technologies.splice(index, 1);
};

const handleFileChange = (event) => {
    form.image = event.target.files[0];
};

const submit = () => {
    form.post(route('admin.projects.store'));
};
</script>

<template>
    <Head title="Create Project" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Create New Project
                </h2>
                <Link :href="route('admin.projects.index')" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                    Back to Projects
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
                            />
                            <InputError :message="form.errors.slug" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="category" value="Category" />
                            <TextInput
                                id="category"
                                v-model="form.category"
                                type="text"
                                class="mt-1 block w-full"
                            />
                            <InputError :message="form.errors.category" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="short_description" value="Short Description *" />
                            <textarea
                                id="short_description"
                                v-model="form.short_description"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                rows="3"
                                required
                            />
                            <InputError :message="form.errors.short_description" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="description" value="Full Description *" />
                            <textarea
                                id="description"
                                v-model="form.description"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                rows="6"
                                required
                            />
                            <InputError :message="form.errors.description" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="technologies" value="Technologies" />
                            <div class="flex gap-2 mt-1">
                                <TextInput
                                    v-model="techInput"
                                    type="text"
                                    class="flex-1"
                                    placeholder="e.g., Laravel"
                                    @keyup.enter="addTechnology"
                                />
                                <button type="button" @click="addTechnology" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                                    Add
                                </button>
                            </div>
                            <div v-if="form.technologies.length > 0" class="flex flex-wrap gap-2 mt-2">
                                <span
                                    v-for="(tech, index) in form.technologies"
                                    :key="index"
                                    class="inline-flex items-center px-3 py-1 bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200 rounded-full text-sm"
                                >
                                    {{ tech }}
                                    <button type="button" @click="removeTechnology(index)" class="ml-2 text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-200">
                                        ×
                                    </button>
                                </span>
                            </div>
                            <InputError :message="form.errors.technologies" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <InputLabel for="demo_url" value="Demo URL" />
                                <TextInput
                                    id="demo_url"
                                    v-model="form.demo_url"
                                    type="url"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.demo_url" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="github_url" value="GitHub URL" />
                                <TextInput
                                    id="github_url"
                                    v-model="form.github_url"
                                    type="url"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.github_url" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <InputLabel for="image" value="Project Image" />
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

                        <div>
                            <InputLabel for="order" value="Display Order" />
                            <TextInput
                                id="order"
                                v-model="form.order"
                                type="number"
                                class="mt-1 block w-full"
                            />
                            <InputError :message="form.errors.order" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-6">
                            <label class="flex items-center">
                                <Checkbox v-model:checked="form.is_featured" />
                                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Featured Project</span>
                            </label>

                            <label class="flex items-center">
                                <Checkbox v-model:checked="form.is_published" />
                                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Publish</span>
                            </label>
                        </div>

                        <div class="flex items-center gap-4">
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Create Project
                            </PrimaryButton>
                            <Link :href="route('admin.projects.index')" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                Cancel
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
