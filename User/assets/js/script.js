
        // Toggle Sidebar on Mobile
       function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const icon = document.getElementById('menuIcon');

    sidebar.classList.toggle('active');

    if (sidebar.classList.contains('active')) {
        icon.classList.remove('fa-bars');
        icon.classList.add('fa-xmark');
    } else {
        icon.classList.remove('fa-xmark');
        icon.classList.add('fa-bars');
    }
}

        // Toggle Sidebar Dropdown
        function toggleDrop(btn) {

    const container = btn.nextElementSibling;
    const chevron = btn.querySelector('.chevron');

    container.classList.toggle("show");
    chevron.classList.toggle("rotate");

}

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.menu-toggle');
            if (window.innerWidth <= 992 && 
                !sidebar.contains(e.target) && 
                !toggle.contains(e.target) && 
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });
function switchTab(event, tabId) {
    // 1. Deactivate all tab buttons
    const buttons = document.querySelectorAll('.tab-btn');
    buttons.forEach(btn => btn.classList.remove('active'));

    // 2. Hide all tab content
    const contents = document.querySelectorAll('.tab-content');
    contents.forEach(content => content.classList.remove('active'));

    // 3. Activate current button and show targeted content
    event.currentTarget.classList.add('active');
    document.getElementById(tabId).classList.add('active');
}