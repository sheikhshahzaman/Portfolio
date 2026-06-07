<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useHead } from '@unhead/vue'
import { useTranslations } from '../composables/useTranslations'
import { useSolsticeMotion } from '../composables/useMotion'
import { portfolioAPI } from '../services/api'

const { t } = useTranslations()
const route = useRoute()
const router = useRouter()
const root = ref(null)

const project = ref(null)
const loading = ref(true)
const notFound = ref(false)

const load = async (slug) => {
  loading.value = true
  notFound.value = false
  project.value = null
  try {
    const res = await portfolioAPI.getProject(slug)
    project.value = res.data
  } catch (e) {
    notFound.value = true
  } finally {
    loading.value = false
  }
}

useSolsticeMotion(root)
useHead({
  title: computed(() =>
    project.value ? `${project.value.meta_title || project.value.title} — Shahzaman` : 'Project — Shahzaman'
  ),
  meta: computed(() => [
    { name: 'description', content: project.value?.meta_description || project.value?.short_description || '' },
    { property: 'og:title', content: project.value?.og_title || project.value?.title || '' },
    { property: 'og:image', content: project.value?.image_url || '' },
  ]),
})

onMounted(() => load(route.params.slug))
watch(() => route.params.slug, (s) => s && load(s))
</script>

<template>
  <main ref="root">
    <div v-if="loading" class="loader"><div class="spinner"></div></div>

    <template v-else-if="notFound">
      <header class="wrap page-head">
        <div class="eyebrow" style="margin-bottom: 20px">404</div>
        <h1>{{ t('projects.project_not_found', 'Project Not Found') }}</h1>
        <p class="sub">{{ t('projects.not_found_sub', 'That project may have moved or been unpublished.') }}</p>
        <div style="margin-top: 28px">
          <button class="btn mag" data-mag="0.3" @click="router.push('/projects')">
            {{ t('projects.back_to_projects', '← Back to Projects') }}
          </button>
        </div>
      </header>
    </template>

    <template v-else-if="project">
      <header class="wrap page-head">
        <div class="eyebrow" style="margin-bottom: 20px">{{ project.category || 'Project' }}</div>
        <h1><span class="grad-text">{{ project.title }}</span></h1>
        <p class="sub reveal">{{ project.short_description }}</p>
      </header>

      <section class="wrap section" style="padding-top: 0">
        <div class="pd-cover reveal" v-if="project.image_url" style="margin-bottom: clamp(28px,4vh,48px)">
          <img :src="project.image_url" :alt="project.title" />
        </div>

        <div class="pd-meta reveal" v-if="project.technologies && project.technologies.length">
          <span v-for="tech in project.technologies" :key="tech">{{ tech }}</span>
        </div>

        <div class="article" style="margin-top: clamp(28px,4vh,44px)">
          <div class="prose reveal" style="white-space: pre-line">{{ project.description }}</div>

          <div class="reveal" style="display:flex; gap:12px; flex-wrap:wrap; margin-top: clamp(28px,4vh,44px)">
            <a v-if="project.demo_url" class="btn btn--solid mag" data-mag="0.3" :href="project.demo_url" target="_blank" rel="noopener">
              {{ t('projects.live_demo_label', 'Live demo') }} <span class="arr">→</span>
            </a>
            <a v-if="project.github_url" class="btn mag" data-mag="0.3" :href="project.github_url" target="_blank" rel="noopener">
              {{ t('projects.github_label', 'View on GitHub') }}
            </a>
            <button class="btn mag" data-mag="0.3" @click="router.push('/projects')">
              {{ t('projects.back_to_projects', '← Back to Projects') }}
            </button>
          </div>
        </div>
      </section>
    </template>
  </main>
</template>
