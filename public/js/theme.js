// Theme functionality
document.addEventListener('DOMContentLoaded', function() {
    const toggle = document.getElementById('toggleTheme');
    const htmlElement = document.documentElement;

    // Load saved theme preference
    const savedTheme = localStorage.getItem('hrsync_theme');
    if (savedTheme === 'light') {
        htmlElement.classList.remove('dark');
    }

    // Toggle theme on button click
    if (toggle) {
        toggle.addEventListener('click', () => {
            htmlElement.classList.toggle('dark');
            const currentMode = htmlElement.classList.contains('dark') ? 'dark' : 'light';
            localStorage.setItem('hrsync_theme', currentMode);
        });
    }
});