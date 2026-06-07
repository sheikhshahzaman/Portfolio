<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import { useRouter } from 'vue-router'
import { useTranslations } from '../composables/useTranslations'
import { useSolsticeMotion, reduceMotion } from '../composables/useMotion'

const props = defineProps({ profile: { type: Object, default: () => ({}) } })
const { t } = useTranslations()
const router = useRouter()

const root = ref(null)
const codeEl = ref(null)
let typingTimer = null

const SOCIAL_LABELS = {
  github: 'GH', linkedin: 'IN', twitter: 'X', x: 'X', devto: 'DEV',
  'dev.to': 'DEV', instagram: 'IG', facebook: 'FB', youtube: 'YT',
}
const socials = computed(() =>
  Object.entries(props.profile.social_links || {})
    .filter(([, url]) => url)
    .map(([key, url]) => ({ key, url, label: SOCIAL_LABELS[key.toLowerCase()] || key.slice(0, 2).toUpperCase() }))
)

const CODE_LINES = [
  { c: 'c', t: '// systems that scale to 1M+ users' },
  { c: 'k', t: 'class Gateway extends BFF {' },
  { c: 'f', t: '  async route(req) {' },
  { c: 'n', t: '    const user = await auth.verify(req);' },
  { c: 'k', t: '    return kafka.publish("orders", {' },
  { c: 'n', t: '      tenant: user.tenant,' },
  { c: 'n', t: '      payload: req.body,' },
  { c: 'k', t: '    });' },
  { c: 'f', t: '  }' },
  { c: 'k', t: '}' },
  { c: 'c', t: '// shipped · resilient · multi-tenant' },
]

function escapeHtml(s) {
  return s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
}
function startTyping() {
  const el = codeEl.value
  if (!el) return
  if (reduceMotion) {
    el.innerHTML = CODE_LINES.map((l) => `<div class="ln ${l.c}">${escapeHtml(l.t)}</div>`).join('')
    return
  }
  let li = 0, ci = 0
  const render = (upto, partial) => {
    let html = ''
    for (let i = 0; i < upto; i++) html += `<div class="ln ${CODE_LINES[i].c}">${escapeHtml(CODE_LINES[i].t)}</div>`
    const cls = CODE_LINES[upto] ? CODE_LINES[upto].c : 'k'
    html += `<div class="ln ${cls}">${escapeHtml(partial || '')}<span class="caret"></span></div>`
    el.innerHTML = html
  }
  const tick = () => {
    if (li >= CODE_LINES.length) {
      typingTimer = setTimeout(() => { li = 0; ci = 0; tick() }, 2600)
      return
    }
    const txt = CODE_LINES[li].t
    if (ci <= txt.length) { render(li, txt.slice(0, ci)); ci++; typingTimer = setTimeout(tick, 22 + Math.random() * 30) }
    else { li++; ci = 0; typingTimer = setTimeout(tick, 130) }
  }
  tick()
}

useSolsticeMotion(root, ({ gsap }) => {
  gsap.from(root.value.querySelectorAll('.hero__copy > *'), {
    y: 30, autoAlpha: 0, duration: 0.9, stagger: 0.08, ease: 'power3.out', delay: 0.1,
  })
  gsap.from(root.value.querySelector('.laptop'), {
    y: 40, autoAlpha: 0, scale: 0.96, duration: 1, ease: 'power3.out', delay: 0.25,
  })
})

onMounted(startTyping)
onBeforeUnmount(() => typingTimer && clearTimeout(typingTimer))

const view = () => router.push('/projects')
const contact = () => router.push('/contact')
</script>

<template>
  <header class="wrap hero" ref="root">
    <div class="hero__copy">
      <div class="hero__hello">{{ t('hero.greeting', 'Hi, my name is') }}</div>
      <h1 class="display"><span class="grad-text">{{ profile.name || 'Shahzaman' }}</span></h1>
      <p class="hero__title" v-if="profile.title">{{ profile.title }}</p>
      <p class="hero__lede">
        {{ t('hero.lede', 'Five years building backends and the full stack around them. I architect systems that stay calm under real traffic. 1M+ users shipped.') }}
      </p>
      <div class="hero__cta">
        <button class="btn btn--solid mag" data-mag="0.3" @click="view">
          {{ t('hero.view_work', 'View my work') }} <span class="arr">→</span>
        </button>
        <button class="btn mag" data-mag="0.3" @click="contact">
          {{ t('hero.get_in_touch', 'Get in touch') }}
        </button>
      </div>
      <div class="hero__social" v-if="socials.length">
        <a v-for="s in socials" :key="s.key" :href="s.url" target="_blank" rel="noopener" :title="s.key">{{ s.label }}</a>
      </div>
    </div>

    <div class="hero__visual" data-par="-30">
      <div class="laptop" aria-hidden="true">
        <div class="laptop__screen">
          <div class="laptop__bar"><i></i><i></i><i></i><span class="file">~/shahzaman/gateway.ts</span></div>
          <div class="code" ref="codeEl"></div>
        </div>
        <div class="laptop__base"></div>
        <div class="laptop__hinge"></div>
      </div>
    </div>
  </header>
</template>
