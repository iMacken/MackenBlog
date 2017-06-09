@extends('app')

@section('content')
    <section class="container">
        <div class="row">
            <br>
            @include('partials.errors')
            <div class="panel panel-default">
                <div class="panel-heading">创建单页</div>
                <div class="panel-body">
                    <form role="form" action="{{ route('page.store') }}" method="POST">
                        @include('page.form', ['submitBtnTxt'=>'提交'])
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
