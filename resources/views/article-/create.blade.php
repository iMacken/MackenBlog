@extends('app')

@section('content')
    <section class="container">
        <div class="row">
            <br>
            @include('partials.errors')
            <div class="panel panel-default">
                <div class="panel-heading">撰写文章</div>
                <div class="panel-body">
                    <form role="form" action="{{ route('article.store') }}" method="POST">
                        @include('article.form', ['submitBtnTxt'=>'提交'])
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
