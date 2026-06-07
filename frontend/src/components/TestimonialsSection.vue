<script setup>
import { ref, computed } from 'vue'
import { useTranslations } from '../composables/useTranslations'
import { useSolsticeMotion } from '../composables/useMotion'

const props = defineProps({ testimonials: { type: Array, default: () => [] } })
const { t } = useTranslations()
const root = ref(null)

const items = computed(() => props.testimonials || [])
const stars = (n) => '★'.repeat(Math.max(0, Math.min(5, n || 5)))
const initials = (name = '') =>
  name.split(/\s+/).filter(Boolean).slice(0, 2).map((w) => w[0]).join('').toUpperCase() || '★'
const role = (item) =>
  [item.client_position, item.client_company].filter(Boolean).join(t('testimonials.at_separator', ' · '))

useSolsticeMotion(root, ({ gsap, inView }) => {
  const grid = root.value.querySelector('.testi-grid')
  if (!grid) return
  const cards = grid.querySelectorAll('.testi')
  gsap.set(cards, { y: 64, scale: 0.84, autoAlpha: 0, rotate: 2 })
  inView(grid, () =>
    gsap.to(cards, { y: 0, scale: 1, autoAlpha: 1, rotate: 0, duration: 0.8, stagger: 0.12, ease: 'back.out(1.7)' })
  )
})
</script>

<template>
  <section class="wrap section" id="testimonials" ref="root" v-if="items.length">
    <div class="section-intro reveal">
      <div class="eyebrow center">{{ t('testimonials.eyebrow', 'Testimonials') }}</div>
      <h2>{{ t('testimonials.heading_a', 'What clients') }} <span class="grad-text">{{ t('testimonials.heading_b', 'say.') }}</span></h2>
      <p>{{ t('testimonials.subtitle', 'A few words from people I have built for.') }}</p>
    </div>

    <div class="testi-grid">
      <div class="card testi" v-for="(item, i) in items" :key="item.id || i">
        <div class="testi__stars">{{ stars(item.rating) }}</div>
        <p class="testi__quote">{{ item.content }}</p>
        <div class="testi__who">
          <div class="testi__av">
            <img v-if="item.image_url" :src="item.image_url" :alt="item.client_name" />
            <template v-else>{{ initials(item.client_name) }}</template>
          </div>
          <div>
            <div class="testi__name">{{ item.client_name }}</div>
            <div class="testi__role" v-if="role(item)">{{ role(item) }}</div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
