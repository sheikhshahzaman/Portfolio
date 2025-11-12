<template>
  <section id="projects" class="py-20 px-4 bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50 dark:from-gray-800 dark:via-gray-800 dark:to-gray-900">
    <div class="max-w-7xl mx-auto">
      <h2 class="scroll-animate text-4xl font-bold text-center mb-4 gradient-text">
        {{ t('projects.featured_projects', 'Featured Projects') }}
      </h2>
      <p class="scroll-animate text-center text-gray-600 dark:text-gray-400 mb-12 text-lg max-w-2xl mx-auto" style="animation-delay: 0.1s">
        {{ t('projects.subtitle', 'Check out some of my recent work') }}
      </p>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div
          v-for="(project, index) in projects"
          :key="project.id"
          class="scroll-animate group bg-white dark:bg-gray-900 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-3 hover:scale-105 flex flex-col border-2 border-transparent hover:border-blue-500"
          :style="{ animationDelay: (index * 0.1 + 0.2) + 's' }"
        >
          <div class="aspect-video relative overflow-hidden bg-gradient-to-br from-blue-500 to-purple-600">
            <img
              v-if="project.image_url"
              :src="project.image_url"
              :alt="project.title"
              class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500"
            />
            <div v-else class="w-full h-full flex items-center justify-center">
              <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
          </div>
          <div class="p-6 flex flex-col flex-1">
            <h3 class="text-xl font-bold mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ project.title }}</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-2 whitespace-pre-line">
              {{ project.short_description }}
            </p>
            <div class="flex flex-wrap gap-2 mb-4">
              <span
                v-for="tech in project.technologies"
                :key="tech"
                class="px-3 py-1 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900 dark:to-purple-900 text-blue-600 dark:text-blue-300 rounded-full text-sm font-medium hover:scale-110 transition-transform duration-200"
              >
                {{ tech }}
              </span>
            </div>
            <div class="flex gap-4 mt-auto pt-4 border-t border-gray-200 dark:border-gray-700">
              <a
                v-if="project.demo_url"
                :href="project.demo_url"
                target="_blank"
                class="flex items-center gap-1 text-blue-600 hover:text-blue-700 dark:text-blue-400 font-medium group/link"
              >
                <span>{{ t('projects.live_demo', 'Live Demo') }}</span>
                <svg class="w-4 h-4 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
              </a>
              <a
                v-if="project.github_url"
                :href="project.github_url"
                target="_blank"
                class="flex items-center gap-1 text-gray-600 hover:text-gray-700 dark:text-gray-400 font-medium group/link"
              >
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                </svg>
                <span class="transform group-hover/link:translate-x-1 transition-transform">{{ t('projects.github', 'GitHub') }}</span>
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="text-center mt-12">
        <router-link
          to="/projects"
          class="scroll-animate inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-full font-semibold hover:scale-105 hover:shadow-lg hover:shadow-blue-500/50 transition-all duration-300"
          style="animation-delay: 0.8s"
        >
          <span>{{ t('projects.view_all', 'View All Projects') }}</span>
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
          </svg>
        </router-link>
      </div>
    </div>
  </section>
</template>

<script setup>
import { useTranslations } from '../composables/useTranslations'
import { useScrollAnimation } from '../composables/useScrollAnimation'

const { t } = useTranslations()
useScrollAnimation()

defineProps({
  projects: {
    type: Array,
    default: () => []
  }
})
</script>
