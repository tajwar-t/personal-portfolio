/* =================================================================
   TAJWAR TAJIM — DEVELOPER PORTFOLIO
   Front-end interactivity for the static mockup.
   NOTE for WordPress conversion: this file has no build step and no
   external dependencies — it can be enqueued as-is via
   wp_enqueue_script() from functions.php.
================================================================= */
(function () {
  "use strict";

  var prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  /* ---------- Floating identity pill ---------- */
  (function identityPill() {
    var toggle = document.getElementById("identity-pill-toggle");
    var menu = document.getElementById("identity-pill-menu");
    if (!toggle || !menu) return;

    function closeMenu() {
      toggle.setAttribute("aria-expanded", "false");
      menu.classList.remove("open");
    }

    toggle.addEventListener("click", function (e) {
      e.stopPropagation();
      var isOpen = menu.classList.toggle("open");
      toggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
    });
    document.addEventListener("click", function (e) {
      if (!menu.contains(e.target) && e.target !== toggle) closeMenu();
    });
    window.addEventListener("keydown", function (e) {
      if (e.key === "Escape") closeMenu();
    });
  })();

  /* ---------- Theme toggle ---------- */
  (function themeToggle() {
    var root = document.documentElement;
    var toggle = document.getElementById("theme-toggle");
    var stored = localStorage.getItem("theme");
    var initial = stored === "dark" ? "dark" : "light";

    applyTheme(initial);

    toggle.addEventListener("click", function () {
      var next = root.getAttribute("data-theme") === "light" ? "dark" : "light";
      applyTheme(next);
      localStorage.setItem("theme", next);
    });

    function applyTheme(theme) {
      root.setAttribute("data-theme", theme);
      toggle.setAttribute("aria-pressed", theme === "light" ? "true" : "false");
      toggle.setAttribute("aria-label", theme === "light" ? "Switch to dark theme" : "Switch to light theme");
    }
  })();

  /* ---------- Mobile menu ---------- */
  (function mobileMenu() {
    var menuToggle = document.getElementById("menu-toggle");
    var nav = document.getElementById("main-nav");
    var scrim = document.getElementById("nav-scrim");

    function closeMenu() {
      menuToggle.setAttribute("aria-expanded", "false");
      nav.classList.remove("open");
      scrim.classList.remove("visible");
      document.body.style.overflow = "";
    }
    function openMenu() {
      menuToggle.setAttribute("aria-expanded", "true");
      nav.classList.add("open");
      scrim.classList.add("visible");
      document.body.style.overflow = "hidden";
    }

    menuToggle.addEventListener("click", function () {
      var isOpen = menuToggle.getAttribute("aria-expanded") === "true";
      isOpen ? closeMenu() : openMenu();
    });
    scrim.addEventListener("click", closeMenu);
    nav.querySelectorAll("a").forEach(function (link) {
      link.addEventListener("click", closeMenu);
    });
    window.addEventListener("keydown", function (e) {
      if (e.key === "Escape") closeMenu();
    });
  })();

  /* ---------- Sticky header + back-to-top + cursor glow ---------- */
  (function scrollEffects() {
    var header = document.getElementById("site-header");
    var backToTop = document.getElementById("back-to-top");

    function onScroll() {
      var scrolled = window.scrollY > 24;
      header.classList.toggle("scrolled", scrolled);
      backToTop.classList.toggle("visible", window.scrollY > 480);
    }
    window.addEventListener("scroll", onScroll, { passive: true });
    onScroll();

    backToTop.addEventListener("click", function () {
      window.scrollTo({ top: 0, behavior: prefersReducedMotion ? "auto" : "smooth" });
    });

    if (window.matchMedia("(hover: hover) and (pointer: fine)").matches) {
      var glow = document.getElementById("cursor-glow");
      window.addEventListener("pointermove", function (e) {
        glow.style.setProperty("--x", e.clientX + "px");
        glow.style.setProperty("--y", e.clientY + "px");
        glow.classList.add("active");
      });
      window.addEventListener("pointerleave", function () { glow.classList.remove("active"); });
    }
  })();

  /* ---------- Active nav link on scroll ---------- */
  (function activeNav() {
    var sections = Array.prototype.slice.call(document.querySelectorAll("main section[id]"));
    var navLinks = document.querySelectorAll(".nav-link");

    if (!sections.length || !("IntersectionObserver" in window)) return;

    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) return;
          navLinks.forEach(function (link) {
            link.classList.toggle("active", link.dataset.section === entry.target.id);
          });
        });
      },
      { rootMargin: "-45% 0px -50% 0px", threshold: 0 }
    );
    sections.forEach(function (section) { observer.observe(section); });
  })();

  /* ---------- Scroll-reveal + skill bars + counters ---------- */
  (function revealOnScroll() {
    var targets = document.querySelectorAll(".reveal");
    if (!targets.length) return;

    // Cache each counter's real target (its own displayed text — native
    // WordPress blocks like core/paragraph can't carry a custom data-count
    // attribute) into a stable dataset value up front, then blank it to 0.
    // animateCounters always reads from this cache, never from textContent,
    // so it stays safe to call more than once for the same node.
    document.querySelectorAll(".stat-num").forEach(function (node) {
      node.dataset.count = node.textContent.trim();
      node.textContent = "0";
    });

    if (prefersReducedMotion || !("IntersectionObserver" in window)) {
      targets.forEach(function (el) { el.classList.add("in-view"); });
      animateCounters(document.querySelectorAll(".stat-num"));
      return;
    }

    var observer = new IntersectionObserver(
      function (entries, obs) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) return;
          entry.target.classList.add("in-view");
          if (entry.target.classList.contains("hero-stats")) {
            animateCounters(entry.target.querySelectorAll(".stat-num"));
          }
          obs.unobserve(entry.target);
        });
      },
      { threshold: 0.2 }
    );
    targets.forEach(function (el) { observer.observe(el); });
  })();

  function animateCounters(nodes) {
    nodes.forEach(function (node) {
      var target = parseInt(node.dataset.count, 10) || 0;
      var duration = 1400;
      var startTime = null;

      function step(timestamp) {
        if (startTime === null) startTime = timestamp;
        var progress = Math.min((timestamp - startTime) / duration, 1);
        var eased = 1 - Math.pow(1 - progress, 3);
        node.textContent = Math.round(eased * target);
        if (progress < 1) requestAnimationFrame(step);
      }
      requestAnimationFrame(step);
    });
  }

  /* ---------- Project filter ---------- */
  (function projectFilter() {
    var tabs = document.querySelectorAll(".filter-tab");
    var cards = document.querySelectorAll(".project-card");
    if (!tabs.length) return;

    tabs.forEach(function (tab) {
      tab.addEventListener("click", function () {
        tabs.forEach(function (t) {
          t.classList.remove("active");
          t.setAttribute("aria-selected", "false");
        });
        tab.classList.add("active");
        tab.setAttribute("aria-selected", "true");

        var filter = tab.dataset.filter;
        cards.forEach(function (card) {
          var show = filter === "all" || card.dataset.category === filter;
          card.classList.toggle("hidden", !show);
        });
      });
    });
  })();

  /* ---------- Testimonial slider ---------- */
  (function testimonialSlider() {
    var track = document.getElementById("testimonial-track");
    if (!track) return;
    var slides = track.querySelectorAll(".testimonial-slide");
    var dotsWrap = document.getElementById("testimonial-dots");
    var prevBtn = document.getElementById("testimonial-prev");
    var nextBtn = document.getElementById("testimonial-next");
    var current = 0;
    var autoplayId;

    slides.forEach(function (_, i) {
      var dot = document.createElement("button");
      dot.setAttribute("aria-label", "Go to testimonial " + (i + 1));
      dot.addEventListener("click", function () { goTo(i); });
      dotsWrap.appendChild(dot);
    });
    var dots = dotsWrap.querySelectorAll("button");

    function goTo(index) {
      current = (index + slides.length) % slides.length;
      slides.forEach(function (s, i) { s.classList.toggle("active", i === current); });
      dots.forEach(function (d, i) { d.classList.toggle("active", i === current); });
    }

    function resetAutoplay() {
      clearInterval(autoplayId);
      if (prefersReducedMotion) return;
      autoplayId = setInterval(function () { goTo(current + 1); }, 6000);
    }

    prevBtn.addEventListener("click", function () { goTo(current - 1); resetAutoplay(); });
    nextBtn.addEventListener("click", function () { goTo(current + 1); resetAutoplay(); });
    track.addEventListener("mouseenter", function () { clearInterval(autoplayId); });
    track.addEventListener("mouseleave", resetAutoplay);

    goTo(0);
    resetAutoplay();
  })();

  /* ---------- Contact form ----------
     Submits to WordPress via admin-ajax.php (action: tj_contact_form),
     using the ajaxUrl/nonce localized onto window.tjContactForm by
     inc/contact-form.php's wp_localize_script() call. ------------------- */
  (function contactForm() {
    var form = document.getElementById("contact-form");
    if (!form) return;
    var status = document.getElementById("form-status");

    form.addEventListener("submit", function (e) {
      e.preventDefault();
      if (!form.checkValidity()) {
        status.textContent = "Please fill in all required fields with a valid email.";
        status.style.color = "#ffb454";
        return;
      }
      if (typeof tjContactForm === "undefined") return;

      var submitBtn = form.querySelector(".form-submit");
      if (submitBtn) submitBtn.disabled = true;

      var data = new FormData();
      data.append("action", "tj_contact_form");
      data.append("nonce", tjContactForm.nonce);
      data.append("name", form.elements["name"].value);
      data.append("email", form.elements["email"].value);
      data.append("subject", form.elements["subject"].value);
      data.append("message", form.elements["message"].value);

      fetch(tjContactForm.ajaxUrl, {
        method: "POST",
        credentials: "same-origin",
        body: data
      })
        .then(function (response) { return response.json(); })
        .then(function (result) {
          if (result.success) {
            status.textContent = result.data.message;
            status.style.color = "";
            form.reset();
          } else {
            status.textContent = result.data.message;
            status.style.color = "#ffb454";
          }
        })
        .catch(function () {
          status.textContent = "Something went wrong sending your message. Please try again or email me directly.";
          status.style.color = "#ffb454";
        })
        .then(function () {
          if (submitBtn) submitBtn.disabled = false;
        });
    });
  })();

  /* ---------- Footer year ---------- */
  document.getElementById("year").textContent = new Date().getFullYear();
})();
