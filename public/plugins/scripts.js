jQuery(document).ready(function($) {  
    //geopattern
    $('.geopattern').each(function(){
        $(this).geopattern($(this).data('pattern-id'));
    });

    $('.navbar-form').submit(function (event) {
        event.preventDefault();
        var keyword = $('#search-keyword').val();
        if ($.trim(keyword) == '') {
            return false;
        }

        var host = $('.navbar-form').attr('action');
        window.location.href = host + '/' + keyword;
    });

    $('.share-bar').share();

    $('#to-top').click(function(){
        $('html, body').animate({scrollTop:0}, 'slow');
    });
});