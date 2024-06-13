jQuery(document).ready(function($) {
    // Gestion de la modal "Contact"
    var modal = $('#myModal');
    var contactLink = $('#menu-item-89 a');
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

    // Ouverture des informations de la photo
    $(document).on('click', '.detail-photo', function(event) {
        event.preventDefault();
        var photoId = $(this).closest('.photo1').data('photo-id');
        window.location.href = '/photo/' + photoId; // Rediriger vers la page de détails de la photo
    });

    // Pré-remplissage du formulaire de contact
    $('#contact_btn').on('click', function() {
        var refPhoto = $(this).data('reference');
        $('#myModal #ref_photo').val(refPhoto);
        $('#myModal').fadeIn();
    });

    // Fermer la modal de contact
    $('.close').on('click', function() {
        $(this).parents('.modal').fadeOut();
    });

    $(window).on('click', function(event) {
        if ($(event.target).is('#myModal')) {
            $(event.target).fadeOut();
        }
    });

    // Navigation entre les photos avec prévisualisation
    $('.photo-nav-link').hover(function() {
        var thumbSrc = $(this).data('thumb');
        $(this).append('<div class="photo-nav-thumb"><img src="' + thumbSrc + '" alt=""></div>');
    }, function() {
        $('.photo-nav-thumb').remove();
    });
});
