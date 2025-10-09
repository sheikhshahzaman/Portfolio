<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    message: Object,
});

const markAsRead = () => {
    router.post(route('admin.contact-messages.mark-read', props.message.id));
};

const markAsUnread = () => {
    router.post(route('admin.contact-messages.mark-unread', props.message.id));
};

const deleteMessage = () => {
    if (confirm('Are you sure you want to delete this message?')) {
        router.delete(route('admin.contact-messages.destroy', props.message.id));
    }
};

const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};
</script>

<template>
    <Head :title="`Message from ${message.name}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <Link
                        :href="route('admin.contact-messages.index')"
                        class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </Link>
                    <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                        Contact Message
                    </h2>
                </div>
                <div class="flex gap-2">
                    <button
                        v-if="message.is_read"
                        @click="markAsUnread"
                        type="button"
                        class="inline-flex items-center rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500"
                    >
                        Mark as Unread
                    </button>
                    <button
                        v-else
                        @click="markAsRead"
                        type="button"
                        class="inline-flex items-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500"
                    >
                        Mark as Read
                    </button>
                    <button
                        @click="deleteMessage"
                        type="button"
                        class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6 space-y-6">
                        <!-- Status Badge -->
                        <div v-if="!message.is_read" class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                            Unread Message
                        </div>

                        <!-- Sender Information -->
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                                    <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ message.name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                    <a
                                        :href="`mailto:${message.email}`"
                                        class="mt-1 text-lg text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 inline-block"
                                    >
                                        {{ message.email }}
                                    </a>
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Received</label>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ formatDate(message.created_at) }}</p>
                            </div>
                        </div>

                        <!-- Subject -->
                        <div v-if="message.subject" class="border-b border-gray-200 dark:border-gray-700 pb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subject</label>
                            <p class="mt-2 text-lg font-medium text-gray-900 dark:text-gray-100">{{ message.subject }}</p>
                        </div>

                        <!-- Message Content -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Message</label>
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
                                <p class="text-gray-900 dark:text-gray-100 whitespace-pre-wrap leading-relaxed">{{ message.message }}</p>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Quick Actions</h3>
                            <div class="flex gap-3">
                                <a
                                    :href="`mailto:${message.email}?subject=Re: ${message.subject || 'Your message'}`"
                                    class="inline-flex items-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500"
                                >
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    Reply via Email
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
