<template>
  <div class="min-h-screen py-20 px-4 pt-24">
    <!-- Reading Progress Bar -->
    <div class="fixed top-16 left-0 right-0 h-1 bg-gray-200 dark:bg-gray-800 z-50">
      <div
        class="h-full bg-gradient-to-r from-blue-600 to-purple-600 transition-all duration-150"
        :style="{ width: readingProgress + '%' }"
      ></div>
    </div>

    <div class="max-w-7xl mx-auto">
      <div v-if="loading" class="text-center py-20">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
      </div>

      <div v-else-if="post" class="lg:grid lg:grid-cols-12 lg:gap-8">
        <!-- Table of Contents - Sidebar -->
        <aside class="hidden lg:block lg:col-span-3">
          <div class="sticky top-24">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 animate-fade-in-left">
              <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                Table of Contents
              </h3>
              <nav class="space-y-2">
                <a
                  v-for="(heading, index) in tableOfContents"
                  :key="index"
                  :href="'#' + heading.id"
                  @click.prevent="scrollToHeading(heading.id)"
                  :class="[
                    'block py-2 px-3 rounded-lg text-sm transition-all duration-200',
                    activeHeading === heading.id
                      ? 'bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 font-medium'
                      : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700',
                    heading.level === 'h3' ? 'pl-6' : ''
                  ]"
                >
                  {{ heading.text }}
                </a>
              </nav>
            </div>
          </div>
        </aside>

        <!-- Main Content -->
        <article class="lg:col-span-9">
          <div class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-lg animate-fade-in-up">
            <div v-if="post.image_url" class="w-full h-96 overflow-hidden">
              <img
                :src="post.image_url"
                :alt="post.title"
                class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-500"
              />
            </div>

            <div class="p-8 lg:p-12">
              <div class="flex items-center gap-4 mb-6 text-sm text-gray-500 dark:text-gray-400 animate-fade-in">
                <span class="flex items-center gap-1">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                  {{ formatDate(post.published_at) }}
                </span>
                <span>•</span>
                <span class="flex items-center gap-1">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                  {{ post.views }} views
                </span>
                <span>•</span>
                <span class="flex items-center gap-1">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  {{ readingTime }} min read
                </span>
                <span v-if="post.category" class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 rounded-full font-medium">
                  {{ post.category }}
                </span>
              </div>

              <h1 class="text-4xl lg:text-5xl font-bold mb-6 animate-fade-in-up animation-delay-100">{{ post.title }}</h1>

              <p class="text-xl text-gray-600 dark:text-gray-400 mb-10 border-l-4 border-blue-600 pl-6 py-4 bg-blue-50 dark:bg-blue-900/20 rounded-r-lg animate-fade-in-up animation-delay-200">
                {{ post.excerpt }}
              </p>

              <!-- Mobile TOC -->
              <div class="lg:hidden mb-8 bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6 animate-fade-in-up animation-delay-300">
                <button
                  @click="showMobileTOC = !showMobileTOC"
                  class="flex items-center justify-between w-full text-left font-semibold"
                >
                  <span class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    Table of Contents
                  </span>
                  <svg
                    class="w-5 h-5 transition-transform duration-200"
                    :class="{ 'rotate-180': showMobileTOC }"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
                </button>
                <nav v-show="showMobileTOC" class="mt-4 space-y-2">
                  <a
                    v-for="(heading, index) in tableOfContents"
                    :key="index"
                    :href="'#' + heading.id"
                    @click="scrollToHeading(heading.id); showMobileTOC = false"
                    :class="[
                      'block py-2 px-3 rounded-lg text-sm transition-all duration-200',
                      heading.level === 'h3' ? 'pl-6' : '',
                      'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700'
                    ]"
                  >
                    {{ heading.text }}
                  </a>
                </nav>
              </div>

              <div
                ref="contentRef"
                class="prose prose-lg dark:prose-invert max-w-none mb-10
                        prose-headings:scroll-mt-24 prose-headings:font-bold prose-headings:text-gray-900 dark:prose-headings:text-gray-100
                        prose-h2:text-3xl prose-h2:mt-12 prose-h2:mb-6 prose-h2:pb-3 prose-h2:border-b prose-h2:border-gray-200 dark:prose-h2:border-gray-700
                        prose-h3:text-2xl prose-h3:mt-8 prose-h3:mb-4
                        prose-p:text-gray-700 dark:prose-p:text-gray-300 prose-p:leading-relaxed prose-p:mb-6
                        prose-a:text-blue-600 dark:prose-a:text-blue-400 prose-a:no-underline hover:prose-a:underline prose-a:font-medium
                        prose-strong:text-gray-900 dark:prose-strong:text-gray-100 prose-strong:font-semibold
                        prose-code:text-pink-600 dark:prose-code:text-pink-400 prose-code:bg-gray-100 dark:prose-code:bg-gray-800 prose-code:px-2 prose-code:py-1 prose-code:rounded prose-code:font-mono prose-code:text-sm
                        prose-pre:bg-gray-900 dark:prose-pre:bg-gray-950 prose-pre:text-gray-100 prose-pre:p-6 prose-pre:rounded-xl prose-pre:shadow-lg
                        prose-blockquote:border-l-blue-600 prose-blockquote:border-l-4 prose-blockquote:pl-6 prose-blockquote:italic prose-blockquote:text-gray-600 dark:prose-blockquote:text-gray-400 prose-blockquote:bg-blue-50 dark:prose-blockquote:bg-blue-900/20 prose-blockquote:py-4 prose-blockquote:rounded-r-lg
                        prose-img:rounded-xl prose-img:shadow-2xl prose-img:my-8
                        prose-ul:my-6 prose-ul:list-disc prose-ul:pl-6
                        prose-ol:my-6 prose-ol:list-decimal prose-ol:pl-6
                        prose-li:my-2 prose-li:text-gray-700 dark:prose-li:text-gray-300
                        prose-table:my-8 prose-table:border prose-table:border-gray-200 dark:prose-table:border-gray-700
                        prose-th:bg-gray-100 dark:prose-th:bg-gray-800 prose-th:p-3 prose-th:font-semibold
                        prose-td:p-3 prose-td:border prose-td:border-gray-200 dark:prose-td:border-gray-700
                        animate-fade-in-up animation-delay-400
                        ">
                <div v-html="formatContent(post.content)"></div>
              </div>

              <div v-if="post.tags" class="flex flex-wrap gap-2 mb-10 animate-fade-in-up animation-delay-500">
                <span
                  v-for="tag in post.tags"
                  :key="tag"
                  class="px-4 py-2 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900 dark:to-purple-900 text-blue-600 dark:text-blue-300 rounded-full font-medium hover:scale-105 transition-transform duration-200 cursor-pointer"
                >
                  #{{ tag }}
                </span>
              </div>

              <div class="border-t border-gray-200 dark:border-gray-700 pt-8 animate-fade-in-up animation-delay-600">
                <router-link
                  to="/blog"
                  class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 dark:text-blue-400 font-medium group"
                >
                  <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                  </svg>
                  Back to Blog
                </router-link>
              </div>
            </div>
          </div>
        </article>
      </div>

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
import { ref, onMounted, computed, nextTick, onUnmounted } from 'vue'
import { useRoute } from 'vue-router'
import { useHead } from '@unhead/vue'
import { portfolioAPI } from '../services/api'

const route = useRoute()
const post = ref(null)
const loading = ref(true)
const contentRef = ref(null)
const tableOfContents = ref([])
const activeHeading = ref('')
const readingProgress = ref(0)
const showMobileTOC = ref(false)

// Calculate reading time (average 200 words per minute)
const readingTime = computed(() => {
  if (!post.value?.content) return 0
  const text = post.value.content.replace(/<[^>]*>/g, '')
  const words = text.split(/\s+/).length
  return Math.ceil(words / 200)
})

// Generate table of contents from headings
const generateTableOfContents = () => {
  if (!contentRef.value) {
    console.log('contentRef is null')
    return
  }

  const headings = contentRef.value.querySelectorAll('h2, h3')
  console.log('Found headings:', headings.length)

  tableOfContents.value = Array.from(headings).map((heading, index) => {
    const id = `heading-${index}`
    heading.id = id
    return {
      id,
      text: heading.textContent,
      level: heading.tagName.toLowerCase()
    }
  })

  console.log('Table of contents:', tableOfContents.value)
}

// Scroll to heading
const scrollToHeading = (id) => {
  const element = document.getElementById(id)
  if (element) {
    const offset = 100
    const elementPosition = element.getBoundingClientRect().top + window.pageYOffset
    window.scrollTo({
      top: elementPosition - offset,
      behavior: 'smooth'
    })
  }
}

// Update active heading on scroll
const updateActiveHeading = () => {
  const headings = tableOfContents.value
  if (!headings.length) return

  const scrollPosition = window.scrollY + 150

  for (let i = headings.length - 1; i >= 0; i--) {
    const heading = document.getElementById(headings[i].id)
    if (heading && heading.offsetTop <= scrollPosition) {
      activeHeading.value = headings[i].id
      return
    }
  }
}

// Calculate reading progress
const updateReadingProgress = () => {
  const windowHeight = window.innerHeight
  const documentHeight = document.documentElement.scrollHeight
  const scrollTop = window.scrollY
  const trackLength = documentHeight - windowHeight
  const percentage = (scrollTop / trackLength) * 100
  readingProgress.value = Math.min(100, Math.max(0, percentage))
}

// Handle scroll
const handleScroll = () => {
  updateActiveHeading()
  updateReadingProgress()
}

onMounted(async () => {
  try {
    const response = await portfolioAPI.getBlogPost(route.params.slug)
    post.value = response.data

    // Wait for DOM to update, then generate TOC with multiple retries
    await nextTick()

    // Try immediately
    generateTableOfContents()

    // Retry after small delays to ensure content is rendered
    setTimeout(generateTableOfContents, 100)
    setTimeout(generateTableOfContents, 300)
    setTimeout(generateTableOfContents, 500)

    window.addEventListener('scroll', handleScroll)
  } catch (error) {
    console.error('Error loading blog post:', error)
  } finally {
    loading.value = false
  }
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
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
