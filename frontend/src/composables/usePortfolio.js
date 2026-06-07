/* ============================================================
   usePortfolio — shared, cached fetch of the full portfolio
   payload (profile, projects, experiences, skills, education,
   testimonials, recent_posts, theme, copy). Shared across the
   home sections and footer so we only hit the API once.
   ============================================================ */
import { ref } from 'vue'
import { portfolioAPI } from '../services/api'

const data = ref(null)
const loading = ref(false)
const error = ref(null)
let pending = null

export function usePortfolio() {
  const load = async (lang = 'en', force = false) => {
    if (data.value && !force) return data.value
    if (pending && !force) return pending
    loading.value = true
    error.value = null
    pending = portfolioAPI
      .getPortfolio(lang)
      .then((res) => {
        data.value = res.data
        loading.value = false
        pending = null
        return res.data
      })
      .catch((err) => {
        error.value = err
        loading.value = false
        pending = null
        throw err
      })
    return pending
  }

  const reload = (lang = 'en') => load(lang, true)

  return { data, loading, error, load, reload }
}
