(function($){

    var MackenBlog = {

        //use pjax to load blog
        init: function() {

            var self = this

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })

            $.pjax.defaults.timeout = 2200

            $(document).pjax('[data-pjax] a, a[data-pjax]', '#pjax-container')

            $(document).on('submit', 'form[data-pjax]', function(event) {
                $.pjax.submit(event, '#pjax-container')
            })

            $(document).on('pjax:start', function() {
                NProgress.start()
            })

            $(document).on('pjax:end', function() {
                NProgress.done()
                self.blogBootUp()
            })

            self.blogBootUp()
        },

        /*
        * Things to be execute when normal page load
        * and pjax page load.
        */
        blogBootUp: function() {
            //geopattern
            $('.geopattern').each(function(){
                $(this).geopattern($(this).data('pattern-id'))
            })

            //search
            $('.navbar-form').submit(function (event) {
                event.preventDefault()
                var keyword = $('#search-keyword').val()
                if ($.trim(keyword) == '') {
                    return false
                }

                var host = $('.navbar-form').attr('action')
                window.location.href = host + '/' + keyword
            })

            //share bar
            $('.share-bar').share()

            //back to top
            $('#to-top').click(function(){
                $('html, body').animate({scrollTop:0}, 'slow')
            })

            //hightlight code
            Prism.highlightAll()
        }
    }

    window.MackenBlog = MackenBlog

})(jQuery)

$(document).ready(function()
{
    MackenBlog.init()
})
