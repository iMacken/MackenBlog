@extends('admin')

@section('content')

		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">登录</div>
				<div class="panel-body">

					@include('partials.errors')

					{{ Form::open(['url' => url('/register'), 'method' => 'POST', 'class' => 'form-horizontal']) }}

						<div class="form-group">
							{!!  Form::label('name', '用户名', ['class' => 'col-md-4']) !!}
							{!!  Form::text('name', null, ['class' => 'form-control col-md-6', 'value' => old('name')]) !!}
						</div>

						<div class="form-group">
							{!!  Form::label('email', '邮箱', ['class' => 'col-md-4']) !!}
							{!!  Form::email('email', null, ['class' => 'form-control col-md-6', 'value' => old('email')]) !!}
						</div>

						<div class="form-group">
							{!!  Form::label('password', '密码', ['class' => 'col-md-4']) !!}
							{!!  Form::password('password', ['class' => 'form-control col-md-6']) !!}
						</div>

						<div class="form-group">
							{!!  Form::label('password_confirmation', '确认密码', ['class' => 'col-md-4']) !!}
							{!!  Form::password('password_confirmation', ['class' => 'form-control col-md-6']) !!}
						</div>

						<div class="form-group">
								<div class="col-md-6 col-md-offset-3">
								{!!  Form::submit('提交', ['class' => 'btn btn-primary form-control']) !!}
								<a class="btn btn-link pull-right" href="{{ route('login') }}">直接登录</a>
								</div>

						</div>
						{{ Form::close() }}
				</div>
			</div>
		</div>
@endsection
