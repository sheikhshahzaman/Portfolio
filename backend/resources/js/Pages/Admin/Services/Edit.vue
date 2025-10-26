<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    service: Object,
});

const form = useForm({
    title: props.service.title,
    description: props.service.description,
    icon: props.service.icon || '',
    is_active: props.service.is_active,
    order: props.service.order || 0,
});

const submit = () => {
    form.put(route('admin.services.update', props.service.id));
};
</script>

<template>
    <Head title="Edit Service" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Edit Service
                </h2>
                <Link :href="route('admin.services.index')" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                    Back to Services
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <form @submit.prevent="submit" class="p-6 space-y-6">
                        <div>
                            <InputLabel for="title" value="Service Title *" />
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
                            <InputLabel for="description" value="Description *" />
                            <textarea
                                id="description"
                                v-model="form.description"
                                rows="6"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                required
                            ></textarea>
                            <InputError :message="form.errors.description" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="icon" value="Icon Class (optional)" />
                            <select
                                id="icon"
                                v-model="form.icon"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            >
                                <option value="">-- Select Icon --</option>
                                <option value="code">💻 Code (Blue)</option>
                                <option value="database">🗄️ Database (Purple)</option>
                                <option value="palette">🎨 Palette/Design (Pink)</option>
                                <option value="shopping">🛒 Shopping (Green)</option>
                                <option value="api">⚡ API/Terminal (Yellow)</option>
                                <option value="tools">🔧 Tools/Settings (Red)</option>
                                <option value="rocket">🚀 Rocket (Indigo)</option>
                                <option value="shield">🛡️ Shield/Security (Teal)</option>
                            </select>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Select an icon to display with your service</p>
                            <InputError :message="form.errors.icon" class="mt-2" />
                        </div>

                        <div>
                            <label class="flex items-center">
                                <input
                                    type="checkbox"
                                    v-model="form.is_active"
                                    class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                                />
                                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Active (show on website)</span>
                            </label>
                            <InputError :message="form.errors.is_active" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="order" value="Display Order" />
                            <TextInput
                                id="order"
                                v-model.number="form.order"
                                type="number"
                                class="mt-1 block w-full"
                            />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Lower numbers appear first</p>
                            <InputError :message="form.errors.order" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Update Service
                            </PrimaryButton>
                            <Link :href="route('admin.services.index')" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                Cancel
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
