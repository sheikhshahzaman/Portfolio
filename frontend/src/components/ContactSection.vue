<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useTranslations } from '../composables/useTranslations'
import { useSolsticeMotion } from '../composables/useMotion'

const props = defineProps({ profile: { type: Object, default: () => ({}) } })
const { t } = useTranslations()
const router = useRouter()
const root = ref(null)

const email = computed(() => props.profile.email || 'hi@shahzaman.dev')
useSolsticeMotion(root)
</script>

<template>
  <section class="wrap section" id="contact" ref="root">
    <div class="card reveal" style="padding: clamp(32px,5vw,72px); text-align: center;">
      <div class="eyebrow center" style="margin-bottom: 18px;">{{ t('cta.eyebrow', 'Contact') }}</div>
      <h2 style="font-size: clamp(2.2rem,6vw,4.4rem);">
        {{ t('cta.heading_a', "Let's build something that") }} <span class="grad-text">{{ t('cta.heading_b', 'scales.') }}</span>
      </h2>
      <p style="color: var(--ink-2); max-width: 48ch; margin: 18px auto 0;">
        {{ t('cta.subtitle', 'Hiring, a hard systems problem, or just comparing notes on architecture. I read everything.') }}
      </p>
      <div style="display:flex; gap:12px; flex-wrap:wrap; justify-content:center; margin-top:30px;">
        <a class="btn btn--solid mag" data-mag="0.3" :href="`mailto:${email}`">
          {{ t('cta.primary', 'Start a conversation') }} <span class="arr">→</span>
        </a>
        <button class="btn mag" data-mag="0.3" @click="router.push('/contact')">
          {{ t('cta.secondary', 'All contact options') }}
        </button>
      </div>
    </div>
  </section>
</template>
