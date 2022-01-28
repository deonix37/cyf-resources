(() => {
    const statusForm = document.getElementById('status-form');

    if (!statusForm) {
        return;
    }

    statusForm.addEventListener('submit', (evt) => {
        if (!confirm('Change status?')) {
            evt.preventDefault();
        }
    });
})();
