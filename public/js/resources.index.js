(() => {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggleBtn = document.getElementById('sidebar-toggle');
    const catalog = document.getElementById('catalog');

    sidebarToggleBtn.addEventListener('click', () => {
        const hidden = sidebar.classList.contains('hidden');

        sidebar.classList.toggle('hidden', !hidden);
        sidebar.classList.toggle('w-64', !hidden);
        sidebar.classList.toggle('w-full', hidden);

        catalog.classList.toggle('hidden', hidden);
    });

    window.addEventListener('resize', function () {
        const hidden = sidebar.classList.contains('hidden');

        if (window.innerWidth >= 640 && !hidden) {
            sidebarToggleBtn.click();
        }
    });
})();
