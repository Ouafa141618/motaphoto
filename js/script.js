jQuery(document).ready(function($) {
    // Gestion de la modal "Contact"
    var modal = $('#myModal');
    var contactLink = $('#menu-item-38');
    var span = $('.close');

    contactLink.click(function(event) {
        event.preventDefault(); // Empêcher le comportement par défaut du lien
        modal.fadeIn(); // Afficher la modal
    });

    span.click(function() {
        modal.fadeOut(); // Cacher la modal
    });

    $(window).click(function(event) {
        if ($(event.target).is(modal)) {
            modal.fadeOut(); // Cacher la modal
        }
    });

    // Fonction pour récupérer les photos avec les filtres
    function fetchPhotos() {
        var data = {
            'action': 'filter_photos',
            'category': $('#filter-category').val(),
            'format': $('#filter-format').val(),
            'sort': $('#filter-tri').val(),
        };

        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: data,
            success: function(response) {
                $('.gallery').html(response);
                page = 2; // Réinitialiser la page pour le chargement
                $('#load-more').show(); // Afficher le bouton "Charger plus"
            }
        });
    }

    $('#filter-category, #filter-format, #filter-tri').on('change', function() {
        fetchPhotos();
    });

    $('.detail-photo').on('click', function(event) {
        event.preventDefault();
        var permalink = $(this).attr('href');
        window.location.href = permalink;
    });

    // Logic for lightbox
    const lightbox = $('.lightbox');
    const lightboxClose = $('.lightbox-close');
    const lightboxNext = $('.lightbox-next');
    const lightboxPrev = $('.lightbox-prev');
    const lightboxContent = $('.lightbox-content img');
    const lightboxReference = $('.lightbox-reference');
    const lightboxCategory = $('.lightbox-category');

    function openLightbox(event) {
        event.preventDefault();
        const imgSrc = $(this).data('src');
        const imgRef = $(this).data('reference');
        const imgCategory = $(this).data('category');

        lightboxContent.attr('src', imgSrc);
        lightboxReference.text(imgRef);
        lightboxCategory.text(imgCategory);
        lightbox.addClass('lightbox-visible');
    }

    function closeLightbox() {
        lightbox.removeClass('lightbox-visible');
    }

    $('.openLightbox').on('click', openLightbox);
    lightboxClose.on('click', closeLightbox);

    // Logic for navigating between images in the lightbox can be added here

    // Gestion du bouton "Charger plus"
    var page = 2;
    $('#load-more').on('click', function() {
        var data = {
            'action': 'load_more',
            'page': page,
        };

        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: data,
            success: function(response) {
                if (response) {
                    $('.gallery').append(response);
                    page++;
                } else {
                    $('#load-more').text('Plus de photos');
                    $('#load-more').prop('disabled', true);
                }
            }
        });
    });

    console.log('Document is ready'); // Vérification initiale
});
