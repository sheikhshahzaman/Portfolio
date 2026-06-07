<script setup>
import { ref, computed, onMounted } from 'vue'
import { useHead } from '@unhead/vue'
import { useTranslations } from '../composables/useTranslations'
import { usePortfolio } from '../composables/usePortfolio'
import { useSolsticeMotion } from '../composables/useMotion'

const { t } = useTranslations()
const { data, load } = usePortfolio()
const root = ref(null)

const profile = computed(() => data.value?.profile || {})
const principles = computed(() => data.value?.about?.principles || [])
const experiences = computed(() => data.value?.experiences || [])

const DEFAULT_BIO =
  'I am a software engineer who leads with architecture. I have spent five years on backends and the full stack around them.\n\nThe thread through all of it is the same. Decide how the pieces fit before writing the first line. Keep the data honest. Let the system carry the load so the team does not have to.'

const paragraphs = computed(() => {
  const text = t('about.body', profile.value.bio || DEFAULT_BIO)
  return text.split(/\n\s*\n/).map((p) => p.trim()).filter(Boolean)
})

const year = (d) => {
  if (!d) return ''
  const date = new Date(d)
  return isNaN(date) ? d : date.getFullYear()
}
const range = (xp) => `${year(xp.start_date)} — ${xp.is_current ? t('experience.present', 'now') : year(xp.end_date)}`

useSolsticeMotion(root)
useHead({
  title: computed(() => `${t('about.eyebrow', 'About')} — ${profile.value.name || 'Shahzaman'}`),
  meta: [{ name: 'description', content: 'How I think about systems. Backend and full-stack engineer.' }],
})
onMounted(() => { if (!data.value) load(localStorage.getItem('selectedLanguage') || 'en').catch(() => {}) })
</script>

<template>
  <main ref="root">
    <header class="wrap page-head">
      <div class="eyebrow" style="margin-bottom: 20px">{{ t('about.eyebrow', 'About') }}</div>
      <h1>{{ t('about.heading_a', 'I think in') }} <span class="grad-text">{{ t('about.heading_b', 'systems') }}</span><br />{{ t('about.heading_c', 'before screens.') }}</h1>
      <p class="sub reveal">{{ t('about.subtitle', 'The feature is the easy part. The architecture is the work.') }}</p>
    </header>

    <section class="wrap section" style="padding-top: 0">
      <div class="bio">
        <div class="colhead reveal">{{ t('about.short_version', 'The short version') }}</div>
        <div class="reveal">
          <p v-for="(para, i) in paragraphs" :key="i">{{ para }}</p>
        </div>
      </div>
    </section>

    <section class="wrap section" style="padding-top: 0" v-if="principles.length">
      <div class="sechead"><h2>{{ t('about.how_a', 'How I') }} <span class="grad-text">{{ t('about.how_b', 'work.') }}</span></h2></div>
      <div class="principles" data-stagger>
        <div class="card principle" v-for="(p, i) in principles" :key="i">
          <div class="n"><span class="grad-text">{{ String(i + 1).padStart(2, '0') }}</span></div>
          <h3>{{ p.title }}</h3>
          <p>{{ p.text }}</p>
        </div>
      </div>
    </section>

    <section class="wrap section" style="padding-top: 0" v-if="experiences.length">
      <div class="sechead"><h2>{{ t('about.where_a', 'Where I have') }} <span class="grad-text">{{ t('about.where_b', 'been.') }}</span></h2></div>
      <div data-stagger>
        <div class="tl__row" v-for="(xp, i) in experiences" :key="xp.id || i">
          <div class="tl__yr">{{ range(xp) }}</div>
          <div class="tl__role">{{ xp.position }}<span>{{ xp.company }}</span></div>
          <div class="tl__stack">{{ xp.location || '' }}</div>
        </div>
      </div>
    </section>
  </main>
</template>
