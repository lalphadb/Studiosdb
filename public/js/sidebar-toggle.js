// Sidebar Toggle Functionality
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar') || document.querySelector('.admin-sidebar');
    const main = document.querySelector('.admin-main');
    let toggleBtn = document.querySelector('.sidebar-toggle-btn');
    
    // Créer le bouton s'il n'existe pas
    if (!toggleBtn) {
        toggleBtn = document.createElement('button');
        toggleBtn.className = 'sidebar-toggle-btn';
        toggleBtn.innerHTML = '<i class="fas fa-bars"></i>';
        toggleBtn.setAttribute('aria-label', 'Toggle sidebar');
        toggleBtn.setAttribute('title', 'Toggle sidebar');
        document.body.appendChild(toggleBtn);
    }
    
    // Toggle functionality
    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        main.classList.toggle('sidebar-collapsed');
        
        // Sauvegarder l'état
        const isCollapsed = sidebar.classList.contains('collapsed');
        localStorage.setItem('sidebar-state', isCollapsed ? 'collapsed' : 'expanded');
        
        // Changer l'icône
        toggleBtn.innerHTML = isCollapsed ? '<i class="fas fa-chevron-right"></i>' : '<i class="fas fa-bars"></i>';
    });
    
    // Restaurer l'état sauvegardé
    const savedState = localStorage.getItem('sidebar-state');
    if (savedState === 'collapsed') {
        sidebar.classList.add('collapsed');
        main.classList.add('sidebar-collapsed');
        toggleBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
    }
    
    // Mobile menu overlay
    let overlay = document.querySelector('.mobile-overlay');
    if (!overlay) {
        overlay = document.createElement('div');
        overlay.className = 'mobile-overlay';
        document.body.appendChild(overlay);
    }
    
    overlay.addEventListener('click', () => {
        sidebar.classList.remove('mobile-open');
        overlay.classList.remove('active');
    });
    
    // Mobile toggle
    const mobileToggle = () => {
        if (window.innerWidth <= 768) {
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('active');
        }
    };
    
    // Attach mobile toggle to button on small screens
    window.addEventListener('resize', () => {
        if (window.innerWidth <= 768) {
            toggleBtn.removeEventListener('click', toggleBtn._desktopHandler);
            toggleBtn.addEventListener('click', mobileToggle);
        }
    });
});
