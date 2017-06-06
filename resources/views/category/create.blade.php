@extends('app')

@section('content')
    <section class="container">
        <div class="row">
            <br>
            @include('partials.errors')
            <div class="panel panel-default">
                <div class="panel-heading">创建分类</div>
                <div class="panel-body">
                    <form role="form" action="{{ route('category.store') }}" method="POST">
                        @include('category.form', ['submitBtnTxt'=>'提交'])
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
