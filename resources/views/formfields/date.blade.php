<input type="date" class="form-control"
       name="{{ $name }}"
       placeholder="{{ $placeholder }}"
       value="@if(isset($value)){{ gmdate('Y-m-d', strtotime(old($name, $value))) }}@else{{old($field)}}@endif">
