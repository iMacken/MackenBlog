(function ($) {
    var Blog = {
        init: function () {
            this.bootUp();
        },
        bootUp: function () {
            loadComments(false, false);
            initComment();
            // initMarkdownTarget();
            // initTables();
            // autoSize();
            initDeleteTarget();
            // highLightCode();
            // imageLiquid();
        },
    };

    function initDeleteTarget() {
        if ($('.op-delete').length && !$('#form-delete').length) {
            $('body').append(function() {
                return '\\n<form action="" method="POST" id="form-delete">' +
                    '\\n' + "{{ csrf_field() }}{{ method_field('delete') }}" +
                    '\\n</form>';
            });
        }

        $(document).on('click', '.op-delete', function(event){
            event.preventDefault();
            var action = $(this).attr('data-target');
            swal({
                title: "",
                text: '确认删除?',
                type: "info",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确定",
                cancelButtonText: "取消",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function() {
                $('#form-delete').attr('action', action).submit();
            });
        })
    }

    function loadComments(shouldMoveEnd, force) {
        var container = $('#comments-container');
        if (force || container.children().length <= 0) {
            console.log("loading comments");
            $.ajax({
                method: 'get',
                url: container.data('api-url'),
            }).done(function (data) {
                container.html(data);
                initDeleteTarget();
                highLightCodeOfChild(container);
                if (shouldMoveEnd) {
                    moveEnd($('#comment-submit'));
                }
            });
        }
    }

    function initComment() {
        var form = $('#comment-form');
        var submitBtn = form.find('#comment-submit');
        var commentContent = form.find('#comment-content');

        var username = form.find('input[name=username]');
        var email = form.find('input[name=email]');
        var site = form.find('input[name=site]');

        if (window.localStorage) {
            username.val(localStorage.getItem('comment_username') == undefined ? '' : localStorage.getItem('comment_username'));
            email.val(localStorage.getItem('comment_email') == undefined ? '' : localStorage.getItem('comment_email'));
            site.val(localStorage.getItem('comment_site') == undefined ? '' : localStorage.getItem('comment_site'));
        }

        form.on('submit', function () {
            if (username.length > 0) {
                if ($.trim(username.val()) == '') {
                    username.focus();
                    return false;
                }
                else if ($.trim(email.val()) == '') {
                    email.focus();
                    return false;
                }
            }

            if ($.trim(commentContent.val()) == '') {
                commentContent.focus();
                return false;
            }

            var usernameValue = username.val();
            var emailValue = email.val();
            var siteValue = site.val();

            submitBtn.val('提交中...').addClass('disabled').prop('disabled', true);
            $.ajax({
                method: 'post',
                url: $(this).attr('action'),
                headers: {
                    'X-CSRF-TOKEN': BlogConfig.csrfToken
                },
                data: {
                    commentable_id: form.find('input[name=commentable_id]').val(),
                    commentable_type: form.find('input[name=commentable_type]').val(),
                    content: commentContent.val(),
                    username: usernameValue,
                    email: emailValue,
                    site: siteValue,
                },
            }).done(function (data) {
                if (data.status === 200) {
                    if (window.localStorage) {
                        localStorage.setItem('comment_username', usernameValue);
                        localStorage.setItem('comment_email', emailValue);
                        localStorage.setItem('comment_site', siteValue);
                    }
                    username.val('');
                    email.val('');
                    site.val('');
                    commentContent.val('');
                    form.find('#comment_error_msg').text('');
                    loadComments(true, true);
                } else {
                    form.find('#comment_error_msg').text(data.msg);
                }
            }).always(function () {
                submitBtn.val("回复").removeClass('disabled').prop('disabled', false);
            });
            return false;
        });
    }

    function initMarkdownTarget() {
        $('.markdown-target').each(function (i, element) {
            element.innerHTML =
                marked($(element).data("markdown"), {
                    renderer: new marked.Renderer(),
                    gfm: true,
                    tables: true,
                    breaks: false,
                    pedantic: false,
                    smartLists: true,
                    smartypants: false,
                });
        });
    }

    function highLightCode() {
        $('pre code').each(function (i, block) {
            hljs.highlightBlock(block);
        });
    }

    function highLightCodeOfChild(parent) {
        $('pre code', parent).each(function (i, block) {
            console.log(block);
            hljs.highlightBlock(block);
        });
    }

    function initTables() {
        $('table').addClass('table table-bordered table-responsive');
    }

    function autoSize() {
        autosize($('.autosize-target'));
    }

    function imageLiquid() {
        $(".js-imgLiquid").imgLiquid({
            fill: true,
            horizontalAlign: "center",
            verticalAlign: "top"
        });
    }

    window.Blog = Blog;
})(jQuery);
$(document).ready(function () {
    Blog.init();
});

function replySomeone(username) {
    var commentContent = $("#comment-content");
    var oldContent = commentContent.val();
    prefix = "@" + username + " ";
    var newContent = '';
    if (oldContent.length > 0) {
        newContent = oldContent + "\n" + prefix;
    } else {
        newContent = prefix
    }
    commentContent.focus();
    commentContent.val(newContent);
    moveEnd(commentContent);
}

function moveEnd(obj) {
    obj.focus();
    var len = obj.value === undefined ? 0 : obj.value.length;

    if (document.selection) {
        var sel = obj.createTextRange();
        sel.moveStart('character', len);
        sel.collapse();
        sel.select();
    } else if (typeof obj.selectionStart == 'number' && typeof obj.selectionEnd == 'number') {
        obj.selectionStart = obj.selectionEnd = len;
    }
};