@extends('app')

@section('content')
    <section class="container">
        <div class="row">
            <br>
            @include('partials.errors')
            <div class="panel panel-default">
                <div class="panel-heading">修改分类</div>

                <div class="panel-body">
                    <form role="form" action="{{ route('category.update',$category->id) }}" method="POST">
                        {{ method_field('patch') }}
                        @include('category.form', ['submitBtnTxt'=>'更新'])
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection