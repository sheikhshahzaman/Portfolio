<template>
  <div class="min-h-screen py-20 px-4 pt-24">
    <div class="max-w-3xl mx-auto">
      <div v-if="loading" class="text-center py-20">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
      </div>

      <article v-else-if="post" class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-lg">
        <div v-if="post.image_url" class="w-full h-96 overflow-hidden">
          <img
            :src="post.image_url"
            :alt="post.title"
            class="w-full h-full object-cover"
          />
        </div>

        <div class="p-8">
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

          <div class="prose prose-lg dark:prose-invert max-w-none mb-8
                      prose-headings:font-bold prose-headings:text-gray-900 dark:prose-headings:text-gray-100
                      prose-p:text-gray-700 dark:prose-p:text-gray-300
                      prose-a:text-blue-600 dark:prose-a:text-blue-400 prose-a:no-underline hover:prose-a:underline
                      prose-strong:text-gray-900 dark:prose-strong:text-gray-100
                      prose-code:text-pink-600 dark:prose-code:text-pink-400 prose-code:bg-gray-100 dark:prose-code:bg-gray-800 prose-code:px-1 prose-code:py-0.5 prose-code:rounded
                      prose-pre:bg-gray-900 dark:prose-pre:bg-gray-950 prose-pre:text-gray-100
                      prose-blockquote:border-l-blue-600 prose-blockquote:border-l-4 prose-blockquote:pl-4 prose-blockquote:italic
                      prose-img:rounded-lg prose-img:shadow-lg
                      prose-ul:list-disc prose-ol:list-decimal
                      ">
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
import { ref, onMounted, computed } from 'vue'
import { useRoute } from 'vue-router'
import { useHead } from '@unhead/vue'
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

// Reactive meta tags
const currentUrl = computed(() => window.location.href)

useHead(computed(() => {
  if (!post.value) return {}

  return {
    title: post.value.meta_title || post.value.title,
    meta: [
      { name: 'description', content: post.value.meta_description || post.value.excerpt || '' },
      { name: 'keywords', content: post.value.meta_keywords || post.value.tags?.join(', ') || '' },
      { name: 'robots', content: post.value.robots || 'index, follow' },

      // Open Graph
      { property: 'og:type', content: 'article' },
      { property: 'og:title', content: post.value.og_title || post.value.meta_title || post.value.title },
      { property: 'og:description', content: post.value.og_description || post.value.meta_description || post.value.excerpt || '' },
      { property: 'og:image', content: post.value.image_url || '' },
      { property: 'og:url', content: currentUrl.value },
      { property: 'article:published_time', content: post.value.published_at },
      { property: 'article:tag', content: post.value.tags?.join(', ') || '' },

      // Twitter Card
      { name: 'twitter:card', content: post.value.twitter_card || 'summary_large_image' },
      { name: 'twitter:title', content: post.value.og_title || post.value.meta_title || post.value.title },
      { name: 'twitter:description', content: post.value.og_description || post.value.meta_description || post.value.excerpt || '' },
      { name: 'twitter:image', content: post.value.image_url || '' },
    ],
    link: [
      { rel: 'canonical', href: post.value.canonical_url || currentUrl.value },
    ],
  }
}))

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

const formatContent = (content) => {
  // Return HTML content as-is (it's already formatted from the rich text editor)
  return content
}
</script>
