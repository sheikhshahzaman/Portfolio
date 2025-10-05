<template>
  <div class="min-h-screen py-20 px-4 pt-24">
    <div class="max-w-7xl mx-auto">
      <h1 class="text-5xl font-bold text-center mb-4 gradient-text">
        All Projects
      </h1>
      <p class="text-center text-gray-600 dark:text-gray-400 mb-12">
        Explore my portfolio of web applications and platforms
      </p>

      <div v-if="loading" class="text-center py-20">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
      </div>

      <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div
          v-for="project in projects"
          :key="project.id"
          class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2"
        >
          <div class="aspect-video bg-gradient-to-br from-blue-500 to-purple-600"></div>
          <div class="p-6">
            <div class="flex items-center justify-between mb-2">
              <h3 class="text-xl font-bold">{{ project.title }}</h3>
              <span v-if="project.is_featured" class="text-xs px-2 py-1 bg-yellow-400 text-yellow-900 rounded-full">
                Featured
              </span>
            </div>
            <p class="text-sm text-blue-600 dark:text-blue-400 mb-2">{{ project.category }}</p>
            <p class="text-gray-600 dark:text-gray-400 mb-4">
              {{ project.short_description }}
            </p>
            <div class="flex flex-wrap gap-2 mb-4">
              <span
                v-for="tech in project.technologies"
                :key="tech"
                class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 rounded-full text-sm"
              >
                {{ tech }}
              </span>
            </div>
            <div class="flex gap-4">
              <router-link
                :to="`/projects/${project.slug}`"
                class="text-blue-600 hover:text-blue-700 dark:text-blue-400 font-medium"
              >
                View Details →
              </router-link>
              <a
                v-if="project.demo_url"
                :href="project.demo_url"
                target="_blank"
                class="text-gray-600 hover:text-gray-700 dark:text-gray-400"
              >
                Live Demo →
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { portfolioAPI } from '../services/api'

const projects = ref([])
const loading = ref(true)

onMounted(async () => {
  try {
    const response = await portfolioAPI.getProjects()
    projects.value = response.data
  } catch (error) {
    console.error('Error loading projects:', error)
  } finally {
    loading.value = false
  }
})
</script>
