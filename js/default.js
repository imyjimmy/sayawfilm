$(document).ready(function() {
    console.log("here");
    $('.popup-vimeo').click(function() { 
//        api.playToggle();
        console.log('api.playToggle: paused');
    });

//<button title="Close (Esc)" type="button" class="mfp-close">×</button>
    // $('.mfp-close').click(function() {
    //     api.playToggle();
    //     console.log('api.playToggle(): unpaused');
    // });

    $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
        disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
    });
});