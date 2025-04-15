// Sélectionner tous les boutons de type d'utilisateur
const userTypeButtons = document.querySelectorAll('.user-type-btn');

// Ajouter des écouteurs d'événements pour chaque bouton
userTypeButtons.forEach(button => {
  button.addEventListener('click', () => {
    const userType = button.dataset.form;
    window.location.href = `../html/${userType}.html`;
  });
});

