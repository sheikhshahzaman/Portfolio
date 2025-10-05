<template>
  <div>
    <!-- Hero Section -->
    <HeroSection :profile="portfolioData?.profile" />

    <!-- Projects Section -->
    <ProjectsSection :projects="portfolioData?.projects" />

    <!-- Experience Section -->
    <ExperienceSection :experiences="portfolioData?.experiences" />

    <!-- Skills Section -->
    <SkillsSection :skills="portfolioData?.skills" />

    <!-- Testimonials Section -->
    <TestimonialsSection :testimonials="portfolioData?.testimonials" />

    <!-- Contact Section -->
    <ContactSection />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { portfolioAPI } from '../services/api'
import HeroSection from '../components/HeroSection.vue'
import ProjectsSection from '../components/ProjectsSection.vue'
import ExperienceSection from '../components/ExperienceSection.vue'
import SkillsSection from '../components/SkillsSection.vue'
import TestimonialsSection from '../components/TestimonialsSection.vue'
import ContactSection from '../components/ContactSection.vue'

const portfolioData = ref(null)
const loading = ref(true)

onMounted(async () => {
  try {
    const response = await portfolioAPI.getPortfolio()
    portfolioData.value = response.data
  } catch (error) {
    console.error('Error loading portfolio data:', error)
  } finally {
    loading.value = false
  }
})
</script>
