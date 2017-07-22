<textarea class="form-control richTextBox" name="{{ $name }}" id="richtext{{ $name }}">
    {{ old($name, $value ?: '') }}
</textarea>