(function($){

    var MackenBlog = {

        //use pjax to load blog
        init: function() {
            var self = this;

            $(document).pjax('a:not(a[target="_blank"])', 'body', {
                timeout: 1600,
                maxCacheLength: 500
            });
            $(document).on('pjax:start', function() {
                NProgress.start();
            });
            $(document).on('pjax:end', function() {
                NProgress.done();
                self.blogBootUp();
            });

            self.blogBootUp();
        },

        /*
        * Things to be execute when normal page load
        * and pjax page load.
        */
        blogBootUp: function() {
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
        }
    }

    window.MackenBlog = MackenBlog;

})(jQuery);

$(document).ready(function()
{
    MackenBlog.init();
});
