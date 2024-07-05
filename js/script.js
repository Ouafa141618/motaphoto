jQuery(document).ready(function($) {
    // Gestion de la modal "Contact"
    var modal = $('#myModal');
    var menuContactLink = $('#menu-item-62 a');
    var pageContactButton = $('#single_contact_btn');
    var span = $('.close');

    // Ouvrir la modal depuis le menu
    menuContactLink.on('click', function(event) {
        event.preventDefault(); // Empêcher le comportement par défaut du lien
        modal.fadeIn(); // Afficher la modal
    });

    // Ouvrir la modal depuis le bouton de contact sur la page individuelle
    pageContactButton.on('click', function(event) {
        event.preventDefault(); // Empêcher le comportement par défaut du lien
        var photoReference = $(this).data('reference'); // Récupérer la référence de la photo
        $('#myModal').find('input[name="your-photo-ref"]').val(photoReference); // Insérer la référence dans le champ du formulaire
        modal.fadeIn(); // Afficher la modal
    });

    span.on('click', function() {
        modal.fadeOut(); // Cacher la modal
    });

    $(window).on('click', function(event) {
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

    let currentImageIndex = 0;
    let images = [];

    function openLightbox(event) {
        event.preventDefault();
        const imgSrc = $(this).data('src');
        const imgRef = $(this).data('reference');
        const imgCategory = $(this).data('category');

        currentImageIndex = $(this).index('.openLightbox');
        lightboxContent.attr('src', imgSrc);
        lightboxReference.text(imgRef);
        lightboxCategory.text(imgCategory);
        lightbox.addClass('lightbox-visible');
    }

    function closeLightbox() {
        lightbox.removeClass('lightbox-visible');
    }

    function showImage(index) {
        if (index >= 0 && index < images.length) {
            currentImageIndex = index;
            const img = images[index];
            lightboxContent.attr('src', img.src);
            lightboxReference.text(img.ref);
            lightboxCategory.text(img.category);
        }
    }

    function showNextImage() {
        showImage((currentImageIndex + 1) % images.length);
    }

    function showPrevImage() {
        showImage((currentImageIndex - 1 + images.length) % images.length);
    }

    $('.openLightbox').each(function() {
        images.push({
            src: $(this).data('src'),
            ref: $(this).data('reference'),
            category: $(this).data('category')
        });
    });

    $('.openLightbox').on('click', openLightbox);
    lightboxClose.on('click', closeLightbox);
    lightboxNext.on('click', showNextImage);
    lightboxPrev.on('click', showPrevImage);

    // Afficher les miniatures au survol des flèches
    $('.nav-arrow').hover(function() {
        var thumbnail = $(this).closest('div').find('.prev-thumbnail, .next-thumbnail img');
        thumbnail.attr('src', $(this).data('image'));
        thumbnail.attr('alt', $(this).data('title'));
        $(this).closest('div').find('.prev-thumbnail, .next-thumbnail').show();
    }, function() {
        $(this).closest('div').find('.prev-thumbnail, .next-thumbnail').hide();
    });

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

    
jQuery(document).ready(function($) {
    function updateThumbnails() {
        var prevArrow = $('.photo_avant .nav-arrow');
        var nextArrow = $('.photo_apres .nav-arrow');

        if (prevArrow.length) {
            var prevThumbnail = $('.prev-thumbnail img');
            prevThumbnail.attr('src', prevArrow.data('image'));
            prevThumbnail.attr('alt', prevArrow.data('title'));
        }

        if (nextArrow.length) {
            var nextThumbnail = $('.next-thumbnail img');
            nextThumbnail.attr('src', nextArrow.data('image'));
            nextThumbnail.attr('alt', nextArrow.data('title'));
        }
    }

    // Initial thumbnail update
    updateThumbnails();

    // Infinite loop handling
    $('.photo_avant .nav-arrow').on('click', function(event) {
        event.preventDefault();
        var link = $(this).parent('a').attr('href');
        window.location.href = link;
    });

    $('.photo_apres .nav-arrow').on('click', function(event) {
        event.preventDefault();
        var link = $(this).parent('a').attr('href');
        window.location.href = link;
    });

    $('.photo_avant').hover(function() {
        $(this).find('.prev-thumbnail').show();
    }, function() {
        $(this).find('.prev-thumbnail').hide();
    });

    $('.photo_apres').hover(function() {
        $(this).find('.next-thumbnail').show();
    }, function() {
        $(this).find('.next-thumbnail').hide();
    });
});
jQuery(document).ready(function($) {
    // Gestion du menu burger en responsive
    $('#modal__burger').on('click', function() {
        $(this).toggleClass('close');
        $('#modal__content').toggleClass('animate-modal');
    });

    // Fermer le menu burger en cliquant en dehors du menu
    $(window).on('click', function(event) {
        if ($(event.target).is('#modal__content')) {
            $('#modal__burger').removeClass('close');
            $('#modal__content').removeClass('animate-modal');
        }
    });
});
