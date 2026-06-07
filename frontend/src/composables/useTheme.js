/* ============================================================
   useTheme — fetches the admin-controlled palette and applies
   it as CSS custom properties on :root at runtime.
   ============================================================ */
import { ref } from 'vue'
import { portfolioAPI } from '../services/api'

// Mirrors the presets in the original design's tweaks panel.
export const PALETTES = {
  Sunset: ['#ffc24b', '#ff7a3d', '#ff5360', '#b65cff'],
  Ember:  ['#ffb24b', '#ff6a3d', '#e8421f', '#a01f3c'],
  Coral:  ['#ffd76b', '#ff8a5c', '#ff5d8f', '#c44dff'],
  Citrus: ['#ffe14b', '#ffaa2e', '#ff6a3d', '#ff3d6e'],
  Berry:  ['#ff9a5c', '#ff5360', '#c44dff', '#6a5cff'],
}

const theme = ref(null)

export function applyTheme(t = {}) {
  const root = document.documentElement.style
  const preset = PALETTES[t.palette] || PALETTES.Sunset
  const amber  = t.amber  || preset[0]
  const orange = t.orange || preset[1]
  const coral  = t.coral  || preset[2]
  const violet = t.violet || preset[3]

  root.setProperty('--amber', amber)
  root.setProperty('--orange', orange)
  root.setProperty('--coral', coral)
  root.setProperty('--violet', violet)
  root.setProperty('--accent', t.accent || orange)
  root.setProperty('--accent-deep', t.accent_deep || coral)
  if (t.ink) root.setProperty('--ink', t.ink)
  if (t.bg) root.setProperty('--bg', t.bg)
  if (t.card) root.setProperty('--card', t.card)

  root.setProperty('--grad', `linear-gradient(100deg, ${amber}, ${orange} 42%, ${coral} 78%, ${violet})`)
  root.setProperty('--grad-soft', `linear-gradient(120deg, ${amber}, ${orange} 55%, ${coral})`)

  // optional solid logo color overrides the gradient wordmark
  root.setProperty('--logo', t.logo_color || 'transparent')

  const meta = document.querySelector('meta[name="theme-color"]')
  if (meta) meta.setAttribute('content', t.accent || orange)
}

export function useTheme() {
  const load = async () => {
    try {
      const { data } = await portfolioAPI.getTheme()
      theme.value = data || {}
      applyTheme(theme.value)
    } catch (e) {
      applyTheme({})
    }
  }
  return { theme, load, applyTheme }
}
