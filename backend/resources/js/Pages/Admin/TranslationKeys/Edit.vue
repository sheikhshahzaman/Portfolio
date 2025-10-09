<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    translationKey: Object,
    languages: Array,
    groups: Array,
});

const form = useForm({
    key: props.translationKey.key,
    language_id: props.translationKey.language_id,
    value: props.translationKey.value,
    group: props.translationKey.group,
    description: props.translationKey.description || '',
});

const submit = () => {
    form.put(route('admin.translation-keys.update', props.translationKey.id));
};
</script>

<template>
    <Head title="Edit Translation Key" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Edit Translation Key
                </h2>
                <Link
                    :href="route('admin.translation-keys.index')"
                    class="inline-flex items-center rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500"
                >
                    Back to List
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <form @submit.prevent="submit" class="p-6 space-y-6">
                        <!-- Language -->
                        <div>
                            <label for="language_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Language <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="language_id"
                                v-model="form.language_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"
                                required
                            >
                                <option v-for="language in languages" :key="language.id" :value="language.id">
                                    {{ language.name }} ({{ language.code }})
                                </option>
                            </select>
                            <p v-if="form.errors.language_id" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                {{ form.errors.language_id }}
                            </p>
                        </div>

                        <!-- Group -->
                        <div>
                            <label for="group" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Group <span class="text-red-500">*</span>
                            </label>
                            <input
                                id="group"
                                v-model="form.group"
                                type="text"
                                list="groups-list"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"
                                placeholder="e.g., nav, hero, contact"
                                required
                            />
                            <datalist id="groups-list">
                                <option v-for="group in groups" :key="group" :value="group" />
                            </datalist>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Use existing group or create a new one
                            </p>
                            <p v-if="form.errors.group" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                {{ form.errors.group }}
                            </p>
                        </div>

                        <!-- Key -->
                        <div>
                            <label for="key" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Key <span class="text-red-500">*</span>
                            </label>
                            <input
                                id="key"
                                v-model="form.key"
                                type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"
                                placeholder="e.g., nav.home or hero.greeting"
                                required
                            />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Full key with group prefix (e.g., group.keyname)
                            </p>
                            <p v-if="form.errors.key" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                {{ form.errors.key }}
                            </p>
                        </div>

                        <!-- Value -->
                        <div>
                            <label for="value" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Value <span class="text-red-500">*</span>
                            </label>
                            <textarea
                                id="value"
                                v-model="form.value"
                                rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"
                                placeholder="The translated text"
                                required
                            ></textarea>
                            <p v-if="form.errors.value" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                {{ form.errors.value }}
                            </p>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Description (Optional)
                            </label>
                            <input
                                id="description"
                                v-model="form.description"
                                type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"
                                placeholder="Description for admins"
                            />
                            <p v-if="form.errors.description" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                {{ form.errors.description }}
                            </p>
                        </div>

                        <!-- Submit -->
                        <div class="flex items-center justify-end gap-4">
                            <Link
                                :href="route('admin.translation-keys.index')"
                                class="inline-flex items-center rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600"
                            >
                                Cancel
                            </Link>
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 disabled:opacity-50"
                            >
                                Update Translation Key
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
