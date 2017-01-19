@if (count($errors) > 0)
	<div class="alert alert-warning">
		<strong>哎呀!</strong> 出错啦.<br><br>
		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif