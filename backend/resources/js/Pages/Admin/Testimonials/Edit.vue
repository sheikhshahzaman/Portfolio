<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Checkbox from '@/Components/Checkbox.vue';

const props = defineProps({
    testimonial: Object,
});

const form = useForm({
    _method: 'PUT',
    client_name: props.testimonial.client_name,
    client_position: props.testimonial.client_position || '',
    client_company: props.testimonial.client_company || '',
    content: props.testimonial.content,
    rating: props.testimonial.rating || '5',
    is_featured: props.testimonial.is_featured,
    order: props.testimonial.order || 0,
    image: null,
});

const handleFileChange = (event) => {
    form.image = event.target.files[0];
};

const submit = () => {
    form.post(route('admin.testimonials.update', props.testimonial.id));
};
</script>

<template>
    <Head title="Edit Testimonial" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Edit Testimonial
                </h2>
                <Link :href="route('admin.testimonials.index')" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                    Back to Testimonials
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <form @submit.prevent="submit" class="p-6 space-y-6">
                        <div>
                            <InputLabel for="client_name" value="Client Name *" />
                            <TextInput
                                id="client_name"
                                v-model="form.client_name"
                                type="text"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError :message="form.errors.client_name" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <InputLabel for="client_position" value="Client Position" />
                                <TextInput
                                    id="client_position"
                                    v-model="form.client_position"
                                    type="text"
                                    class="mt-1 block w-full"
                                    placeholder="e.g., CEO"
                                />
                                <InputError :message="form.errors.client_position" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="client_company" value="Client Company" />
                                <TextInput
                                    id="client_company"
                                    v-model="form.client_company"
                                    type="text"
                                    class="mt-1 block w-full"
                                    placeholder="e.g., Tech Corp"
                                />
                                <InputError :message="form.errors.client_company" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <InputLabel for="content" value="Testimonial Content *" />
                            <textarea
                                id="content"
                                v-model="form.content"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                rows="6"
                                required
                                placeholder="Write the testimonial content here..."
                            />
                            <InputError :message="form.errors.content" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="rating" value="Rating *" />
                            <select
                                id="rating"
                                v-model="form.rating"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            >
                                <option value="5">5 - Excellent</option>
                                <option value="4">4 - Very Good</option>
                                <option value="3">3 - Good</option>
                                <option value="2">2 - Fair</option>
                                <option value="1">1 - Poor</option>
                            </select>
                            <InputError :message="form.errors.rating" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="image" value="Client Photo" />
                            <div v-if="testimonial.media && testimonial.media.length > 0" class="mb-3">
                                <img
                                    :src="'/storage/' + testimonial.media[0].id + '/' + testimonial.media[0].file_name"
                                    :alt="testimonial.client_name"
                                    class="w-24 h-24 object-cover rounded-full border border-gray-300 dark:border-gray-600"
                                />
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Current photo</p>
                            </div>
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

                        <div>
                            <label class="flex items-center">
                                <Checkbox v-model:checked="form.is_featured" />
                                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Featured Testimonial</span>
                            </label>
                        </div>

                        <div class="flex items-center gap-4">
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Update Testimonial
                            </PrimaryButton>
                            <Link :href="route('admin.testimonials.index')" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                Cancel
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
