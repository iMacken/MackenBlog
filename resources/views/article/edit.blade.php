@extends('app')

@section('content')
    <section class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">修改文章</div>

                @include('partials.errors')

                <div class="panel-body">
                    {!! Form::model($article, ['route' => ['article.update', $article->id], 'method' => 'PATCH','enctype'=>'multipart/form-data']) !!}

                    @include('article.form', ['submitBtnTxt'=>'更新'])
                        
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
