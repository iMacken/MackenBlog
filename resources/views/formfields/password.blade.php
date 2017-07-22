@if(isset($value))
    <br>
    <small>@lang('password_leave_empty')</small>
@endif
<input type="password" class="form-control" name="{{ $name }}" value="">