<script setup>
import { ref, reactive, computed, onMounted } from 'vue'
import { useHead } from '@unhead/vue'
import { useTranslations } from '../composables/useTranslations'
import { usePortfolio } from '../composables/usePortfolio'
import { useSolsticeMotion } from '../composables/useMotion'
import { portfolioAPI } from '../services/api'

const { t } = useTranslations()
const { data, load } = usePortfolio()
const root = ref(null)

const profile = computed(() => data.value?.profile || {})

const CHANNEL_LABELS = {
  github: 'GitHub', linkedin: 'LinkedIn', twitter: 'X', x: 'X', devto: 'Dev.to',
  'dev.to': 'Dev.to', instagram: 'Instagram', facebook: 'Facebook', youtube: 'YouTube',
}
const handle = (url = '') => {
  try {
    const u = new URL(url)
    const seg = u.pathname.split('/').filter(Boolean).pop()
    return seg ? '@' + seg : u.hostname
  } catch {
    return url
  }
}
const channels = computed(() => {
  const out = []
  if (profile.value.email) out.push({ label: 'Email', value: profile.value.email, href: `mailto:${profile.value.email}` })
  const links = profile.value.social_links || {}
  Object.entries(links)
    .filter(([, url]) => url)
    .forEach(([key, url]) => out.push({ label: CHANNEL_LABELS[key.toLowerCase()] || key, value: handle(url), href: url }))
  return out
})

const form = reactive({ name: '', email: '', subject: '', message: '' })
const sending = ref(false)
const note = ref(null)

const submit = async () => {
  sending.value = true
  note.value = null
  try {
    const res = await portfolioAPI.sendContactMessage({ ...form })
    note.value = { type: 'ok', msg: res.data?.message || t('contact.success', 'Thanks — I will get back to you soon.') }
    form.name = form.email = form.subject = form.message = ''
  } catch (e) {
    const errs = e?.response?.data?.errors
    const msg =
      (errs && Object.values(errs)[0]?.[0]) ||
      e?.response?.data?.message ||
      t('contact.error_default', 'Failed to send message. Please try again.')
    note.value = { type: 'err', msg }
  } finally {
    sending.value = false
  }
}

useSolsticeMotion(root)
useHead({
  title: computed(() => `${t('contact.eyebrow', 'Contact')} — ${profile.value.name || 'Shahzaman'}`),
  meta: [{ name: 'description', content: 'Start a conversation. Backend and full-stack engineer.' }],
})
onMounted(() => { if (!data.value) load(localStorage.getItem('selectedLanguage') || 'en').catch(() => {}) })
</script>

<template>
  <div class="contact-wrap" ref="root">
    <main class="contact-main wrap">
      <div style="width: 100%">
        <div class="eyebrow" style="margin-bottom: 22px">{{ t('contact.eyebrow', 'Contact') }}</div>
        <h1 class="contact-head">
          {{ t('contact.head_a', "Let's build something that") }} <span class="grad-text">{{ t('contact.head_b', 'scales.') }}</span>
        </h1>
        <p class="contact-sub reveal">
          {{ t('contact.sub', 'Hiring, a hard systems problem, or just comparing notes on architecture. I read everything.') }}
        </p>

        <div class="contact-card reveal" style="margin-top: clamp(32px,5vh,56px)">
          <div style="display:grid; grid-template-columns: 1.1fr 0.9fr; gap: clamp(28px,4vw,56px)" class="contact-grid">
            <div>
              <div class="eyebrow">{{ t('contact.form_title', 'Send a message') }}</div>
              <form class="form" @submit.prevent="submit">
                <div class="form__row">
                  <div class="field">
                    <label>{{ t('contact.name_label', 'Name') }}</label>
                    <input v-model="form.name" type="text" required autocomplete="name" />
                  </div>
                  <div class="field">
                    <label>{{ t('contact.email_label', 'Email') }}</label>
                    <input v-model="form.email" type="email" required autocomplete="email" />
                  </div>
                </div>
                <div class="field">
                  <label>{{ t('contact.subject_label', 'Subject') }}</label>
                  <input v-model="form.subject" type="text" />
                </div>
                <div class="field">
                  <label>{{ t('contact.message_label', 'Message') }}</label>
                  <textarea v-model="form.message" required></textarea>
                </div>
                <div class="form__note" :class="note.type" v-if="note">{{ note.msg }}</div>
                <button class="btn btn--solid" type="submit" :disabled="sending">
                  <span v-if="sending">{{ t('contact.sending', 'Sending…') }}</span>
                  <span v-else>{{ t('contact.send_button', 'Send message') }} <span class="arr">→</span></span>
                </button>
              </form>
            </div>

            <div>
              <div class="eyebrow">{{ t('contact.reach_me', 'Reach me') }}</div>
              <div class="channels" style="grid-template-columns: 1fr">
                <a v-for="c in channels" :key="c.label" class="mag" data-mag="0.12" :href="c.href" target="_blank" rel="noopener">
                  <span>{{ c.label }}</span><span class="h">{{ c.value }}</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<style scoped>
@media (max-width: 760px) {
  .contact-grid { grid-template-columns: 1fr !important; }
}
</style>
