<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    settings: Object,
});

// Flatten settings for form
const flatSettings = {};
Object.values(props.settings).forEach(group => {
    group.forEach(setting => {
        flatSettings[setting.key] = setting.value;
    });
});

const form = useForm({
    settings: flatSettings,
});

const submit = () => {
    form.post(route('admin.settings.update'));
};

// Get setting by key
const getSetting = (key, defaultValue = '') => {
    return form.settings[key] || defaultValue;
};

// Parse JSON safely
const parseJSON = (value, defaultValue = {}) => {
    try {
        return typeof value === 'string' ? JSON.parse(value) : value;
    } catch {
        return defaultValue;
    }
};

const socialLinks = parseJSON(getSetting('social_links'), {});
</script>

<template>
    <Head title="Settings" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Site Settings
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <form @submit.prevent="submit" class="p-6 space-y-8">
                        <!-- Profile Information -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Profile Information</h3>

                            <div>
                                <InputLabel for="name" value="Name" />
                                <TextInput
                                    id="name"
                                    v-model="form.settings.name"
                                    type="text"
                                    class="mt-1 block w-full"
                                />
                            </div>

                            <div>
                                <InputLabel for="title" value="Professional Title" />
                                <TextInput
                                    id="title"
                                    v-model="form.settings.title"
                                    type="text"
                                    class="mt-1 block w-full"
                                />
                            </div>

                            <div>
                                <InputLabel for="bio" value="Bio" />
                                <textarea
                                    id="bio"
                                    v-model="form.settings.bio"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    rows="4"
                                />
                            </div>

                            <div>
                                <InputLabel for="email" value="Email" />
                                <TextInput
                                    id="email"
                                    v-model="form.settings.email"
                                    type="email"
                                    class="mt-1 block w-full"
                                />
                            </div>

                            <div>
                                <InputLabel for="phone" value="Phone" />
                                <TextInput
                                    id="phone"
                                    v-model="form.settings.phone"
                                    type="text"
                                    class="mt-1 block w-full"
                                />
                            </div>

                            <div>
                                <InputLabel for="location" value="Location" />
                                <TextInput
                                    id="location"
                                    v-model="form.settings.location"
                                    type="text"
                                    class="mt-1 block w-full"
                                />
                            </div>
                        </div>

                        <!-- Social Links -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Social Links</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Enter full URLs for your social media profiles</p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <InputLabel for="github_url" value="GitHub URL" />
                                    <TextInput
                                        id="github_url"
                                        v-model="socialLinks.github"
                                        type="url"
                                        class="mt-1 block w-full"
                                        placeholder="https://github.com/username"
                                    />
                                </div>

                                <div>
                                    <InputLabel for="linkedin_url" value="LinkedIn URL" />
                                    <TextInput
                                        id="linkedin_url"
                                        v-model="socialLinks.linkedin"
                                        type="url"
                                        class="mt-1 block w-full"
                                        placeholder="https://linkedin.com/in/username"
                                    />
                                </div>

                                <div>
                                    <InputLabel for="twitter_url" value="Twitter/X URL" />
                                    <TextInput
                                        id="twitter_url"
                                        v-model="socialLinks.twitter"
                                        type="url"
                                        class="mt-1 block w-full"
                                        placeholder="https://twitter.com/username"
                                    />
                                </div>

                                <div>
                                    <InputLabel for="instagram_url" value="Instagram URL" />
                                    <TextInput
                                        id="instagram_url"
                                        v-model="socialLinks.instagram"
                                        type="url"
                                        class="mt-1 block w-full"
                                        placeholder="https://instagram.com/username"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 pt-4">
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Save Settings
                            </PrimaryButton>
                            <span v-if="form.recentlySuccessful" class="text-sm text-green-600 dark:text-green-400">
                                Settings saved successfully!
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
