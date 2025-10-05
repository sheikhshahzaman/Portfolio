<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    skill: Object,
});

const form = useForm({
    name: props.skill.name,
    category: props.skill.category,
    proficiency: props.skill.proficiency,
    icon: props.skill.icon || '',
    order: props.skill.order || 0,
});

const categories = ['Backend', 'Frontend', 'Database', 'DevOps', 'Tools', 'Other'];

const submit = () => {
    form.put(route('admin.skills.update', props.skill.id));
};
</script>

<template>
    <Head title="Edit Skill" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Edit Skill
                </h2>
                <Link :href="route('admin.skills.index')" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                    Back to Skills
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <form @submit.prevent="submit" class="p-6 space-y-6">
                        <div>
                            <InputLabel for="name" value="Skill Name *" />
                            <TextInput
                                id="name"
                                v-model="form.name"
                                type="text"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError :message="form.errors.name" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="category" value="Category *" />
                            <select
                                id="category"
                                v-model="form.category"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                required
                            >
                                <option v-for="cat in categories" :key="cat" :value="cat">
                                    {{ cat }}
                                </option>
                            </select>
                            <InputError :message="form.errors.category" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="proficiency" value="Proficiency (0-100)" />
                            <div class="flex items-center gap-4">
                                <input
                                    id="proficiency"
                                    v-model.number="form.proficiency"
                                    type="range"
                                    min="0"
                                    max="100"
                                    class="flex-1"
                                />
                                <span class="text-sm text-gray-600 dark:text-gray-400 min-w-[40px]">
                                    {{ form.proficiency }}%
                                </span>
                            </div>
                            <InputError :message="form.errors.proficiency" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="icon" value="Icon Class (optional)" />
                            <TextInput
                                id="icon"
                                v-model="form.icon"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="e.g., devicon-laravel-plain"
                            />
                            <InputError :message="form.errors.icon" class="mt-2" />
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
                                Update Skill
                            </PrimaryButton>
                            <Link :href="route('admin.skills.index')" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                Cancel
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
