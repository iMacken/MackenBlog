<div class="form-group">
    {!! Form::label('parent_id', '上级分类') !!}
    {!! Form::select('parent_id', App\Models\Category::getCategoryTree() , null , ['class' => 'form-control']) !!}
    <font color="red">{{ $errors->first('parent_id') }}</font>
</div>

<div class="form-group">
    {!! Form::label('name', '分类名称') !!}
    {!! Form::text('name', null, ['class' => 'form-control','placeholder'=>'category_name']) !!}
    <font color="red">{{ $errors->first('cate_name') }}</font>
</div>

<div class="form-group">
    {!! Form::label('slug', '别名') !!}
    {!! Form::text('slug', null, ['class' => 'form-control','placeholder'=>'slug']) !!}
    <font color="red">{{ $errors->first('slug') }}</font>
</div>

<div class="form-group">
    {!! Form::label('seo_title', 'SEO 标题') !!}
    {!! Form::text('seo_title', null, ['class' => 'form-control','placeholder'=>'seo_title']) !!}
    <font color="red">{{ $errors->first('seo_title') }}</font>
</div>

<div class="form-group">
    {!! Form::label('seo_key', 'SEO 关键字') !!}
    {!! Form::text('seo_key', null, ['class' => 'form-control','placeholder'=>'seo_key']) !!}
    <font color="red">{{ $errors->first('seo_key') }}</font>
</div>

<div class="form-group">
    {!! Form::label('seo_key', 'SEO 描述') !!}
    {!! Form::textarea('seo_desc', null, ['class' => 'form-control','placeholder'=>'seo_desc']) !!}
    <font color="red">{{ $errors->first('seo_desc') }}</font>
</div>

<div class="form-group">
    {!! Form::submit($submitBtnTxt, ['class' => 'btn btn-success col-md-12']) !!}
</div>  