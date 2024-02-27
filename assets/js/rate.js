let selectedScore = 0;

document.addEventListener("DOMContentLoaded", function() {
    const stars = document.querySelectorAll(".form-check-input");
    const labelStars = document.querySelectorAll(".form-check-label");

    stars.forEach((star) => {
      star.addEventListener("click", (event) => {
        const clickedStar = event.currentTarget;
        const rating = clickedStar.getAttribute("value");
    
        // Réinitialise toutes les étoiles
        labelStars.forEach((s) => s.classList.remove("checked"));
    
        // Marque les étoiles jusqu'à la note sélectionnée
        for (let i = 0; i < rating; i++) {
            labelStars[i].classList.add("checked");
            labelStars[i].classList.add(`star-${i + 1}`);
        }
        
      });
    });
})



