<?php $selected_value = (isset($value) && !empty(old($name, $value))) ? old($name, $value) : old($name); ?>
@php $default = $default ?: NULL @endphp
<ul class="radio">
    @if(isset($options))
        @foreach($options as $key => $option)
            <li>
                <input type="radio" id="option-{{ $key }}"
                       name="{{ $name }}"
                       value="{{ $key }}" @if($default == $key && $selected_value === NULL){{ 'checked' }}@endif @if($selected_value == $key){{ 'checked' }}@endif>
                <label for="option-{{ $key }}">{{ $option }}</label>
                <div class="check"></div>
            </li>
        @endforeach
    @endif
</ul>