@php $selected_value = (isset($value) && !is_null(old($name, $value))) ? old($name, $value) : old($name) @endphp
<select class="form-control select2" name="{{ $name }}">
    @php $default = $default ?: NULL @endphp
    @if(isset($options))
        @foreach($options as $key => $option)
            <option value="{{ $key }}" @if($default == $key && $selected_value === NULL){{ 'selected="selected"' }}@endif @if($selected_value == $key){{ 'selected="selected"' }}@endif>{{ $option }}</option>
        @endforeach
    @endif
</select>

