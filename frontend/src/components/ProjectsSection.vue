<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useTranslations } from '../composables/useTranslations'
import { useSolsticeMotion } from '../composables/useMotion'

const props = defineProps({ projects: { type: Array, default: () => [] } })
const { t } = useTranslations()
const router = useRouter()
const root = ref(null)

const items = computed(() => props.projects || [])
const coverClass = (i) => ['', 'v2', 'v3', 'v4', 'v5', 'v6'][i % 6]
const open = (p) => router.push(`/projects/${p.slug}`)

useSolsticeMotion(root, ({ gsap, ScrollTrigger, mm, inView }) => {
  // re-measure the rail once cover images have loaded
  root.value.querySelectorAll('.proj__cover img').forEach((img) => {
    if (!img.complete) img.addEventListener('load', () => ScrollTrigger.refresh(), { once: true })
  })

  mm.add('(min-width: 861px)', () => {
    const track = root.value.querySelector('.proj-track')
    const stage = root.value.querySelector('.proj-stage')
    const fill = root.value.querySelector('.proj-progress i')
    if (!track || !stage) return
    const dist = () =>
      Math.max(0, track.scrollWidth - stage.clientWidth + parseFloat(getComputedStyle(stage).paddingLeft || 0))

    const tween = gsap.to(track, {
      x: () => -dist(),
      ease: 'none',
      scrollTrigger: {
        trigger: root.value,
        start: 'top top',
        end: () => '+=' + dist(),
        pin: true,
        scrub: 1,
        anticipatePin: 1,
        invalidateOnRefresh: true,
        onUpdate: (self) => { if (fill) fill.style.width = self.progress * 100 + '%' },
      },
    })

    gsap.utils.toArray(track.querySelectorAll('.proj-card')).forEach((card, i) => {
      gsap.from(card, {
        scale: 0.78, rotate: i % 2 ? 5 : -5, yPercent: 10, autoAlpha: 0, ease: 'back.out(1.7)',
        scrollTrigger: { trigger: card, containerAnimation: tween, start: 'left 95%', end: 'left 60%', scrub: true },
      })
    })
  })

  mm.add('(max-width: 860px)', () => {
    root.value.querySelectorAll('.proj-card').forEach((card) => {
      gsap.set(card, { y: 44, autoAlpha: 0 })
      inView(card, () => gsap.to(card, { y: 0, autoAlpha: 1, duration: 0.7, ease: 'power3.out' }))
    })
  })
})
</script>

<template>
  <section class="proj-section" id="projects" ref="root">
    <div class="proj-stage">
      <div class="section-intro">
        <div class="eyebrow center">{{ t('projects.featured_projects', 'Featured Projects') }}</div>
        <h2>{{ t('projects.heading_a', 'Some of my') }} <span class="grad-text">{{ t('projects.heading_b', 'recent work.') }}</span></h2>
        <p>{{ t('projects.subtitle', 'Real systems in production. Keep scrolling to slide through them.') }}</p>
      </div>

      <div class="proj-track">
        <a class="card proj proj-card" v-for="(p, i) in items" :key="p.id || i" @click="open(p)">
          <div class="proj__cover" :class="coverClass(i)">
            <img v-if="p.image_url" :src="p.image_url" :alt="p.title" loading="lazy" />
            <span class="badge">{{ p.category || t('projects.featured_badge', 'Project') }}</span>
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

      <div class="proj-progress"><i></i></div>
    </div>
  </section>
</template>
