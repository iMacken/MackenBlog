@extends('app')

@section('content')
    <section class="container">
        <div class="row">
            <br>
            @include('partials.errors')
            <div class="panel panel-default">
                <div class="panel-heading">创建友链</div>
                <div class="panel-body">
                    <form role="form" action="{{ route('link.store') }}" method="POST">
                        @include('link.form', ['submitBtnTxt'=>'提交'])
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
