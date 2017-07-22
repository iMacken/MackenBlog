<input type="datetime" class="form-control datepicker" name="{{ $name }}"
       value="@if(isset($value)){{ gmdate('m/d/Y g:i A', strtotime(old($name, $value)))  }}@else{{old($name)}}@endif">
