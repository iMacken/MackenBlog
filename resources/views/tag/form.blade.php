{{ csrf_field() }}
<div class="form-group">
    <label for="name" class="control-label">标签名</label>
    <input type="text" name="name" id="name" class="form-control" value="{{ isset($tag) ? $tag->name : old('name') }}" autofocus>
</div>
<div class="form-group">
    <label for="slug" class="control-label">别名</label>
    <input type="text" name="slug" id="slug" class="form-control" value="{{ isset($tag) ? $tag->slug : old('slug') }}" autofocus>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-success form-control">{{ $submitBtnTxt }}</button>
</div>
            