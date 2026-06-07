<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useHead } from '@unhead/vue'
import { useTranslations } from '../composables/useTranslations'
import { useSolsticeMotion } from '../composables/useMotion'
import { portfolioAPI } from '../services/api'

const { t } = useTranslations()
const router = useRouter()
const root = ref(null)

const services = ref([])
const loading = ref(true)

const GLYPHS = ['</>', '◇', '✦', '⧉', '⚡', '◈']
const ICON_MAP = { code: '</>', api: '⧉', database: '◇', palette: '✦', rocket: '⚡', shield: '◈', tools: '◈', shopping: '◇' }
const glyph = (svc, i) => ICON_MAP[(svc.icon || '').toLowerCase()] || GLYPHS[i % GLYPHS.length]

useSolsticeMotion(root)
useHead({
  title: computed(() => `${t('services.eyebrow', 'Services')} — Shahzaman`),
  meta: [{ name: 'description', content: 'Backend & API development, system architecture, AI integration, multi-tenant SaaS, event-driven systems.' }],
})

onMounted(async () => {
  try {
    const res = await portfolioAPI.getServices()
    services.value = res.data || []
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <main ref="root">
    <header class="wrap page-head">
      <div class="eyebrow" style="margin-bottom: 20px">{{ t('services.eyebrow', 'Services') }}</div>
      <h1>{{ t('services.heading_a', 'How I can') }} <span class="grad-text">{{ t('services.heading_b', 'help.') }}</span></h1>
      <p class="sub reveal">{{ t('services.subtitle', 'I design and build the systems behind products that need to scale. Here is where I do my best work.') }}</p>
    </header>

    <section class="wrap section" style="padding-top: 0">
      <div v-if="loading" class="loader"><div class="spinner"></div></div>

      <template v-else>
        <div class="svc-grid" data-stagger v-if="services.length">
          <div class="card svc" v-for="(svc, i) in services" :key="svc.id">
            <div class="svc__ic">{{ glyph(svc, i) }}</div>
            <h3 class="svc__title">{{ svc.title }}</h3>
            <p class="svc__desc" style="white-space: pre-line">{{ svc.description }}</p>
          </div>
        </div>
        <div v-else class="empty">{{ t('services.empty', 'Services coming soon.') }}</div>

        <div class="card reveal" style="padding: clamp(30px,4vw,56px); text-align:center; margin-top: clamp(28px,4vh,48px)">
          <h2 style="font-size: clamp(1.8rem,4vw,3rem)">
            {{ t('services.cta_a', 'Have a system that needs to') }} <span class="grad-text">{{ t('services.cta_b', 'scale?') }}</span>
          </h2>
          <div style="margin-top: 24px">
            <button class="btn btn--solid mag" data-mag="0.3" @click="router.push('/contact')">
              {{ t('services.cta_button', "Let's talk") }} <span class="arr">→</span>
            </button>
          </div>
        </div>
      </template>
    </section>
  </main>
</template>
