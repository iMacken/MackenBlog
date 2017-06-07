{{ csrf_field() }}
<div class="form-group">
    <label for="name" class="control-label">友链名称</label>
    <input type="text" name="name" id="name" class="form-control" value="{{ isset($link) ? $link->name : old('name') }}" autofocus>
</div>
<div class="form-group">
    <label for="url" class="control-label">友链地址</label>
    <input type="text" name="url" id="url" class="form-control" value="{{ isset($link) ? $link->url : old('url') }}" autofocus>
</div>
<div class="form-group">
    <label for="sort" class="control-label">排序</label>
    <input type="text" name="sort" id="sort" class="form-control" value="{{ isset($link) ? $link->sort : old('sort') }}" autofocus>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-success form-control">{{ $submitBtnTxt }}</button>
</div>
            