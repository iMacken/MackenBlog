<div class="modal fade" id="forward-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">转发简历</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group has-feedback">
                        <label for="recipient-name" class="control-label">收件人:</label>
                        <div class="row">
                            <div class="col-sm-11 form-inline">
                                <input class="form-control" style="width:25%" type="text" placeholder="收件人姓名" name="recipient_name" class="form-control"> <input type="email" placeholder="邮箱地址" name="emails[]" class="form-control" style="width:73%">
                            </div>
                            <div class="col-sm-1"><i class="voyager-plus text-success" style="font-size:2em;margin-left:-0.5em;cursor:pointer"></i></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" id="forward-btn" data-loading-text="发送中...">确定
                </button>
            </div>
        </div>
    </div>
</div>

<div id="email-item" style="display:none">
    <div class="email-option row">
        <div class="col-sm-11 form-inline">
            <label style="width:25%;text-align: center">CC</label> <input type="email" placeholder="邮箱地址" name="emails[]" class="form-control" style="width:73%">
        </div>
        <div class="col-sm-1"><i class="voyager-x text-danger" style="font-size:2em;margin-left:-0.5em;cursor:pointer"></i></div>
    </div>
</div>

<script>
    $(function() {

        $('#forward-modal').on('click', '.voyager-plus', function () {
            var $emailItem = $('#email-item').clone(true).html();
            $(this).closest('.form-group').append($emailItem);
        }).on('click', '.voyager-x', function () {
            $(this).closest('.row').remove();
        });

        $('.forward').click(function() {
            var id = $(this).data('id');

            $('#forward-modal').modal('show').on('click', '#forward-btn', function () {
                var $sendBtn = $('#forward-btn');
                $sendBtn.button('loading');
                var emails = [];
                $('input[name="emails[]"]').each(function (i) {
                    emails[i] = $(this).val();
                });
                emails = $.grep(emails, function(val) {
                    return !!val;
                });
                var recipientName = $('input[name="recipient_name"]').val();
                
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.position-applications.update', ['id' => '']) }}/" + id,
                    type: 'PUT',
                    data: {id: id, status: 'Forwarded', emails: emails, recipient_name: recipientName},
                    dataType: 'json',
                    success: function () {
                        toastr.success('转发成功！');
                    },
                    error: function (data) {
                        var errors = data.responseJSON;

                        $.each(errors, function (index, value) {
                            toastr.error(value[0]);
                        });
                    },
                    complete: function () {
                        $('#forward-modal').modal('hide');
                        $sendBtn.button('reset');
                    }
                });
            })
        });
    });
</script>
