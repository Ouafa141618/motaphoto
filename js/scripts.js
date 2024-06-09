jQuery(document).ready(function($) {
    var modal = $('#contactModal');
    var btn = $('#contact_btn');
    var span = $('.close');

    btn.on('click', function() {
        var photoRef = $(this).data('reference');
        modal.find('input[name="photo_ref"]').val(photoRef);
        modal.show(); // Affiche la modale
    });

    span.on('click', function() {
        modal.hide(); // Masque la modale
    });

    $(window).on('click', function(event) {
        if ($(event.target).is(modal)) {
            modal.hide(); // Masque la modale si on clique en dehors
        }
    });
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


    