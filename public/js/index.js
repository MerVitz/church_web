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

document.addEventListener("DOMContentLoaded", () => {
    // Elements
    const menuToggle = document.getElementById("menu-toggle");
    const mobileMenu = document.getElementById("mobile-menu");
    const closeIcon = document.getElementById("close-icon");
    const aboutToggle = document.getElementById("about-toggle");
    const aboutDropdownMobile = document.getElementById("about-dropdown-mobile");
    const mobileLinks = document.querySelectorAll("#mobile-menu a");
    const contentDiv = document.getElementById("content");
    const aboutButton = document.getElementById("about-btn");
    const aboutDropdown = document.getElementById("about-dropdown");

    // Restore Mobile Menu State
    if (sessionStorage.getItem("mobileMenuOpen") === "true") {
        mobileMenu.classList.remove("translate-x-full");
        closeIcon.classList.remove("hidden");
    } else {
        mobileMenu.classList.add("translate-x-full");
        closeIcon.classList.add("hidden");
    }

    // Mobile Menu Toggle
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
    document.addEventListener("click", (event) => {
        if (!mobileMenu.contains(event.target) && !menuToggle.contains(event.target)) {
            closeMobileMenu();
        }
    });

    // Mobile About Dropdown
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

    // Highlight Active Link (shared for desktop + mobile)
    function setActiveLink(page) {
        // Reset
        document.querySelectorAll("nav a").forEach((link) => {
            link.classList.remove("text-[#6C8BC9]", "font-bold", "bg-[#6C8BC9]", "text-white");
            link.classList.add("text-black");
        });

        // Desktop
        const desktopActive = document.querySelector(`nav a[href="/?page=${page}"]`);
        if (desktopActive) {
            desktopActive.classList.remove("text-black");
            desktopActive.classList.add("text-[#6C8BC9]", "font-bold");
        }

        // Mobile
        const mobileActive = document.querySelector(`#mobile-menu a[href="/?page=${page}"]`);
        if (mobileActive) {
            if (mobileActive.closest("#about-dropdown-mobile")) {
                mobileActive.classList.remove("text-black");
                mobileActive.classList.add("bg-[#6C8BC9]", "text-white", "font-bold");
            } else {
                mobileActive.classList.remove("text-black");
                mobileActive.classList.add("text-[#6C8BC9]", "font-bold");
            }
        }
    }

    // Initial highlight
    const urlParams = new URLSearchParams(window.location.search);
    setActiveLink(urlParams.get("page") || "home");

    // Desktop About Dropdown
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

    // Handle Page Navigation Without Reloading
    mobileLinks.forEach((link) => {
        link.addEventListener("click", (event) => {
            const pageUrl = link.getAttribute("href");
            if (pageUrl.includes("admin-login")) return; // Let browser handle

            event.preventDefault();
            closeMobileMenu();

            fetch(pageUrl)
                .then((response) => response.text())
                .then((data) => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(data, "text/html");
                    const newContent = doc.getElementById("content");
                    if (newContent) {
                        contentDiv.innerHTML = newContent.innerHTML;
                        window.history.pushState(null, "", pageUrl);

                        const newPage = new URL(pageUrl, window.location.origin).searchParams.get("page") || "home";
                        setActiveLink(newPage);

                        if (newPage === "home") startHeroAnimation();
                    } else {
                        console.error("#content not found in fetched page");
                    }
                })
                .catch((error) => console.error("Error loading page:", error));
        });
    });

    // Browser Back/Forward
    window.addEventListener("popstate", () => {
        fetch(window.location.href)
            .then((response) => response.text())
            .then((data) => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(data, "text/html");
                const newContent = doc.getElementById("content");
                if (newContent) {
                    contentDiv.innerHTML = newContent.innerHTML;

                    const newPage = new URL(window.location.href).searchParams.get("page") || "home";
                    setActiveLink(newPage);

                    if (newPage === "home") startHeroAnimation();
                }
            })
            .catch((error) => console.error("Error handling history state:", error));
    });

    // Hero Animation
    function startHeroAnimation() {
        const slides = document.querySelectorAll(".hero-slide");
        const heroTitle = document.getElementById("hero-title");
        const heroSubtext = document.getElementById("hero-subtext");
        let currentSlide = 0;

        function updateText() {
            const activeSlide = slides[currentSlide];
            const text = activeSlide.getAttribute("data-text");
            const subtext = activeSlide.getAttribute("data-subtext");
            heroTitle.textContent = text;
            heroSubtext.textContent = subtext;
        }

        updateText();
        setInterval(() => {
            slides[currentSlide].classList.remove("active");
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].classList.add("active");
            updateText();
        }, 5000);
    }

    // Run animation initially
    startHeroAnimation();
});
