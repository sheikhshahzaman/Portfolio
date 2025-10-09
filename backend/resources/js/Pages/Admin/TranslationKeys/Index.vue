<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { ref, watch, computed } from 'vue';

const props = defineProps({
    translationKeys: Object,
    languages: Array,
    groups: Array,
    currentLanguageId: Number,
    currentGroup: String,
});

const selectedLanguage = ref(props.currentLanguageId);
const selectedGroup = ref(props.currentGroup || '');
const editMode = ref(false);
const editedValues = ref({});

// Initialize edited values from current data
const initializeEditedValues = () => {
    editedValues.value = {};
    props.translationKeys.data.forEach(key => {
        editedValues.value[key.id] = key.value;
    });
};

const currentLanguage = computed(() => {
    return props.languages.find(l => l.id === selectedLanguage.value);
});

const isDefaultLanguage = computed(() => {
    return currentLanguage.value?.is_default || false;
});

// Watch for filter changes and reload
watch([selectedLanguage, selectedGroup], ([newLang, newGroup]) => {
    router.get(route('admin.translation-keys.index'), {
        language_id: newLang,
        group: newGroup || undefined,
    }, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            editMode.value = false;
            initializeEditedValues();
        }
    });
});

const toggleEditMode = () => {
    if (!editMode.value) {
        initializeEditedValues();
    }
    editMode.value = !editMode.value;
};

const saveAll = () => {
    const translations = Object.entries(editedValues.value).map(([id, value]) => ({
        id: parseInt(id),
        value: value
    }));

    router.post(route('admin.translation-keys.bulk-update'), {
        translations: translations
    }, {
        onSuccess: () => {
            editMode.value = false;
        }
    });
};

const deleteTranslationKey = (id) => {
    if (confirm('Are you sure you want to delete this translation key?')) {
        router.delete(route('admin.translation-keys.destroy', id));
    }
};

// Initialize on mount
initializeEditedValues();
</script>

<template>
    <Head title="Translation Keys" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Translation Keys
                </h2>
                <div class="flex gap-2">
                    <button
                        v-if="selectedGroup && !isDefaultLanguage"
                        @click="toggleEditMode"
                        class="inline-flex items-center rounded-md px-4 py-2 text-sm font-semibold text-white shadow-sm"
                        :class="editMode ? 'bg-gray-600 hover:bg-gray-500' : 'bg-green-600 hover:bg-green-500'"
                    >
                        {{ editMode ? 'Cancel Edit' : 'Bulk Edit' }}
                    </button>
                    <button
                        v-if="editMode"
                        @click="saveAll"
                        class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500"
                    >
                        Save All Changes
                    </button>
                    <Link
                        :href="route('admin.translation-keys.create')"
                        class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500"
                    >
                        Add Translation Key
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Filters -->
                <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label for="language" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Language
                        </label>
                        <select
                            id="language"
                            v-model="selectedLanguage"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"
                        >
                            <option v-for="language in languages" :key="language.id" :value="language.id">
                                {{ language.name }} ({{ language.code }})
                            </option>
                        </select>
                    </div>
                    <div>
                        <label for="group" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Group
                        </label>
                        <select
                            id="group"
                            v-model="selectedGroup"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"
                        >
                            <option value="">All Groups</option>
                            <option v-for="group in groups" :key="group" :value="group">
                                {{ group }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                            Key
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                            Group
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                            Value
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    <tr v-for="translationKey in translationKeys.data" :key="translationKey.id">
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                            <code class="rounded bg-gray-100 px-2 py-1 text-sm dark:bg-gray-700">
                                                {{ translationKey.key }}
                                            </code>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <span class="inline-flex items-center rounded-md bg-blue-100 px-2.5 py-0.5 text-sm font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                {{ translationKey.group }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                            <div v-if="!editMode" class="max-w-md truncate">
                                                {{ translationKey.value }}
                                            </div>
                                            <textarea
                                                v-else
                                                v-model="editedValues[translationKey.id]"
                                                rows="3"
                                                class="w-full max-w-2xl rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"
                                            ></textarea>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                            <Link
                                                :href="route('admin.translation-keys.edit', translationKey.id)"
                                                class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 mr-3"
                                            >
                                                Edit
                                            </Link>
                                            <button
                                                @click="deleteTranslationKey(translationKey.id)"
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                            >
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div v-if="translationKeys.links && translationKeys.links.length > 3" class="mt-6 flex justify-center">
                            <nav class="inline-flex rounded-md shadow-sm">
                                <Link
                                    v-for="(link, index) in translationKeys.links"
                                    :key="index"
                                    :href="link.url || '#'"
                                    :class="[
                                        'px-4 py-2 text-sm border',
                                        link.active
                                            ? 'bg-blue-600 text-white border-blue-600'
                                            : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600',
                                        index === 0 ? 'rounded-l-md' : '',
                                        index === translationKeys.links.length - 1 ? 'rounded-r-md' : '',
                                    ]"
                                    v-html="link.label"
                                    :preserve-scroll="true"
                                />
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
