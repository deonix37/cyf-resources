(() => {
    const destroyForm = document.getElementById('destroy-form');

    if (!destroyForm) {
        return;
    }

    destroyForm.addEventListener('submit', (evt) => {
        if (!confirm('Delete the resource?')) {
            evt.preventDefault();
        }
    });
})();
