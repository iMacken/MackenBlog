<select class="form-control select2" name="{{ $name }}[]" multiple>
    @if(isset($options))
        @foreach($options as $key => $label)
                <?php $selected = ''; ?>
            @if(is_array($value) && in_array($key, $value))
                <?php $selected = 'selected="selected"'; ?>
            @elseif(!is_null(old($name)) && in_array($key, old($name)))
                <?php $selected = 'selected="selected"'; ?>
            @endif
            <option value="{{ $key }}" {!! $selected !!}>
                {{ $label }}
            </option>
        @endforeach
    @endif
</select>