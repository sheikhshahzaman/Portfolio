<script setup>
import { ref } from 'vue'
import { useHead } from '@unhead/vue'
import { useTranslations } from '../composables/useTranslations'
import { useSolsticeMotion } from '../composables/useMotion'

const { t } = useTranslations()
const root = ref(null)

useSolsticeMotion(root)
useHead({ title: 'Terms & Conditions — Shahzaman', meta: [{ name: 'robots', content: 'noindex' }] })
</script>

<template>
  <main ref="root">
    <header class="wrap page-head">
      <div class="eyebrow" style="margin-bottom: 20px">{{ t('footer.legal', 'Legal') }}</div>
      <h1>{{ t('terms.heading_a', 'Terms &') }} <span class="grad-text">{{ t('terms.heading_b', 'Conditions.') }}</span></h1>
    </header>

    <section class="wrap section" style="padding-top: 0">
      <div class="article">
        <div class="prose reveal">
          <p>{{ t('terms.intro', 'By using this website you agree to the following terms. They are intentionally simple.') }}</p>
          <h2>Content</h2>
          <p>All content, design and code on this site are the work of Shahzaman unless stated otherwise. You are welcome to take inspiration, but please do not republish the content wholesale as your own.</p>
          <h2>Accuracy</h2>
          <p>The information here is provided in good faith and kept up to date where possible, but it is offered without warranty of any kind.</p>
          <h2>External links</h2>
          <p>This site links to external projects and profiles. I am not responsible for the content or practices of those third-party sites.</p>
          <h2>Contact</h2>
          <p>Questions about these terms are welcome through the contact page.</p>
        </div>
      </div>
    </section>
  </main>
</template>
