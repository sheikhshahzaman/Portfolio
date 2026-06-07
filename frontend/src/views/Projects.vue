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

const projects = ref([])
const loading = ref(true)
const activeCat = ref('All')

const categories = computed(() => {
  const cats = new Set(projects.value.map((p) => p.category).filter(Boolean))
  return ['All', ...cats]
})
const filtered = computed(() =>
  activeCat.value === 'All' ? projects.value : projects.value.filter((p) => p.category === activeCat.value)
)
const coverClass = (i) => ['', 'v2', 'v3', 'v4', 'v5', 'v6'][i % 6]
const open = (p) => router.push(`/projects/${p.slug}`)

useSolsticeMotion(root)
useHead({
  title: computed(() => `${t('projects.page_eyebrow', 'Selected Work')} — Shahzaman`),
  meta: [{ name: 'description', content: 'Selected systems shipped — AI platforms at scale, healthcare SaaS, event-driven services.' }],
})

onMounted(async () => {
  try {
    const res = await portfolioAPI.getProjects()
    projects.value = res.data || []
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <main ref="root">
    <header class="wrap page-head">
      <div class="eyebrow" style="margin-bottom: 20px">{{ t('projects.page_eyebrow', 'Selected Work') }}</div>
      <h1>{{ t('projects.page_heading_a', 'Things I have') }} <span class="grad-text">{{ t('projects.page_heading_b', 'shipped.') }}</span></h1>
      <p class="sub reveal">{{ t('projects.page_subtitle', 'Real systems where the architecture was the point. The problem, what I built, and what it moved.') }}</p>
    </header>

    <section class="wrap section" style="padding-top: 0">
      <div v-if="loading" class="loader"><div class="spinner"></div></div>

      <template v-else>
        <div v-if="categories.length > 2" style="display:flex; flex-wrap:wrap; gap:8px; margin-bottom: clamp(24px,4vh,40px)">
          <button
            v-for="cat in categories"
            :key="cat"
            class="btn btn--sm"
            :class="{ 'btn--solid': activeCat === cat }"
            @click="activeCat = cat"
          >{{ cat }}</button>
        </div>

        <div class="proj-grid" data-stagger v-if="filtered.length">
          <a class="card proj" v-for="(p, i) in filtered" :key="p.id" @click="open(p)">
            <div class="proj__cover" :class="coverClass(i)">
              <img v-if="p.image_url" :src="p.image_url" :alt="p.title" loading="lazy" />
              <span class="badge">{{ p.category || 'Project' }}</span>
            </div>
            <div class="proj__b">
              <h3 class="proj__title">{{ p.title }}</h3>
              <p class="proj__desc">{{ p.short_description }}</p>
              <div class="proj__tags" v-if="p.technologies && p.technologies.length">
                <span v-for="tech in p.technologies.slice(0, 5)" :key="tech">{{ tech }}</span>
              </div>
              <span class="proj__link">{{ t('projects.view_details', 'View details') }} <span class="arr">→</span></span>
            </div>
          </a>
        </div>

        <div v-else class="empty">{{ t('projects.empty', 'No projects yet. Check back soon.') }}</div>
      </template>
    </section>
  </main>
</template>
