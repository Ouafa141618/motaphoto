document.addEventListener('DOMContentLoaded', function() {
          var modal = document.getElementById("myModal");
          var btn = document.getElementById("contact_btn");
          var span = document.getElementsByClassName("close")[0];
      
          btn.onclick = function() {
              modal.style.display = "block";
          }
      
          span.onclick = function() {
              modal.style.display = "none";
          }
      
          window.onclick = function(event) {
              if (event.target == modal) {
                  modal.style.display = "none";
              }
          }
      });
      
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
    