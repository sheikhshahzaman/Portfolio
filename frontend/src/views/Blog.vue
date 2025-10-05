<template>
  <div class="min-h-screen py-20 px-4 pt-24">
    <div class="max-w-4xl mx-auto">
      <h1 class="text-5xl font-bold text-center mb-4 gradient-text">
        Blog
      </h1>
      <p class="text-center text-gray-600 dark:text-gray-400 mb-12">
        Thoughts on web development, technology, and more
      </p>

      <div v-if="loading" class="text-center py-20">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
      </div>

      <div v-else-if="posts.length > 0" class="space-y-8">
        <article
          v-for="post in posts"
          :key="post.id"
          class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition-all"
        >
          <div class="p-6">
            <div class="flex items-center gap-4 mb-3 text-sm text-gray-500 dark:text-gray-400">
              <span>{{ formatDate(post.published_at) }}</span>
              <span>•</span>
              <span>{{ post.views }} views</span>
              <span v-if="post.category" class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 rounded">
                {{ post.category }}
              </span>
            </div>

            <h2 class="text-2xl font-bold mb-3 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
              <router-link :to="`/blog/${post.slug}`">
                {{ post.title }}
              </router-link>
            </h2>

            <p class="text-gray-600 dark:text-gray-400 mb-4">
              {{ post.excerpt }}
            </p>

            <div class="flex items-center justify-between">
              <router-link
                :to="`/blog/${post.slug}`"
                class="text-blue-600 hover:text-blue-700 dark:text-blue-400 font-medium"
              >
                Read More →
              </router-link>

              <div v-if="post.tags" class="flex flex-wrap gap-2">
                <span
                  v-for="tag in post.tags.slice(0, 3)"
                  :key="tag"
                  class="text-xs px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded"
                >
                  #{{ tag }}
                </span>
              </div>
            </div>
          </div>
        </article>
      </div>

      <div v-else class="text-center py-20">
        <p class="text-gray-600 dark:text-gray-400 text-lg">
          No blog posts yet. Check back soon!
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { portfolioAPI } from '../services/api'

const posts = ref([])
const loading = ref(true)

onMounted(async () => {
  try {
    const response = await portfolioAPI.getBlogPosts()
    posts.value = response.data.data || []
  } catch (error) {
    console.error('Error loading blog posts:', error)
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
</script>
