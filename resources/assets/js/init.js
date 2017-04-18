(function ($) {
    var Blog = {
            init: function () {
                var self = this;
                self.bootUp();
            },
            bootUp: function () {
                var self = this;
                self.initCommentList(false, false);
                self.initCommentBox();
                self.initMarkdownPreview();
                self.initTextareaAutoResize();
                self.initDeleteTarget();
                self.initHighLightCode();
                self.initGeoPattern();
            },


            initDeleteTarget: function () {
                var self = this;
                $('.swal-dialog-target').append(function () {
                    return "\n" +
                        "<form action='" + $(this).attr('data-url') + "' method='POST' style='display:none'>\n" +
                        "   <input type='hidden' name='_method' value='" + ($(this).data('method') ? $(this).data('method') : 'delete') + "'>\n" +
                        "   <input type='hidden' name='_token' value='" + BlogConfig.csrfToken + "'>\n" +
                        "</form>\n"
                }).click(function () {
                    var deleteForm = $(this).find("form");
                    var method = ($(this).data('method') ? $(this).data('method') : 'delete');
                    var url = $(this).attr('data-url');
                    var data = $(this).data('request-data') ? $(this).data('request-data') : '';
                    var title = $(this).data('dialog-title') ? $(this).data('dialog-title') : '';
                    var message = $(this).data('dialog-msg');
                    var type = $(this).data('dialog-type') ? $(this).data('dialog-type') : 'warning';
                    var cancel_text = $(this).data('dialog-cancel-text') ? $(this).data('dialog-cancel-text') : '取消';
                    var confirm_text = $(this).data('dialog-confirm-text') ? $(this).data('dialog-confirm-text') : '确定';
                    var enable_html = $(this).data('dialog-enable-html') == '1';
                    var enable_ajax = $(this).data('enable-ajax') == '1';
                    console.log(data);
                    if (enable_ajax) {
                        swal({
                                title: title,
                                text: message,
                                type: type,
                                html: enable_html,
                                showCancelButton: true,
                                confirmButtonColor: "#DD6B55",
                                cancelButtonText: cancel_text,
                                confirmButtonText: confirm_text,
                                closeOnConfirm: false,
                                showLoaderOnConfirm: true
                            },
                            function () {
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': BlogConfig.csrfToken
                                    },
                                    url: url,
                                    type: method,
                                    data: data,
                                    success: function (res) {
                                        if (res.status == 200) {
                                            swal({
                                                title: 'Success',
                                                text: res.msg,
                                                type: "success",
                                                timer: 1000,
                                                confirmButtonText: "OK"
                                            });
                                            self.initCommentList(false, true);
                                        } else {
                                            swal({
                                                title: 'Fail',
                                                text: "操作失败",
                                                type: "error",
                                                timer: 1000,
                                                confirmButtonText: "OK"
                                            });
                                        }
                                    },
                                    error: function (res) {
                                        swal({
                                            title: 'Failed',
                                            text: "操作失败",
                                            type: "error",
                                            timer: 1000,
                                            confirmButtonText: "OK"
                                        });
                                    }
                                })
                            });
                    } else {
                        swal({
                                title: title,
                                text: message,
                                type: type,
                                html: enable_html,
                                showCancelButton: true,
                                confirmButtonColor: "#DD6B55",
                                cancelButtonText: cancel_text,
                                confirmButtonText: confirm_text,
                                closeOnConfirm: true
                            },
                            function () {
                                deleteForm.submit();
                            });
                    }
                });
            },

            initCommentList: function (shouldMoveEnd, force) {
                var self = this;
                var container = $('#comments-container');
                if (container && force || container.children().length <= 0) {
                    $.ajax({
                        method: 'get',
                        url: container.data('api-url'),
                    }).done(function (data) {
                        container.html(data);
                        self.initDeleteTarget();
                        self._highLightCodeOfChild(container);
                        if (shouldMoveEnd) {
                            self._moveEnd($('#comment-submit'));
                        }
                        $(document).on('click', '.reply-user-btn', function () {
                            self._replyUser($(this).data('username'));
                        })
                    });
                }
            },

            initCommentBox: function () {
                var self = this;
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

                    var usernameValue = username.val();
                    var emailValue = email.val();
                    var siteValue = site.val();

                    var errorAlert = $('<div id="comment-error-alert" class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><ul></ul></div>');

                    submitBtn.text('提交中...').addClass('disabled').prop('disabled', true);
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
                            errorAlert.find('ul').html('');
                            self.initCommentList(true, true);
                        } else {
                            errorAlert.remove();
                            var errorHtml = '<li>' + data.msg + '</li>';
                            submitBtn.before(errorAlert.find('ul').html(errorHtml));
                        }
                    }).fail(function (xhr) {
                        if (xhr.status === 422) {
                            var errors = $.parseJSON(xhr.responseText);
                            var errorsHtml = '';
                            $.each(errors, function (key, value) {
                                errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                            });
                            errorAlert.find('ul').html(errorsHtml);
                            errorAlert.remove();
                            submitBtn.before(errorAlert);
                        }
                    }).always(function () {
                        submitBtn.text("发表").removeClass('disabled').prop('disabled', false);
                    });
                    return false;
                });
            }
            ,

            initTextareaAutoResize: function () {
                autosize($('textarea'));
            }
            ,

            initMarkdownPreview: function () {
                var self = this;
                $("#comment-content").focus(function (event) {
                    $("#preview-box, #preview-lable").fadeIn(1500);
                });
                $('#comment-content').keyup(function () {
                    self._runPreview();
                });
            }
            ,

            _runPreview: function () {
                var replyContent = $("#comment_content");
                var oldContent = replyContent.val();

                if (oldContent) {
                    window.marked(oldContent, function (err, content) {
                        $('#preview-box').html(content);
                        window.emojify.run(document.getElementById('preview-box'));
                    });
                }
            }
            ,


            initHighLightCode: function () {
                $('pre code').each(function (i, block) {
                    hljs.highlightBlock(block);
                });
            }
            ,

            _highLightCodeOfChild: function (parent) {
                $('pre code', parent).each(function (i, block) {
                    hljs.highlightBlock(block);
                });
            }
            ,

            _replyUser: function (username) {
                var self = this;
                var commentContent = $("#comment-content");
                var oldContent = commentContent.val();
                var prefix = "@" + username + " ";
                var newContent = '';
                if (oldContent.length > 0) {
                    newContent = oldContent + "\n" + prefix;
                } else {
                    newContent = prefix
                }
                commentContent.focus();
                commentContent.val(newContent);
                self._moveEnd(commentContent);
            }
            ,

            _moveEnd: function (obj) {
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
            }
            ,

            initGeoPattern: function () {
                $('.geopattern').each(function () {
                    $(this).geopattern($(this).data('pattern-id'))
                });
            }
        }
        ;

    window.Blog = Blog;
})(jQuery);
$(document).ready(function () {
    Blog.init();
});

