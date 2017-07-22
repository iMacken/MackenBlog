<br>
@php $checked = false; @endphp
@if(isset($name) || old($name))
    @php $checked = old($name, $value); @endphp
@endif
<input type="checkbox" name="{{ $name }}" class="toggleswitch" @if($checked) checked @endif>

