/* ============================================================
   Solstice motion engine — GSAP + ScrollTrigger + Lenis,
   adapted for a Vue SPA.

   Reveals + entrance animations are driven by IntersectionObserver
   (not ScrollTrigger position math) so they are immune to async
   data loading and page-height changes — content can NEVER get
   stuck invisible. A MutationObserver re-observes async content.
   ScrollTrigger is used only for the pinned projects rail and
   parallax orbs.
   ============================================================ */
import { onMounted, onBeforeUnmount, nextTick } from 'vue'
import Lenis from 'lenis'
import gsap from 'gsap'
import ScrollTrigger from 'gsap/ScrollTrigger'

export const reduceMotion =
  (typeof matchMedia !== 'undefined' && matchMedia('(prefers-reduced-motion: reduce)').matches) ||
  (typeof location !== 'undefined' && location.search.includes('motion=off'))

let engineReady = false
let lenis = null

export function initEngine() {
  if (engineReady) return { gsap, ScrollTrigger, lenis }
  engineReady = true
  gsap.registerPlugin(ScrollTrigger)

  if (!reduceMotion) {
    document.documentElement.classList.add('r') // enables the .reveal hidden states in CSS

    lenis = new Lenis({ duration: 1.15, lerp: 0.095, smoothWheel: true })
    lenis.on('scroll', ScrollTrigger.update)
    gsap.ticker.add((t) => lenis.raf(t * 1000))
    gsap.ticker.lagSmoothing(0)
    if (typeof window !== 'undefined') window.__lenis = lenis

    if (matchMedia('(hover: hover)').matches) initMagnetic()
  }

  // keep ScrollTrigger positions honest as fonts/images/layout settle
  const refresh = () => ScrollTrigger.refresh()
  window.addEventListener('load', refresh)
  ;[400, 1000, 2000].forEach((t) => setTimeout(refresh, t))
  return { gsap, ScrollTrigger, lenis }
}

export function getLenis() {
  return lenis
}

export function scrollToTop(immediate = true) {
  if (lenis) lenis.scrollTo(0, { immediate })
  else window.scrollTo(0, 0)
}

export function scrollToEl(target, offset = -84) {
  const el = typeof target === 'string' ? document.querySelector(target) : target
  if (!el) return
  if (lenis) lenis.scrollTo(el, { offset })
  else el.scrollIntoView({ behavior: 'smooth' })
}

function initMagnetic() {
  let current = null
  const reset = (el) => el && gsap.to(el, { x: 0, y: 0, duration: 0.6, ease: 'elastic.out(1,0.4)' })
  document.addEventListener('pointermove', (e) => {
    const el = e.target.closest ? e.target.closest('.mag') : null
    if (el !== current) {
      reset(current)
      current = el
    }
    if (el) {
      const s = parseFloat(el.dataset.mag || '0.3')
      const r = el.getBoundingClientRect()
      gsap.to(el, {
        x: (e.clientX - r.left - r.width / 2) * s,
        y: (e.clientY - r.top - r.height / 2) * s,
        duration: 0.4,
        ease: 'power3.out',
      })
    }
  })
}

function runCounter(el) {
  const to = parseFloat(el.dataset.count)
  const dec = parseInt(el.dataset.dec || '0', 10)
  const pre = el.dataset.prefix || ''
  const suf = el.dataset.suffix || ''
  const fmt = (v) => (dec ? v.toFixed(dec) : Math.round(v).toLocaleString('en-US'))
  if (reduceMotion || !gsap) {
    el.textContent = pre + fmt(to) + suf
    return
  }
  const o = { v: 0 }
  gsap.to(o, { v: to, duration: 1.9, ease: 'power2.out', onUpdate: () => (el.textContent = pre + fmt(o.v) + suf) })
}

/**
 * Wire up motion for a view/section.
 * @param {Ref<HTMLElement>} rootRef  the component root element
 * @param {Function} [setup]  ({ gsap, ScrollTrigger, mm, root, inView }) => void
 *        Use `inView(elOrEls, onEnter)` for entrance animations — it fires
 *        reliably via IntersectionObserver and never leaves content hidden.
 */
export function useSolsticeMotion(rootRef, setup) {
  let ctx = null
  let mm = null
  const observers = []

  onMounted(async () => {
    initEngine()
    await nextTick()
    const root = rootRef?.value
    if (!root) return

    // ---- reveal everything immediately for reduced motion ----
    if (reduceMotion) {
      const revealAll = () => {
        root.querySelectorAll('.reveal,[data-stagger]').forEach((el) => el.classList.add('in'))
        root.querySelectorAll('[data-count]').forEach(runCounter)
      }
      revealAll()
      const mo = new MutationObserver(revealAll)
      mo.observe(root, { childList: true, subtree: true })
      observers.push({ disconnect: () => mo.disconnect() })
      return
    }

    // ---- IntersectionObserver-driven reveals (robust to async content) ----
    const revealIO = new IntersectionObserver(
      (entries) => {
        entries.forEach((e) => {
          if (!e.isIntersecting) return
          const el = e.target
          el.classList.add('in')
          if (el.hasAttribute('data-stagger')) {
            ;[...el.children].forEach((k, i) => (k.style.transitionDelay = i * 0.08 + 's'))
          }
          revealIO.unobserve(el)
        })
      },
      { rootMargin: '0px 0px -6% 0px', threshold: 0.04 }
    )
    const countIO = new IntersectionObserver(
      (entries) => entries.forEach((e) => { if (e.isIntersecting) { runCounter(e.target); countIO.unobserve(e.target) } }),
      { threshold: 0.5 }
    )
    const observeNew = () => {
      root.querySelectorAll('.reveal:not([data-obs]),[data-stagger]:not([data-obs])').forEach((el) => {
        el.setAttribute('data-obs', '')
        revealIO.observe(el)
      })
      root.querySelectorAll('[data-count]:not([data-obs])').forEach((el) => {
        el.setAttribute('data-obs', '')
        countIO.observe(el)
      })
    }
    observeNew()
    // catch content rendered after the initial mount (async API data)
    const mo = new MutationObserver(observeNew)
    mo.observe(root, { childList: true, subtree: true })
    observers.push(revealIO, countIO, { disconnect: () => mo.disconnect() })

    // ---- inView helper for signature entrance animations ----
    const inView = (target, onEnter, opts = {}) => {
      const els = target instanceof NodeList || Array.isArray(target) ? [...target] : [target]
      if (!els.length) return
      const io = new IntersectionObserver(
        (entries) => entries.forEach((e) => {
          if (e.isIntersecting) { onEnter(e.target); io.unobserve(e.target) }
        }),
        { rootMargin: opts.rootMargin || '0px 0px -8% 0px', threshold: opts.threshold ?? 0.08 }
      )
      els.forEach((el) => io.observe(el))
      observers.push(io)
    }

    // ---- signature animations (parallax + per-section setup) ----
    mm = gsap.matchMedia()
    ctx = gsap.context(() => {
      root.querySelectorAll('[data-par]').forEach((el) =>
        gsap.to(el, {
          y: parseFloat(el.dataset.par),
          ease: 'none',
          scrollTrigger: { trigger: el, start: 'top bottom', end: 'bottom top', scrub: true },
        })
      )
      if (setup) setup({ gsap, ScrollTrigger, mm, root, inView })
    }, root)

    ScrollTrigger.refresh()
  })

  onBeforeUnmount(() => {
    observers.forEach((o) => o.disconnect && o.disconnect())
    if (mm) mm.revert()
    if (ctx) ctx.revert()
  })
}
