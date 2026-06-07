<script setup>
import { ref, computed } from 'vue'
import { useTranslations } from '../composables/useTranslations'
import { useSolsticeMotion } from '../composables/useMotion'

const props = defineProps({ skills: { type: [Object, Array], default: () => ({}) } })
const { t } = useTranslations()
const root = ref(null)

// API returns skills grouped by category: { Backend: [...], Frontend: [...] }
const categories = computed(() => {
  const s = props.skills
  if (!s) return []
  if (Array.isArray(s)) {
    const grouped = {}
    s.forEach((sk) => { (grouped[sk.category] ||= []).push(sk) })
    return Object.entries(grouped).map(([name, list]) => ({ name, list }))
  }
  return Object.entries(s).map(([name, list]) => ({ name, list }))
})

useSolsticeMotion(root, ({ gsap, inView }) => {
  root.value.querySelectorAll('.skillcat').forEach((c) => {
    const h = c.querySelector('.skillcat__h')
    const skills = c.querySelectorAll('.skill')
    const fills = c.querySelectorAll('.skill__fill')
    if (h) gsap.set(h, { x: -40, autoAlpha: 0 })
    if (skills.length) gsap.set(skills, { x: 30, autoAlpha: 0 })
    if (fills.length) gsap.set(fills, { scaleX: 0, transformOrigin: 'left center' })
    inView(c, () => {
      if (h) gsap.to(h, { x: 0, autoAlpha: 1, duration: 0.7, ease: 'power3.out' })
      if (skills.length) gsap.to(skills, { x: 0, autoAlpha: 1, stagger: 0.07, duration: 0.6, ease: 'power2.out' })
      if (fills.length) gsap.to(fills, { scaleX: 1, duration: 1.2, stagger: 0.08, ease: 'power2.out', delay: 0.1 })
    })
  })
})
</script>

<template>
  <section class="wrap section" id="skills" ref="root" v-if="categories.length">
    <div class="section-intro reveal">
      <div class="eyebrow center">{{ t('skills.eyebrow', 'Skills') }}</div>
      <h2>{{ t('skills.heading_a', 'Technologies I') }} <span class="grad-text">{{ t('skills.heading_b', 'work with.') }}</span></h2>
      <p>{{ t('skills.subtitle', 'The tools I reach for, and how deep I go.') }}</p>
    </div>

    <div class="skillcats">
      <div class="skillcat" v-for="cat in categories" :key="cat.name">
        <div class="skillcat__h">{{ cat.name }}</div>
        <div class="skillgrid">
          <div class="skill" v-for="sk in cat.list" :key="sk.id || sk.name">
            <div class="skill__top"><span>{{ sk.name }}</span><span class="skill__pct">{{ sk.proficiency }}%</span></div>
            <div class="skill__bar"><div class="skill__fill" :style="{ '--pct': sk.proficiency + '%' }"></div></div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
