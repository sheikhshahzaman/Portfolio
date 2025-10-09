<template>
  <section id="projects" class="py-20 px-4 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-7xl mx-auto">
      <h2 class="text-4xl font-bold text-center mb-12 gradient-text">
        {{ t('projects.featured_projects', 'Featured Projects') }}
      </h2>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div
          v-for="project in projects"
          :key="project.id"
          class="bg-white dark:bg-gray-900 rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2 flex flex-col"
        >
          <div class="aspect-video relative overflow-hidden">
            <img
              v-if="project.image_url"
              :src="project.image_url"
              :alt="project.title"
              class="w-full h-full object-cover"
            />
            <div v-else class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600"></div>
          </div>
          <div class="p-6 flex flex-col flex-1">
            <h3 class="text-xl font-bold mb-2">{{ project.title }}</h3>
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
            <div class="flex gap-4 mt-auto">
              <a
                v-if="project.demo_url"
                :href="project.demo_url"
                target="_blank"
                class="text-blue-600 hover:text-blue-700 dark:text-blue-400"
              >
                {{ t('projects.live_demo', 'Live Demo →') }}
              </a>
              <a
                v-if="project.github_url"
                :href="project.github_url"
                target="_blank"
                class="text-gray-600 hover:text-gray-700 dark:text-gray-400"
              >
                {{ t('projects.github', 'GitHub →') }}
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { useTranslations } from '../composables/useTranslations'

const { t } = useTranslations()

defineProps({
  projects: {
    type: Array,
    default: () => []
  }
})
</script>
