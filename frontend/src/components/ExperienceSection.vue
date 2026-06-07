<script setup>
import { ref, computed } from 'vue'
import { useTranslations } from '../composables/useTranslations'
import { useSolsticeMotion } from '../composables/useMotion'

const props = defineProps({ experiences: { type: Array, default: () => [] } })
const { t } = useTranslations()
const root = ref(null)

const items = computed(() => props.experiences || [])

const fmt = (d) => {
  if (!d) return ''
  const date = new Date(d)
  if (isNaN(date)) return d
  return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' })
}
const range = (xp) =>
  `${fmt(xp.start_date)} — ${xp.is_current ? t('experience.present', 'Present') : fmt(xp.end_date)}`

useSolsticeMotion(root, ({ gsap, inView }) => {
  const xp = root.value.querySelector('.xp')
  const line = root.value.querySelector('.xp__line')
  if (line && xp) {
    gsap.set(line, { scaleY: 0, transformOrigin: 'top' })
    inView(xp, () => gsap.to(line, { scaleY: 1, duration: 1.1, ease: 'power2.out' }))
  }
  root.value.querySelectorAll('.xp__item').forEach((it) => {
    const dot = it.querySelector('.xp__dot')
    const lis = it.querySelectorAll('.xp__list li')
    gsap.set(it, { x: -56, autoAlpha: 0 })
    if (dot) gsap.set(dot, { scale: 0 })
    if (lis.length) gsap.set(lis, { x: -18, autoAlpha: 0 })
    inView(it, () => {
      gsap.to(it, { x: 0, autoAlpha: 1, duration: 0.9, ease: 'back.out(1.3)' })
      if (dot) gsap.to(dot, { scale: 1, duration: 0.6, ease: 'back.out(3)', delay: 0.1 })
      if (lis.length) gsap.to(lis, { x: 0, autoAlpha: 1, stagger: 0.08, duration: 0.6, ease: 'power2.out', delay: 0.15 })
    })
  })
})
</script>

<template>
  <section class="wrap section" id="experience" ref="root">
    <div class="section-intro reveal">
      <div class="eyebrow center">{{ t('experience.eyebrow', 'Work Experience') }}</div>
      <h2>{{ t('experience.heading_a', 'My professional') }} <span class="grad-text">{{ t('experience.heading_b', 'journey.') }}</span></h2>
      <p>{{ t('experience.subtitle', 'Where I have worked and what I shipped there.') }}</p>
    </div>

    <div class="xp">
      <span class="xp__line"></span>
      <div class="xp__item" v-for="(xp, i) in items" :key="xp.id || i">
        <span class="xp__dot"></span>
        <div class="xp__top">
          <div>
            <div class="xp__role">{{ xp.position }}</div>
            <div class="xp__co">{{ xp.company }}<template v-if="xp.location"> · {{ xp.location }}</template></div>
          </div>
          <span class="xp__date">{{ range(xp) }}</span>
        </div>
        <p class="xp__sub" v-if="xp.description" style="white-space: pre-line">{{ xp.description }}</p>
        <ul class="xp__list" v-if="xp.achievements && xp.achievements.length">
          <li v-for="(a, ai) in xp.achievements" :key="ai">{{ a }}</li>
        </ul>
      </div>
    </div>
  </section>
</template>
