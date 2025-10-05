<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Checkbox from '@/Components/Checkbox.vue';

const props = defineProps({
    experience: Object,
});

const form = useForm({
    company: props.experience.company,
    position: props.experience.position,
    location: props.experience.location || '',
    start_date: props.experience.start_date,
    end_date: props.experience.end_date || '',
    is_current: props.experience.is_current,
    description: props.experience.description || '',
    achievements: props.experience.achievements || [],
    order: props.experience.order || 0,
});

const achievementInput = ref('');

const addAchievement = () => {
    if (achievementInput.value.trim()) {
        form.achievements.push(achievementInput.value.trim());
        achievementInput.value = '';
    }
};

const removeAchievement = (index) => {
    form.achievements.splice(index, 1);
};

const submit = () => {
    form.put(route('admin.experiences.update', props.experience.id));
};
</script>

<template>
    <Head title="Edit Experience" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Edit Experience
                </h2>
                <Link :href="route('admin.experiences.index')" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                    Back to Experiences
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <form @submit.prevent="submit" class="p-6 space-y-6">
                        <div>
                            <InputLabel for="company" value="Company *" />
                            <TextInput
                                id="company"
                                v-model="form.company"
                                type="text"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError :message="form.errors.company" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="position" value="Position *" />
                            <TextInput
                                id="position"
                                v-model="form.position"
                                type="text"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError :message="form.errors.position" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="location" value="Location" />
                            <TextInput
                                id="location"
                                v-model="form.location"
                                type="text"
                                class="mt-1 block w-full"
                            />
                            <InputError :message="form.errors.location" class="mt-2" />
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
                                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Currently working here</span>
                            </label>
                        </div>

                        <div>
                            <InputLabel for="description" value="Description" />
                            <textarea
                                id="description"
                                v-model="form.description"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                rows="4"
                            />
                            <InputError :message="form.errors.description" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="achievements" value="Key Achievements" />
                            <div class="flex gap-2 mt-1">
                                <TextInput
                                    v-model="achievementInput"
                                    type="text"
                                    class="flex-1"
                                    placeholder="Add an achievement"
                                    @keyup.enter="addAchievement"
                                />
                                <button type="button" @click="addAchievement" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                                    Add
                                </button>
                            </div>
                            <div v-if="form.achievements.length > 0" class="mt-3 space-y-2">
                                <div
                                    v-for="(achievement, index) in form.achievements"
                                    :key="index"
                                    class="flex items-start gap-2 p-3 bg-gray-50 dark:bg-gray-700 rounded"
                                >
                                    <span class="flex-1 text-sm text-gray-700 dark:text-gray-300">{{ achievement }}</span>
                                    <button type="button" @click="removeAchievement(index)" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200">
                                        ×
                                    </button>
                                </div>
                            </div>
                            <InputError :message="form.errors.achievements" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="order" value="Display Order" />
                            <TextInput
                                id="order"
                                v-model.number="form.order"
                                type="number"
                                class="mt-1 block w-full"
                            />
                            <InputError :message="form.errors.order" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Update Experience
                            </PrimaryButton>
                            <Link :href="route('admin.experiences.index')" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                Cancel
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
