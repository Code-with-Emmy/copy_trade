// Smooth scroll behavior
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
  anchor.addEventListener("click", function (e) {
    e.preventDefault()
    const target = document.querySelector(this.getAttribute("href"))
    if (target) {
      target.scrollIntoView({
        behavior: "smooth",
        block: "start",
      })
    }
  })
})

// Range slider input
const investRange = document.getElementById("investRange")
const rangeValue = document.getElementById("rangeValue")

if (investRange) {
  investRange.addEventListener("input", function () {
    const value = Number.parseInt(this.value).toLocaleString()
    rangeValue.textContent = `$${value}`
  })
}

// Animated counter for statistics
const animateCounter = (element, target, duration = 2000) => {
  let current = 0
  const increment = target / (duration / 16)

  const timer = setInterval(() => {
    current += increment
    if (current >= target) {
      current = target
      clearInterval(timer)
    }

    if (target > 100) {
      element.textContent = Math.floor(current).toLocaleString()
    } else {
      element.textContent = Math.floor(current)
    }
  }, 16)
}

// Intersection Observer for counter animation
const observerOptions = {
  threshold: 0.5,
  rootMargin: "0px",
}

const counterObserver = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting && !entry.target.classList.contains("animated")) {
      const target = Number.parseInt(entry.target.dataset.target)
      animateCounter(entry.target, target)
      entry.target.classList.add("animated")
    }
  })
}, observerOptions)

document.querySelectorAll(".stat-number").forEach((el) => {
  counterObserver.observe(el)
})

// Newsletter form submission
const newsletterForm = document.getElementById("newsletterForm")
if (newsletterForm) {
  newsletterForm.addEventListener("submit", function (e) {
    e.preventDefault()
    const email = this.querySelector('input[type="email"]').value
    console.log("Newsletter subscription:", email)

    // Reset form
    this.reset()

    // Show success message (optional)
    alert("Thank you for subscribing!")
  })
}

// Mobile menu toggle
const navToggle = document.querySelector(".nav-toggle")
const mobileMenu = document.querySelector(".mobile-menu")
const mobileMenuLinks = mobileMenu ? mobileMenu.querySelectorAll("a") : []
const mobileMenuButtons = mobileMenu ? mobileMenu.querySelectorAll(".nav-btn") : []

// Dynamic current year
const currentYearEl = document.getElementById("currentYear")
if (currentYearEl) {
  currentYearEl.textContent = new Date().getFullYear()
}

const closeMobileNav = () => {
  if (!mobileMenu || !navToggle) return
  mobileMenu.classList.remove("open")
  mobileMenu.setAttribute("aria-hidden", "true")
  navToggle.classList.remove("is-active")
  navToggle.setAttribute("aria-expanded", "false")
  document.body.classList.remove("nav-open")
}

const handleMobileMenu = () => {
  if (window.innerWidth > 768) {
    closeMobileNav()
  }
}

window.addEventListener("resize", handleMobileMenu)
window.addEventListener("load", handleMobileMenu)

if (navToggle && mobileMenu) {
  navToggle.addEventListener("click", () => {
    const willOpen = !mobileMenu.classList.contains("open")
    mobileMenu.classList.toggle("open", willOpen)
    mobileMenu.setAttribute("aria-hidden", String(!willOpen))
    navToggle.setAttribute("aria-expanded", String(willOpen))
    navToggle.classList.toggle("is-active", willOpen)
    document.body.classList.toggle("nav-open", willOpen)
  })
}

;[...mobileMenuLinks, ...mobileMenuButtons].forEach((element) => {
  element.addEventListener("click", () => {
    if (window.innerWidth <= 768) {
      closeMobileNav()
    }
  })
})

// Intersection Observer for fade-in animations on scroll
const fadeInObserver = new IntersectionObserver(
  (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = "1"
        entry.target.style.transform = "translateY(0)"
      }
    })
  },
  {
    threshold: 0.1,
    rootMargin: "0px 0px -100px 0px",
  },
)

document
  .querySelectorAll(
    ".journey-card, .copy-feature-card, .step-card, .faq-item, .testimonial-card",
  )
  .forEach((el) => {
  el.style.opacity = "0"
  el.style.transform = "translateY(20px)"
  el.style.transition = "opacity 0.6s ease, transform 0.6s ease"
  fadeInObserver.observe(el)
})

// Smooth hover effect for phone mockup
const phoneMockup = document.querySelector(".phone-frame")
if (phoneMockup) {
  document.addEventListener("mousemove", (e) => {
    const rect = phoneMockup.getBoundingClientRect()
    const x = (e.clientX - rect.left) / rect.width
    const y = (e.clientY - rect.top) / rect.height

    const rotateX = (y - 0.5) * 10
    const rotateY = (x - 0.5) * 10

    phoneMockup.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`
  })

  document.addEventListener("mouseleave", () => {
    phoneMockup.style.transform = "rotateX(0) rotateY(0)"
  })
}

// Button click animations
document.querySelectorAll(".btn-primary, .btn-secondary").forEach((btn) => {
  btn.addEventListener("click", function (e) {
    const ripple = document.createElement("span")
    ripple.className = "ripple"
    this.appendChild(ripple)

    setTimeout(() => ripple.remove(), 600)
  })
})

// FAQ accordion
const faqItems = document.querySelectorAll(".faq-item")

faqItems.forEach((item) => {
  const toggle = item.querySelector(".faq-toggle")
  const answer = item.querySelector(".faq-answer")

  if (item.classList.contains("open")) {
    answer.style.maxHeight = `${answer.scrollHeight}px`
  }

  toggle.addEventListener("click", () => {
    const isOpen = item.classList.toggle("open")
    toggle.setAttribute("aria-expanded", String(isOpen))

    if (isOpen) {
      answer.style.maxHeight = `${answer.scrollHeight}px`
    } else {
      answer.style.maxHeight = null
    }
  })
})

window.addEventListener("resize", () => {
  faqItems.forEach((item) => {
    const answer = item.querySelector(".faq-answer")
    if (item.classList.contains("open")) {
      answer.style.maxHeight = `${answer.scrollHeight}px`
    }
  })
})
