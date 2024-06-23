jQuery(document).ready(function($) {
    // Gestion de la modal "Contact"
    var modal = $('#myModal');
    var menuContactLink = $('#menu-item-38 a');
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
        console.log('Lien cliqué : ' + permalink); // Log pour vérifier le lien
        window.location.href = permalink;
    });
// HOVER du filtre 
document.addEventListener('DOMContentLoaded', function() {
    const selectElements = document.querySelectorAll('.filters .filter select');

    selectElements.forEach(select => {
        select.addEventListener('mouseover', function(event) {
            const options = select.options;
            for (let i = 0; i < options.length; i++) {
                options[i].addEventListener('mouseover', function() {
                    options[i].style.backgroundColor = '#E00000';
                    options[i].style.color = 'white';
                });
                options[i].addEventListener('mouseout', function() {
                    options[i].style.backgroundColor = '';
                    options[i].style.color = '';
                });
            }
        });
    });
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

//menu burger 
document.addEventListener('DOMContentLoaded', function() {
    const burgerButton = document.querySelector('#modal__burger');
    const modalContent = document.querySelector('#modal__content');
    const closeButton = document.querySelector('#close__modal img');
    const links = document.querySelectorAll('#modal__content a');

    if (burgerButton && modalContent) {
        burgerButton.addEventListener('click', function() {
            console.log('Burger button clicked');
            modalContent.classList.toggle('animate-modal');
            burgerButton.classList.toggle('close');
        });

        if (closeButton) {
            closeButton.addEventListener('click', function() {
                console.log('Close button clicked');
                modalContent.classList.remove('animate-modal');
                burgerButton.classList.remove('close');
            });
        }

        links.forEach((link) => {
            link.addEventListener('click', function() {
                console.log('Menu link clicked');
                modalContent.classList.remove('animate-modal');
                burgerButton.classList.remove('close');
            });
        });
    }
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
