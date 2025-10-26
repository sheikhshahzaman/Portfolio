import axios from 'axios'

const API_URL = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'

const api = axios.create({
  baseURL: API_URL,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  }
})

export const portfolioAPI = {
  // Get all portfolio data
  getPortfolio(lang = 'en') {
    return api.get(`/portfolio?lang=${lang}`)
  },

  // Projects
  getProjects() {
    return api.get('/portfolio/projects')
  },

  getProject(slug) {
    return api.get(`/portfolio/projects/${slug}`)
  },

  // Experiences
  getExperiences() {
    return api.get('/portfolio/experiences')
  },

  // Skills
  getSkills() {
    return api.get('/portfolio/skills')
  },

  // Services
  getServices() {
    return api.get('/portfolio/services')
  },

  // Blog
  getBlogPosts(page = 1) {
    return api.get(`/portfolio/blog?page=${page}`)
  },

  getBlogPost(slug) {
    return api.get(`/portfolio/blog/${slug}`)
  },

  // Contact
  sendContactMessage(data) {
    return api.post('/contact', data)
  },

  // Languages
  getLanguages() {
    return api.get('/languages')
  },

  // Translations
  getTranslations(lang = 'en') {
    return api.get(`/translations?lang=${lang}`)
  }
}

export default api
