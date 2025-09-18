function openJoinModal(department) {
  const deptInput = document.getElementById("departmentName");
  const modalTitle = document.getElementById("modalTitle");
  const dropdownWrapper = document.getElementById("fellowshipDropdownWrapper");

  // Show modal
  document.getElementById("joinModal").classList.remove("hidden");

  deptInput.value = department;
  deptInput.readOnly = true;
  modalTitle.innerText = `Join ${department}`;

  if (department === "Scheme Fellowships") {
    dropdownWrapper.classList.remove("hidden");
  } else {
    dropdownWrapper.classList.add("hidden");
  }
}

function closeJoinModal() {
    document.getElementById("joinModal").classList.add("hidden");
}

document.addEventListener('DOMContentLoaded', () => {
    // 📌 Mobile Menu Elements
    const menuToggle = document.getElementById("menu-toggle");
    const mobileMenu = document.getElementById("mobile-menu");
    const menuIcon = document.getElementById("menu-icon");
    const closeIcon = document.getElementById("close-icon");
    const aboutToggle = document.getElementById("about-toggle");
    const aboutDropdownMobile = document.getElementById("about-dropdown-mobile");
    const mobileLinks = document.querySelectorAll("#mobile-menu a");
    const contentDiv = document.getElementById("content");
    const body = document.body;

    // 📌 Desktop About Dropdown Elements
    const aboutButton = document.getElementById("about-btn");
    const aboutDropdown = document.getElementById("about-dropdown");

    // 📌 Restore Mobile Menu State
    if (sessionStorage.getItem("mobileMenuOpen") === "true") {
        mobileMenu.classList.remove("translate-x-full");
        closeIcon.classList.remove("hidden");
    } else {
        mobileMenu.classList.add("translate-x-full");
        closeIcon.classList.add("hidden");
    }

    // 📌 Mobile Menu Toggle
    function openMobileMenu() {
        mobileMenu.classList.remove("translate-x-full");
        closeIcon.classList.remove("hidden");
        sessionStorage.setItem("mobileMenuOpen", "true");
    }

    function closeMobileMenu() {
        mobileMenu.classList.add("translate-x-full");
        closeIcon.classList.add("hidden");
        sessionStorage.setItem("mobileMenuOpen", "false");
    }

    if (menuToggle) {
        menuToggle.addEventListener("click", (event) => {
            event.stopPropagation();
            openMobileMenu();
        });
    }

    if (closeIcon) {
        closeIcon.addEventListener("click", (event) => {
            event.stopPropagation();
            closeMobileMenu();
        });
    }

    // 📌 Close Mobile Menu When Clicking Outside
    document.addEventListener("click", (event) => {
        if (!mobileMenu.contains(event.target) && !menuToggle.contains(event.target)) {
            closeMobileMenu();
        }
    });

    // 📌 Mobile About Dropdown Toggle
    if (aboutToggle && aboutDropdownMobile) {
        aboutToggle.addEventListener("click", (event) => {
            event.stopPropagation();
            aboutDropdownMobile.classList.toggle("hidden");
        });

        mobileMenu.addEventListener("click", (event) => {
            if (!aboutToggle.contains(event.target) && !aboutDropdownMobile.contains(event.target)) {
                aboutDropdownMobile.classList.add("hidden");
            }
        });
    }

    // 📌 Ensure Mobile Menu Links are Clickable & Close Menu on Click
    mobileLinks.forEach(link => {
        link.addEventListener("click", (event) => {
            event.stopPropagation();
            closeMobileMenu();
        });
    });

    // 📌 Highlight Active Page in Mobile Menu
    const urlParams = new URLSearchParams(window.location.search);
    const currentPage = urlParams.get("page") || "home";

    mobileLinks.forEach(link => {
        const linkPage = new URL(link.href).searchParams.get("page") || "home";
        if (linkPage === currentPage) {
            link.classList.add("text-[#6C8BC9]", "font-bold");
        } else {
            link.classList.remove("text-[#6C8BC9]", "font-bold");
        }
    });

    // 📌 Desktop About Dropdown
    if (aboutButton && aboutDropdown) {
        aboutButton.addEventListener("click", (event) => {
            event.stopPropagation();
            aboutDropdown.classList.toggle("hidden");
        });

        document.addEventListener("click", (event) => {
            if (!aboutButton.contains(event.target) && !aboutDropdown.contains(event.target)) {
                aboutDropdown.classList.add("hidden");
            }
        });
    }

    // 📌 Handle Page Navigation Without Reloading
    mobileLinks.forEach(link => {
        link.addEventListener("click", (event) => {
            event.preventDefault();

            const pageUrl = link.getAttribute("href");

            fetch(pageUrl)
                .then(response => response.text())
                .then(data => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(data, "text/html");
                    const newContent = doc.getElementById("content");

                    if (newContent) {
                        contentDiv.innerHTML = newContent.innerHTML;
                        window.history.pushState(null, "", pageUrl);

                        // ✅ If Home Page is loaded, restart hero animation
                        if (pageUrl.includes("home")) {
                            startHeroAnimation();
                        }
                    } else {
                        console.error("Error: #content not found in the fetched page.");
                    }
                })
                .catch(error => console.error("Error loading page:", error));
        });
    });

    // 📌 Handle Browser Navigation (Back/Forward)
    window.addEventListener("popstate", () => {
        fetch(window.location.href)
            .then(response => response.text())
            .then(data => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(data, "text/html");
                const newContent = doc.getElementById("content");

                if (newContent) {
                    contentDiv.innerHTML = newContent.innerHTML;

                    // ✅ Restart hero animation if returning to home
                    if (window.location.href.includes("home")) {
                        startHeroAnimation();
                    }
                }
            })
            .catch(error => console.error("Error handling history state:", error));
    });

    // 📌 Restart Hero Section Animation After Page Load
    function startHeroAnimation() {
        const slides = document.querySelectorAll('.hero-slide');
        const heroTitle = document.getElementById('hero-title');
        const heroSubtext = document.getElementById('hero-subtext');
        let currentSlide = 0;

        function updateText() {
            const activeSlide = slides[currentSlide];
            const text = activeSlide.getAttribute('data-text');
            const subtext = activeSlide.getAttribute('data-subtext');

            heroTitle.textContent = text;
            heroSubtext.textContent = subtext;
        }

        updateText();
        setInterval(() => {
            slides[currentSlide].classList.remove('active');
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].classList.add('active');
            updateText();
        }, 5000);
    }

    // ✅ Ensure Hero Animation Starts on Page Load
    startHeroAnimation();
});