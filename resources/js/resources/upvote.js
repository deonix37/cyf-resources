(() => {
    document.addEventListener('click', function (evt) {
        const button = evt.target.closest('[data-upvote-btn');

        if (!button) {
            return;
        }

        const icon = button.querySelector('[data-icon]');
        const counter = button.querySelector('[data-counter]');
        const resource = button.closest('[data-resource]');

        const toggleUpvote = function toggleUpvote() {
            if (button.dataset.upvote) {
                return axios.delete(`/api/upvotes/${button.dataset.upvote}`);
            }

            return axios.post(
                `/api/resources/${resource.dataset.resource}/upvotes`,
            );
        };

        const updateCounter = function updateCounter() {
            axios.head(`/api/resources/${resource.dataset.resource}/upvotes`)
                .then((response) => {
                    const totalCount = response.headers['x-total-count'];
                    const userUpvoteId = response.headers['x-user-upvote-id'];
                    const upvoted = Boolean(userUpvoteId);

                    button.classList.toggle('bg-white', !upvoted);
                    button.classList.toggle('bg-rose-600', upvoted);
                    button.classList.toggle('border-black', !upvoted);
                    button.classList.toggle('text-white', upvoted);
                    icon.classList.toggle('fill-white', upvoted);
                    icon.classList.toggle('fill-black', !upvoted);

                    counter.textContent = totalCount;
                    button.dataset.upvote = userUpvoteId;
                });
        };

        toggleUpvote().finally(updateCounter);
    });
})();
