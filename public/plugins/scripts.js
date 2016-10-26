jQuery(document).ready(function($) {
    //geopattern
    $('.geopattern').each(function(){
        $(this).geopattern($(this).data('pattern-id'));
    });

    //search
    $('.navbar-form').submit(function (event) {
        event.preventDefault();
        var keyword = $('#search-keyword').val();
        if ($.trim(keyword) == '') {
            return false;
        }

        var host = $('.navbar-form').attr('action');
        window.location.href = host + '/' + keyword;
    });

    //share bar
    $('.share-bar').share();

    //back to top
    $('#to-top').click(function(){
        $('html, body').animate({scrollTop:0}, 'slow');
    });

    //PJAX
    // does current browser support PJAX
    if ($.support.pjax) {
        $.pjax.defaults.timeout = 2000; // time in milliseconds
    }
    $(document).pjax('a', 'body');
    $(document).on('pjax:start', function() {
        NProgress.start();
    });
    $(document).on('pjax:end', function() {
        NProgress.done();
    });
});