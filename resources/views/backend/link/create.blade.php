@extends('app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">创建友链</div>

        @if ($errors->has('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong>
            {{ $errors->first('error', ':message') }}
            <br />
            请联系开发者！
        </div>
        @endif

        <div class="panel-body">
            {!! Form::open(['route' => 'link.store', 'method' => 'POST']) !!}

            @include('link.form', ['submitBtnTxt'=>'完成'])

            {!! Form::close() !!}
        </div>
    </div>
@endsection
