<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useHead } from '@unhead/vue'
import { useTranslations } from '../composables/useTranslations'
import { useSolsticeMotion } from '../composables/useMotion'
import { portfolioAPI } from '../services/api'

const { t } = useTranslations()
const router = useRouter()
const root = ref(null)

const posts = ref([])
const page = ref(1)
const lastPage = ref(1)
const loading = ref(true)

const featured = computed(() => posts.value[0] || null)
const rest = computed(() => posts.value.slice(1))

const fmt = (d) => {
  if (!d) return ''
  const date = new Date(d)
  return isNaN(date) ? '' : date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' })
}
const open = (p) => router.push(`/blog/${p.slug}`)

const fetchPage = async (p) => {
  loading.value = true
  try {
    const res = await portfolioAPI.getBlogPosts(p)
    const payload = res.data
    const list = payload.data || payload
    posts.value = p === 1 ? list : [...posts.value, ...list]
    lastPage.value = payload.last_page || 1
    page.value = payload.current_page || p
  } finally {
    loading.value = false
  }
}
const loadMore = () => fetchPage(page.value + 1)

useSolsticeMotion(root)
useHead({
  title: computed(() => `${t('blog.eyebrow', 'Blog')} — Shahzaman`),
  meta: [{ name: 'description', content: 'Notes on systems, architecture and shipping.' }],
})
onMounted(() => fetchPage(1))
</script>

<template>
  <main ref="root">
    <header class="wrap page-head">
      <div class="eyebrow" style="margin-bottom: 20px">{{ t('blog.eyebrow', 'Blog') }}</div>
      <h1>{{ t('blog.heading_a', 'Notes on') }} <span class="grad-text">{{ t('blog.heading_b', 'systems.') }}</span></h1>
      <p class="sub reveal">{{ t('blog.subtitle', 'Short pieces on architecture, scale and shipping.') }}</p>
    </header>

    <section class="wrap section" style="padding-top: 0">
      <div v-if="loading && !posts.length" class="loader"><div class="spinner"></div></div>

      <template v-else-if="posts.length">
        <a class="feat reveal" v-if="featured" @click="open(featured)" style="cursor:pointer">
          <div class="feat__cover">
            <img v-if="featured.image_url" :src="featured.image_url" :alt="featured.title" />
            <span class="badge">{{ featured.category || t('blog.featured', 'Featured') }}</span>
          </div>
          <div class="feat__b">
            <div class="feat__date">{{ fmt(featured.published_at) }}</div>
            <div class="feat__title">{{ featured.title }}</div>
            <p class="feat__ex">{{ featured.excerpt }}</p>
            <span class="lnk" style="margin-top: 18px; color: var(--accent-deep)">{{ t('blog.read_more', 'Read article →') }}</span>
          </div>
        </a>

        <div data-stagger v-if="rest.length">
          <a class="post" v-for="p in rest" :key="p.id" @click="open(p)">
            <div class="post__date">{{ fmt(p.published_at) }}</div>
            <div class="post__title">{{ p.title }}<span>{{ p.excerpt }}</span></div>
            <div class="post__src">{{ p.category || 'Article' }} <span class="arr">→</span></div>
          </a>
        </div>

        <div v-if="page < lastPage" style="text-align:center; margin-top: 36px">
          <button class="btn mag" data-mag="0.25" :disabled="loading" @click="loadMore">
            {{ loading ? t('blog.loading', 'Loading…') : t('blog.load_more', 'Load more') }}
          </button>
        </div>
      </template>

      <div v-else class="empty">{{ t('blog.no_posts', 'No posts yet. Check back soon.') }}</div>
    </section>
  </main>
</template>
