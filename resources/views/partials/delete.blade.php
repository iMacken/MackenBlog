<form action="" method="POST" id="form-delete">
    {{ csrf_field() }}
    {{ method_field('delete') }}
</form>

<script type="text/javascript">
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
</script>
