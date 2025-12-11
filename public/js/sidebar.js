// Sidebar functionality
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.getElementById('overlay');
    if (sidebar && overlay) {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('active');
    }
}

document.addEventListener('click', function(event) {
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.getElementById('overlay');
    
    if (window.innerWidth < 1024 && sidebar && overlay) {
        if (!sidebar.contains(event.target) && !event.target.closest('[onclick*="toggleSidebar"]') && sidebar.classList.contains('open')) {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
        }
    }
});

// Make function globally available
window.toggleSidebar = toggleSidebar;