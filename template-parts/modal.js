jQuery(document).ready(function($) {
    // Ouvrir la modale de contact
    $('#contact-modal-open').click(function() {
        $('#contact-modal').show();
    });

    // Fermer la modale de contact
    $('.close').click(function() {
        $('#contact-modal').hide();
    });

    // Fermer la modale si l'utilisateur clique en dehors de celle-ci
    $(window).click(function(event) {
        if (event.target.id === 'contact-modal') {
            $('#contact-modal').hide();
        }
    });
});
