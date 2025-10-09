<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    messages: Object,
    unreadCount: Number,
});

const deleteMessage = (id) => {
    if (confirm('Are you sure you want to delete this message?')) {
        router.delete(route('admin.contact-messages.destroy', id));
    }
};

const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};
</script>

<template>
    <Head title="Contact Messages" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                        Contact Messages
                    </h2>
                    <p v-if="unreadCount > 0" class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        You have {{ unreadCount }} unread message{{ unreadCount !== 1 ? 's' : '' }}
                    </p>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6">
                        <div v-if="messages.data.length === 0" class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No messages</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">No contact messages have been received yet.</p>
                        </div>

                        <div v-else class="space-y-4">
                            <div
                                v-for="message in messages.data"
                                :key="message.id"
                                class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
                                :class="{ 'bg-blue-50 dark:bg-blue-900/20': !message.is_read }"
                            >
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3">
                                            <Link
                                                :href="route('admin.contact-messages.show', message.id)"
                                                class="text-lg font-semibold text-gray-900 dark:text-gray-100 hover:text-blue-600 dark:hover:text-blue-400"
                                            >
                                                {{ message.name }}
                                            </Link>
                                            <span
                                                v-if="!message.is_read"
                                                class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-200"
                                            >
                                                New
                                            </span>
                                        </div>
                                        <div class="mt-1 flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                                            <span>{{ message.email }}</span>
                                            <span>•</span>
                                            <span>{{ formatDate(message.created_at) }}</span>
                                        </div>
                                        <div v-if="message.subject" class="mt-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Subject: {{ message.subject }}
                                        </div>
                                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                                            {{ message.message }}
                                        </p>
                                    </div>
                                    <div class="flex gap-2 ml-4">
                                        <Link
                                            :href="route('admin.contact-messages.show', message.id)"
                                            class="inline-flex items-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500"
                                        >
                                            View
                                        </Link>
                                        <button
                                            @click="deleteMessage(message.id)"
                                            type="button"
                                            class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div v-if="messages.links.length > 3" class="mt-6 flex justify-center">
                            <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm">
                                <template v-for="(link, index) in messages.links" :key="index">
                                    <Link
                                        v-if="link.url"
                                        :href="link.url"
                                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium"
                                        :class="{
                                            'z-10 bg-blue-600 text-white': link.active,
                                            'text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700': !link.active,
                                            'rounded-l-md': index === 0,
                                            'rounded-r-md': index === messages.links.length - 1
                                        }"
                                        v-html="link.label"
                                    />
                                    <span
                                        v-else
                                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-white dark:bg-gray-800 cursor-not-allowed"
                                        :class="{
                                            'rounded-l-md': index === 0,
                                            'rounded-r-md': index === messages.links.length - 1
                                        }"
                                        v-html="link.label"
                                    />
                                </template>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
