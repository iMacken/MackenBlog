{{ csrf_field() }}

<div class="form-group">
    <label for="name" class="control-label">用户名</label>
    <input type="text" name="name" id="name" class="form-control" value="{{ isset($user) ? $user->name : old('name') }}" autofocus>
</div>

<div class="form-group">
    <label for="email" class="control-label">邮箱</label>
    <input type="text" name="email" id="email" class="form-control" value="{{ isset($user) ? $user->email : old('email') }}" autofocus>
</div>

<div class="form-group">
    <label for="avatar" class="control-label">头像</label>
    <input type="file" name="avatar" id="avatar" class="form-control">
    <br>
    <div>
        @if(!empty($user->avatar))
            <img class="thumbnail" src="{{ asset($user->avatar) }}" width="300">
        @endif
    </div>
</div>

<div class="form-group">
    <label for="password" class="control-label">密码</label>
    <input type="password" name="password" id="password" class="form-control" autofocus>
    <span class="help-block">
        (必须同时包含字母和数字以及特殊符号!?~#$%^&-_+=,并且 8 位以上)
    </span>
</div>

<div class="form-group">
    <label for="password_confirmation" class="control-label">确认密码</label>
    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" autofocus>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-success form-control">{{ $submitBtnTxt }}</button>
</div>