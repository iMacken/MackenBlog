{{ csrf_field() }}
<div class="form-group">
    <label for="name" class="control-label">分类名</label>
    <input type="text" name="name" id="name" class="form-control" value="{{ isset($category) ? $category->name : old('name') }}" autofocus>
</div>
<div class="form-group">
    <label for="slug" class="control-label">别名</label>
    <input type="text" name="slug" id="slug" class="form-control" value="{{ isset($category) ? $category->slug : old('slug') }}" autofocus>
</div>
<div class="form-group">
    <label for="description" class="control-label">描述</label>
    <textarea type="text" name="description" id="description" class="form-control" autofocus>{!! isset($category) ? $category->description : old('description') !!}</textarea>
</div>
<div class="form-group">
    <label for="sort" class="control-label">排序</label>
    <input type="text" name="sort" id="sort" class="form-control" value="{{ isset($category) ? $category->sort : old('sort') }}" autofocus>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-success form-control">{{ $submitBtnTxt }}</button>
</div>