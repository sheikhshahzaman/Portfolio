<template>
  <div class="min-h-screen py-20 px-4 pt-24">
    <div class="max-w-3xl mx-auto">
      <div v-if="loading" class="text-center py-20">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
      </div>

      <article v-else-if="post" class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-lg p-8">
        <div class="flex items-center gap-4 mb-4 text-sm text-gray-500 dark:text-gray-400">
          <span>{{ formatDate(post.published_at) }}</span>
          <span>•</span>
          <span>{{ post.views }} views</span>
          <span v-if="post.category" class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 rounded">
            {{ post.category }}
          </span>
        </div>

        <h1 class="text-4xl font-bold mb-6">{{ post.title }}</h1>

        <p class="text-xl text-gray-600 dark:text-gray-400 mb-8 border-l-4 border-blue-600 pl-4">
          {{ post.excerpt }}
        </p>

        <div class="prose dark:prose-invert max-w-none mb-8">
          <div v-html="formatContent(post.content)"></div>
        </div>

        <div v-if="post.tags" class="flex flex-wrap gap-2 mb-8">
          <span
            v-for="tag in post.tags"
            :key="tag"
            class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 rounded-full"
          >
            #{{ tag }}
          </span>
        </div>

        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
          <router-link
            to="/blog"
            class="text-blue-600 hover:text-blue-700 dark:text-blue-400 font-medium"
          >
            ← Back to Blog
          </router-link>
        </div>
      </article>

      <div v-else class="text-center py-20">
        <h2 class="text-2xl font-bold mb-4">Post Not Found</h2>
        <router-link to="/blog" class="text-blue-600 hover:text-blue-700">
          ← Back to Blog
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { portfolioAPI } from '../services/api'

const route = useRoute()
const post = ref(null)
const loading = ref(true)

onMounted(async () => {
  try {
    const response = await portfolioAPI.getBlogPost(route.params.slug)
    post.value = response.data
  } catch (error) {
    console.error('Error loading blog post:', error)
  } finally {
    loading.value = false
  }
})

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

const formatContent = (content) => {
  // Simple line break formatting
  return content.replace(/\n/g, '<br>')
}
</script>
