import { onMounted, onUnmounted, ref } from 'vue'

export function useScrollAnimation() {
  let observer = null
  let mutationObserver = null

  const observeElements = () => {
    // Clean up previous observer if exists
    if (observer) {
      observer.disconnect()
    }

    observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('animate-in-view')
            // Optionally stop observing after animation
            // observer.unobserve(entry.target)
          }
        })
      },
      {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
      }
    )

    // Observe all elements with scroll-animate class
    const elements = document.querySelectorAll('.scroll-animate')
    elements.forEach((el) => {
      // Only observe elements that haven't been animated yet
      if (!el.classList.contains('animate-in-view')) {
        observer.observe(el)
      }
    })

    return observer
  }

  const setupMutationObserver = () => {
    // Watch for new elements being added to the DOM
    mutationObserver = new MutationObserver((mutations) => {
      let shouldReobserve = false
      mutations.forEach((mutation) => {
        if (mutation.addedNodes.length) {
          mutation.addedNodes.forEach((node) => {
            if (node.nodeType === 1) { // Element node
              if (node.classList?.contains('scroll-animate') ||
                  node.querySelector?.('.scroll-animate')) {
                shouldReobserve = true
              }
            }
          })
        }
      })

      if (shouldReobserve) {
        observeElements()
      }
    })

    mutationObserver.observe(document.body, {
      childList: true,
      subtree: true
    })
  }

  onMounted(() => {
    // Initial observation with delay
    setTimeout(() => {
      observeElements()
      setupMutationObserver()
    }, 100)

    // Re-observe after a longer delay to catch late-loading content
    setTimeout(observeElements, 500)
    setTimeout(observeElements, 1000)
  })

  onUnmounted(() => {
    if (observer) {
      observer.disconnect()
    }
    if (mutationObserver) {
      mutationObserver.disconnect()
    }
  })

  return {
    observeElements
  }
}
