document.addEventListener('DOMContentLoaded', () => {
    const closeForTheDay = document.getElementById('Schedule_close')
    const closeAtLunchTime = document.getElementById('Schedule_closedAtLunchtime')
    const closeAtLunchTimeDiv = document.querySelector('.close-at-lunch-time')
    const fieldTimeList = document.querySelectorAll('.field-time')
    const afternoonDivList = document.querySelectorAll('.afternoon-button')
    const afternoonButtonList = document.querySelectorAll('.afternoon-button input')
    const openingMorningLabel = document.querySelector('.opening-morning-div > label')
    const closingMorningLabel = document.querySelector('.closing-morning-div > label')
    const inputsShedules = document.querySelectorAll('.field-time input')

    const updateShedulesDisplay = () => {
        if (closeForTheDay.checked) {
            closeAtLunchTimeDiv.style.display = 'none';
            fieldTimeList.forEach(fieldTime => {
                fieldTime.style.display = 'none';
            });
        }
        if (!closeAtLunchTime.checked) {
            afternoonDivList.forEach(afternoonDiv => {
                afternoonDiv.style.display = 'none';
            })
            openingMorningLabel.innerHTML = "Ouverture";
            closingMorningLabel.innerHTML = "Fermeture";
        }
    }

    // Fonction pour mettre à jour le style d'affichage de close-at-lunch-time
    const updateCloseAtLunchTime = () => {
        // Vérifie si closeForTheDay est coché ou non
        if (closeForTheDay.checked) {
            // Si coché, masque close-at-lunch-time et field-time
            closeAtLunchTimeDiv.style.display = 'none';
            fieldTimeList.forEach(fieldTime => {
                fieldTime.style.display = 'none';
            });
            inputsShedules.forEach(input => {
                input.value = "00:00";
            })
        } else {
            // Sinon, affiche close-at-lunch-time et field-time
            closeAtLunchTimeDiv.style.display = 'block';
            fieldTimeList.forEach(fieldTime => {
                fieldTime.style.display = 'block';
            });
            if (!closeAtLunchTime.checked) {
                afternoonDivList.forEach(afternoonDiv => {
                    afternoonDiv.style.display = 'none';
                })
                openingMorningLabel.innerHTML = "Ouverture";
                closingMorningLabel.innerHTML = "Fermeture";
            }
        }
    };

    const updateAfternoonButton = () => {
        if (closeAtLunchTime.checked) {
            afternoonDivList.forEach(afternoonDiv => {
                afternoonDiv.style.display = 'block';
            })
            inputsShedules.forEach(input => {
                input.value = "00:00";
            })
            openingMorningLabel.innerHTML = "Ouverture du matin";
            closingMorningLabel.innerHTML = "Fermeture du matin";
        } else {
            afternoonDivList.forEach(afternoonDiv => {
                afternoonDiv.style.display = 'none';
            })
            afternoonButtonList.forEach(afternoonButton => {
                afternoonButton.value = "00:00";
            })
            openingMorningLabel.innerHTML = "Ouverture";
            closingMorningLabel.innerHTML = "Fermeture";
        }
    }

    updateShedulesDisplay()

    // Écouteur d'événement pour le changement d'état de close-schedules
    closeForTheDay.addEventListener('change', () => {
        // Met à jour le style d'affichage de close-at-lunch-time
        updateCloseAtLunchTime();
    });

    // Écouteur d'événement pour le clic sur le bouton close-schedules
    closeForTheDay.addEventListener('click', () => {
        // Met à jour le style d'affichage de close-at-lunch-time
        updateCloseAtLunchTime();
    });

    closeAtLunchTime.addEventListener('change', () => {
        updateAfternoonButton();
    });

    closeAtLunchTime.addEventListener('click', () => {
        updateAfternoonButton();
    });

});
