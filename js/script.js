jQuery(document).ready(function($) {
    // Récupérer la modal
    var modal = $('#myModal');
    // Récupérer le lien "Contact" dans le menu
    var contactLink = $('#menu-item-89 a');
    // Récupérer le bouton de fermeture
    var span = $('.close');

    // Afficher la modal lorsque le lien "Contact" est cliqué
    contactLink.click(function(event) {
        event.preventDefault(); // Empêcher le comportement par défaut du lien
        modal.fadeIn(); // Afficher la modal
    });

    // Fermer la modal lorsque l'utilisateur clique sur le bouton de fermeture
    span.click(function() {
        modal.fadeOut(); // Cacher la modal
    });

    // Fermer la modal lorsque l'utilisateur clique en dehors de la modal
    $(window).click(function(event) {
        if ($(event.target).is(modal)) {
            modal.fadeOut(); // Cacher la modal
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    let loadMoreButton = document.getElementById('load-more');
    let photos = document.querySelector

      
      document.addEventListener('DOMContentLoaded', function() {
          let loadMoreButton = document.getElementById('load-more');
          let photos = document.querySelectorAll('.gallery .photo1');
          let photosToShow = 4; // Nombre initial de photos à afficher
          let currentPhotoIndex = 0;
      
          // Fonction pour afficher les photos
          function showPhotos() {
              for (let i = currentPhotoIndex; i < currentPhotoIndex + photosToShow; i++) {
                  if (photos[i]) {
                      photos[i].style.display = 'flex';
                  }
              }
              currentPhotoIndex += photosToShow;
              // Si toutes les photos sont affichées, cacher le bouton
              if (currentPhotoIndex >= photos.length) {
                  loadMoreButton.style.display = 'none';
              }
          }
      
          // Initialiser l'affichage des photos
          photos.forEach(photo => photo.style.display = 'none');
          showPhotos();
      
          // Ajouter un événement au bouton pour charger plus de photos
          loadMoreButton.addEventListener('click', showPhotos);
      });
    });