<script setup>
import { ref, computed } from 'vue'
import { useHead } from '@unhead/vue'
import { useTranslations } from '../composables/useTranslations'
import { usePortfolio } from '../composables/usePortfolio'
import { useSolsticeMotion } from '../composables/useMotion'

const { t } = useTranslations()
const { data } = usePortfolio()
const root = ref(null)
const email = computed(() => data.value?.profile?.email || 'hi@shahzaman.dev')

useSolsticeMotion(root)
useHead({ title: 'Privacy Policy — Shahzaman', meta: [{ name: 'robots', content: 'noindex' }] })
</script>

<template>
  <main ref="root">
    <header class="wrap page-head">
      <div class="eyebrow" style="margin-bottom: 20px">{{ t('footer.legal', 'Legal') }}</div>
      <h1>{{ t('privacy.heading_a', 'Privacy') }} <span class="grad-text">{{ t('privacy.heading_b', 'Policy.') }}</span></h1>
    </header>

    <section class="wrap section" style="padding-top: 0">
      <div class="article">
        <div class="prose reveal">
          <p>{{ t('privacy.intro', 'This site is a personal portfolio. It collects only the information you choose to share through the contact form, and it does not sell or share your data with third parties.') }}</p>
          <h2>What is collected</h2>
          <p>When you submit the contact form, your name, email address and message are stored so that I can reply. Basic, anonymous analytics may be used to understand which pages are visited.</p>
          <h2>How it is used</h2>
          <ul>
            <li>To respond to your enquiry.</li>
            <li>To improve the content and performance of this site.</li>
          </ul>
          <h2>Your choices</h2>
          <p>You can request that any message you sent be deleted at any time. Contact <a :href="`mailto:${email}`">{{ email }}</a> and it will be removed.</p>
          <h2>Cookies</h2>
          <p>Only essential cookies are used. No advertising or cross-site tracking cookies are set.</p>
        </div>
      </div>
    </section>
  </main>
</template>
