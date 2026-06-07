<script setup>
import { ref, computed, onMounted, onBeforeUnmount, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useHead } from '@unhead/vue'
import { useTranslations } from '../composables/useTranslations'
import { useSolsticeMotion } from '../composables/useMotion'
import { portfolioAPI } from '../services/api'

const { t } = useTranslations()
const route = useRoute()
const router = useRouter()
const root = ref(null)

const post = ref(null)
const loading = ref(true)
const notFound = ref(false)
const progress = ref(0)

const fmt = (d) => {
  if (!d) return ''
  const date = new Date(d)
  return isNaN(date) ? '' : date.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })
}
const readingTime = computed(() => {
  if (!post.value?.content) return 0
  const words = post.value.content.replace(/<[^>]+>/g, ' ').split(/\s+/).filter(Boolean).length
  return Math.max(1, Math.round(words / 200))
})

const onScroll = () => {
  const h = document.documentElement
  const max = h.scrollHeight - h.clientHeight
  progress.value = max > 0 ? Math.min(100, (h.scrollTop || window.scrollY) / max * 100) : 0
}

const load = async (slug) => {
  loading.value = true
  notFound.value = false
  post.value = null
  try {
    const res = await portfolioAPI.getBlogPost(slug)
    post.value = res.data
  } catch (e) {
    notFound.value = true
  } finally {
    loading.value = false
  }
}

useSolsticeMotion(root)
useHead({
  title: computed(() => (post.value ? `${post.value.meta_title || post.value.title} — Shahzaman` : 'Article — Shahzaman')),
  meta: computed(() => [
    { name: 'description', content: post.value?.meta_description || post.value?.excerpt || '' },
    { property: 'og:title', content: post.value?.og_title || post.value?.title || '' },
    { property: 'og:image', content: post.value?.image_url || '' },
    { property: 'og:type', content: 'article' },
  ]),
})

onMounted(() => {
  load(route.params.slug)
  window.addEventListener('scroll', onScroll, { passive: true })
})
onBeforeUnmount(() => window.removeEventListener('scroll', onScroll))
watch(() => route.params.slug, (s) => s && load(s))
</script>

<template>
  <main ref="root">
    <div class="read-progress" :style="{ width: progress + '%' }"></div>

    <div v-if="loading" class="loader"><div class="spinner"></div></div>

    <template v-else-if="notFound">
      <header class="wrap page-head">
        <div class="eyebrow" style="margin-bottom: 20px">404</div>
        <h1>{{ t('blog.post_not_found', 'Post Not Found') }}</h1>
        <div style="margin-top: 28px">
          <button class="btn mag" data-mag="0.3" @click="router.push('/blog')">{{ t('blog.back_to_blog', '← Back to Blog') }}</button>
        </div>
      </header>
    </template>

    <template v-else-if="post">
      <header class="wrap page-head" style="text-align:center; max-width: 840px; margin: 0 auto">
        <div class="eyebrow center" style="margin-bottom: 18px">{{ post.category || t('blog.eyebrow', 'Blog') }}</div>
        <h1 style="font-size: clamp(2.2rem,5.5vw,4rem)">{{ post.title }}</h1>
        <p class="dim" style="margin-top: 18px; font-family: var(--mono); font-size: 0.8rem">
          {{ fmt(post.published_at) }} · {{ readingTime }} {{ t('blog.min_read', 'min read') }}
        </p>
      </header>

      <article class="wrap section" style="padding-top: clamp(20px,3vh,40px)">
        <div class="article__cover" v-if="post.image_url">
          <img :src="post.image_url" :alt="post.title" />
        </div>

        <div class="article">
          <div class="prose" v-html="post.content"></div>

          <div class="pd-meta" v-if="post.tags && post.tags.length" style="margin-top: clamp(28px,4vh,44px)">
            <span v-for="tag in post.tags" :key="tag">#{{ tag }}</span>
          </div>

          <div style="margin-top: clamp(28px,4vh,44px)">
            <button class="btn mag" data-mag="0.3" @click="router.push('/blog')">{{ t('blog.back_to_blog', '← Back to Blog') }}</button>
          </div>
        </div>
      </article>
    </template>
  </main>
</template>
