<script setup>
import { ref, computed } from 'vue'
import { useTranslations } from '../composables/useTranslations'
import { useSolsticeMotion } from '../composables/useMotion'

const props = defineProps({ education: { type: Array, default: () => [] } })
const { t } = useTranslations()
const root = ref(null)

const items = computed(() => props.education || [])

const year = (d) => {
  if (!d) return ''
  const date = new Date(d)
  return isNaN(date) ? d : date.getFullYear()
}
const range = (e) => `${year(e.start_date)} — ${e.is_current ? t('education.present', 'Present') : year(e.end_date)}`
const initials = (inst = '') =>
  inst.split(/\s+/).filter(Boolean).slice(0, 2).map((w) => w[0]).join('').toUpperCase() || 'ED'

useSolsticeMotion(root, ({ gsap, inView }) => {
  const grid = root.value.querySelector('.edu-grid')
  if (!grid) return
  gsap.set(grid, { perspective: 900 })
  grid.querySelectorAll('.edu').forEach((c, i) => {
    gsap.set(c, { y: 70, rotateX: 24, autoAlpha: 0, transformOrigin: 'center bottom' })
    inView(c, () => gsap.to(c, { y: 0, rotateX: 0, autoAlpha: 1, duration: 0.9, ease: 'power3.out', delay: i * 0.05 }))
  })
})
</script>

<template>
  <section class="wrap section" id="education" ref="root" v-if="items.length">
    <div class="section-intro reveal">
      <div class="eyebrow center">{{ t('education.eyebrow', 'Education') }}</div>
      <h2>{{ t('education.heading_a', 'Background &') }} <span class="grad-text">{{ t('education.heading_b', 'certifications.') }}</span></h2>
      <p>{{ t('education.subtitle', 'Where the foundations came from.') }}</p>
    </div>

    <div class="edu-grid">
      <div class="card edu" v-for="(e, i) in items" :key="e.id || i">
        <div class="edu__ic">{{ initials(e.institution) }}</div>
        <div>
          <div class="edu__title">{{ e.degree }}</div>
          <div class="edu__org">{{ e.institution }}<template v-if="e.location"> · {{ e.location }}</template></div>
          <p class="edu__desc" v-if="e.description">{{ e.description }}</p>
        </div>
        <span class="edu__date">{{ range(e) }}</span>
      </div>
    </div>
  </section>
</template>
