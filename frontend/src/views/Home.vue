<script setup>
import { computed, onMounted } from 'vue'
import { useHead } from '@unhead/vue'
import { usePortfolio } from '../composables/usePortfolio'
import HeroSection from '../components/HeroSection.vue'
import ProjectsSection from '../components/ProjectsSection.vue'
import ExperienceSection from '../components/ExperienceSection.vue'
import EducationSection from '../components/EducationSection.vue'
import SkillsSection from '../components/SkillsSection.vue'
import TestimonialsSection from '../components/TestimonialsSection.vue'
import ContactSection from '../components/ContactSection.vue'

const { data, load } = usePortfolio()

const profile = computed(() => data.value?.profile || {})
const projects = computed(() => data.value?.projects || [])
const experiences = computed(() => data.value?.experiences || [])
const skills = computed(() => data.value?.skills || {})
const education = computed(() => data.value?.education || [])
const testimonials = computed(() => data.value?.testimonials || [])
const seo = computed(() => data.value?.seo || {})

useHead({
  title: computed(() => seo.value.meta_title || `${profile.value.name || 'Shahzaman'} — ${profile.value.title || 'Software Engineer'}`),
  meta: computed(() => [
    { name: 'description', content: seo.value.meta_description || profile.value.bio || '' },
    { name: 'keywords', content: seo.value.meta_keywords || '' },
    { property: 'og:title', content: seo.value.og_title || seo.value.meta_title || profile.value.name },
    { property: 'og:description', content: seo.value.og_description || seo.value.meta_description || '' },
    { property: 'og:image', content: seo.value.og_image || '' },
    { name: 'twitter:card', content: seo.value.twitter_card || 'summary_large_image' },
  ]),
})

onMounted(() => {
  if (!data.value) load(localStorage.getItem('selectedLanguage') || 'en').catch(() => {})
})
</script>

<template>
  <main>
    <div v-if="!data" class="loader"><div class="spinner"></div></div>
    <template v-else>
      <HeroSection :profile="profile" />
      <ProjectsSection :projects="projects" />
      <ExperienceSection :experiences="experiences" />
      <EducationSection :education="education" />
      <SkillsSection :skills="skills" />
      <TestimonialsSection :testimonials="testimonials" />
      <ContactSection :profile="profile" />
    </template>
  </main>
</template>
