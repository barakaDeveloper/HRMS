// Navigation functionality - FIXED VERSION
document.addEventListener('DOMContentLoaded', function () {
    // Don't run on profile pages
    if (window.location.pathname.includes('/profile')) {
        return;
    }

    const navLinks = document.querySelectorAll('.nav-link');
    const pageTitle = document.getElementById('page-title');

    navLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            // Don't intercept profile links or individual item pages
            if (this.href.includes('/profile') || this.hasAttribute('data-no-spa') || (this.href.includes('/admin/') && this.href.split('/').length > 4)) {
                return; // Allow normal navigation
            }

            e.preventDefault();

            // Remove active class from all links
            navLinks.forEach(nav => nav.classList.remove('active'));

            // Add active class to clicked link
            this.classList.add('active');

            // Update page title
            const sectionName = this.querySelector('span').textContent;
            if (pageTitle) {
                pageTitle.textContent = sectionName;
            }

            // Load content based on the section
            const section = this.getAttribute('data-section');
            loadSectionContent(section, this.href);
        });
    });

    function loadSectionContent(section, url) {
        const contentArea = document.querySelector('.px-4.lg\\:px-6.pb-6');

        if (!contentArea) {
            console.error('Content area not found');
            window.location.href = url; // Fallback to normal navigation
            return;
        }

        console.log(`Loading content for: ${section}`);

        // Show loading state
        contentArea.innerHTML = `
            <div class="flex justify-center items-center h-64">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
            </div>
        `;

        // Load content via AJAX
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(html => {
                contentArea.innerHTML = html;

                // Update browser URL without reloading page
                history.pushState({ section: section, url: url }, '', url);

                // Re-initialize any scripts in the loaded content
                initializeLoadedContent();
            })
            .catch(error => {
                console.error('Error loading content:', error);
                // Fallback to normal navigation
                window.location.href = url;
            });
    }

    function initializeLoadedContent() {
        // Re-initialize any dynamic content that was loaded
        console.log('Content loaded, re-initializing...');
    }

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function (event) {
        if (event.state && event.state.section) {
            const section = event.state.section;
            const url = event.state.url || `/admin/${section}`;

            // Don't handle profile pages or individual item pages
            if (url.includes('/profile') || (url.includes('/admin/') && url.split('/').length > 4)) {
                window.location.href = url;
                return;
            }

            const activeLink = document.querySelector(`[data-section="${section}"]`);
            if (activeLink) {
                navLinks.forEach(nav => nav.classList.remove('active'));
                activeLink.classList.add('active');

                const sectionName = activeLink.querySelector('span').textContent;
                if (pageTitle) {
                    pageTitle.textContent = sectionName;
                }
            }
            loadSectionContent(section, url);
        }
    });

    // Load initial content based on current URL
    const currentSection = getCurrentSectionFromURL();
    if (currentSection && !window.location.pathname.includes('/profile')) {
        const currentUrl = window.location.href;
        // Don't load SPA content for individual item pages
        if (!(currentUrl.includes('/admin/') && currentUrl.split('/').length > 4)) {
            loadSectionContent(currentSection, currentUrl);

            // Set active nav link
            const activeLink = document.querySelector(`[data-section="${currentSection}"]`);
            if (activeLink) {
                navLinks.forEach(nav => nav.classList.remove('active'));
                activeLink.classList.add('active');

                const sectionName = activeLink.querySelector('span').textContent;
                if (pageTitle) {
                    pageTitle.textContent = sectionName;
                }
            }
        }
    }

    function getCurrentSectionFromURL() {
        const path = window.location.pathname;
        // Don't load SPA content for individual item pages (show/edit pages)
        if (path.includes('/admin/employees/') && !path.includes('/profile') && path.split('/').length > 3) return null;
        if (path.includes('/admin/departments/') && path.split('/').length > 3) return null;
        if (path.includes('/admin/employees') && !path.includes('/profile')) return 'employees';
        if (path.includes('/admin/dashboard')) return 'dashboard';
        if (path.includes('/admin/departments')) return 'departments';
        if (path.includes('/admin/attendance')) return 'attendance';
        if (path.includes('/admin/payroll')) return 'payroll';
        if (path.includes('/admin/leave')) return 'leave';
        return null;
    }
});