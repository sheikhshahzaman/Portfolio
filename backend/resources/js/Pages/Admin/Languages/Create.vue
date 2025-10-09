<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const form = useForm({
    code: '',
    name: '',
    native_name: '',
    is_default: false,
    is_active: true,
    order: 0,
});

const submit = () => {
    form.post(route('admin.languages.store'));
};
</script>

<template>
    <Head title="Add Language" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-4">
                <Link
                    :href="route('admin.languages.index')"
                    class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </Link>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Add New Language
                </h2>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <form @submit.prevent="submit" class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <InputLabel for="code" value="Language Code" />
                                <TextInput
                                    id="code"
                                    v-model="form.code"
                                    type="text"
                                    class="mt-1 block w-full"
                                    placeholder="en, es, fr, etc."
                                    required
                                />
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    ISO 639-1 language code (2 letters)
                                </p>
                                <InputError :message="form.errors.code" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="name" value="Name (English)" />
                                <TextInput
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    placeholder="English, Spanish, French, etc."
                                    required
                                />
                                <InputError :message="form.errors.name" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="native_name" value="Native Name" />
                                <TextInput
                                    id="native_name"
                                    v-model="form.native_name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    placeholder="English, Español, Français, etc."
                                    required
                                />
                                <InputError :message="form.errors.native_name" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="order" value="Display Order" />
                                <TextInput
                                    id="order"
                                    v-model="form.order"
                                    type="number"
                                    class="mt-1 block w-full"
                                    min="0"
                                />
                                <InputError :message="form.errors.order" class="mt-2" />
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input
                                    id="is_active"
                                    v-model="form.is_active"
                                    type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-900 dark:focus:ring-blue-600"
                                />
                                <label for="is_active" class="ml-2 text-sm text-gray-900 dark:text-gray-100">
                                    Active (visible on frontend)
                                </label>
                            </div>

                            <div class="flex items-center">
                                <input
                                    id="is_default"
                                    v-model="form.is_default"
                                    type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-900 dark:focus:ring-blue-600"
                                />
                                <label for="is_default" class="ml-2 text-sm text-gray-900 dark:text-gray-100">
                                    Set as default language
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 pt-4">
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Create Language
                            </PrimaryButton>
                            <Link
                                :href="route('admin.languages.index')"
                                class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100"
                            >
                                Cancel
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
