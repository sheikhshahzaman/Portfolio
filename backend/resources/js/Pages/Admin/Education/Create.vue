<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Checkbox from '@/Components/Checkbox.vue';

const form = useForm({
    institution: '',
    degree: '',
    field_of_study: '',
    start_date: '',
    end_date: '',
    is_current: false,
    description: '',
    grade: '',
    order: 0,
});

const submit = () => {
    form.post(route('admin.education.store'));
};
</script>

<template>
    <Head title="Create Education Entry" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Create New Education Entry
                </h2>
                <Link :href="route('admin.education.index')" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                    Back to Education
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <form @submit.prevent="submit" class="p-6 space-y-6">
                        <div>
                            <InputLabel for="institution" value="Institution *" />
                            <TextInput
                                id="institution"
                                v-model="form.institution"
                                type="text"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError :message="form.errors.institution" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <InputLabel for="degree" value="Degree *" />
                                <TextInput
                                    id="degree"
                                    v-model="form.degree"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                    placeholder="e.g., Bachelor of Science"
                                />
                                <InputError :message="form.errors.degree" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="field_of_study" value="Field of Study *" />
                                <TextInput
                                    id="field_of_study"
                                    v-model="form.field_of_study"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                    placeholder="e.g., Computer Science"
                                />
                                <InputError :message="form.errors.field_of_study" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <InputLabel for="start_date" value="Start Date *" />
                                <TextInput
                                    id="start_date"
                                    v-model="form.start_date"
                                    type="date"
                                    class="mt-1 block w-full"
                                    required
                                />
                                <InputError :message="form.errors.start_date" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="end_date" value="End Date" />
                                <TextInput
                                    id="end_date"
                                    v-model="form.end_date"
                                    type="date"
                                    class="mt-1 block w-full"
                                    :disabled="form.is_current"
                                />
                                <InputError :message="form.errors.end_date" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <label class="flex items-center">
                                <Checkbox v-model:checked="form.is_current" />
                                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Currently Studying</span>
                            </label>
                        </div>

                        <div>
                            <InputLabel for="grade" value="Grade / GPA" />
                            <TextInput
                                id="grade"
                                v-model="form.grade"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="e.g., 3.8/4.0 or First Class"
                            />
                            <InputError :message="form.errors.grade" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="description" value="Description" />
                            <textarea
                                id="description"
                                v-model="form.description"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                rows="4"
                                placeholder="Relevant coursework, achievements, activities, etc."
                            />
                            <InputError :message="form.errors.description" class="mt-2" />
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

                        <div class="flex items-center gap-4">
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Create Education Entry
                            </PrimaryButton>
                            <Link :href="route('admin.education.index')" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                Cancel
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
