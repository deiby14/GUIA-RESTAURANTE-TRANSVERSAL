document.addEventListener('DOMContentLoaded', function() {
    const starContainers = document.querySelectorAll('.stars');

    starContainers.forEach(container => {
        const stars = Array.from(container.querySelectorAll('.star-rating'));
        const restaurantId = container.dataset.restaurantId;
        const ratingText = container.nextElementSibling;

        // Establecer puntuación inicial
        let currentRating = Math.round(parseInt(ratingText.textContent.match(/\d+/)[0]) || 0);
        updateStarDisplay(stars, currentRating);

        // Manejar click en las estrellas
        stars.forEach((star, index) => {
            // Hover
            star.addEventListener('mouseenter', () => {
                const rating = index + 1;
                updateStarDisplay(stars, rating);
                ratingText.textContent = `Puntuación: ${rating}/5`;
            });

            // Click
            star.addEventListener('click', () => {
                const rating = index + 1;
                fetch('/restaurantes/rate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        restaurant_id: restaurantId,
                        rating: rating
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        currentRating = rating;
                        updateStarDisplay(stars, rating);
                        ratingText.textContent = `Puntuación: ${rating}/5`;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });

        // Restaurar visualización al salir
        container.addEventListener('mouseleave', () => {
            updateStarDisplay(stars, currentRating);
            ratingText.textContent = `Puntuación: ${Math.round(currentRating)}/5`;
        });
    });
});

// Función para actualizar la visualización de las estrellas
function updateStarDisplay(stars, rating) {
    stars.forEach((star, index) => {
        if (index < rating) {
            star.classList.add('active');
        } else {
            star.classList.remove('active');
        }
    });
} 