<ol class="dd-list">

@foreach ($departments->sortBy('order') as $department)

    <li class="dd-item" data-id="{{ $department->id }}">
        <div class="pull-right item_actions">
            <div class="btn-sm btn-danger pull-right delete" data-id="{{ $department->id }}">
                <i class="voyager-trash"></i> @lang('Delete')
            </div>
            <div class="btn-sm btn-primary pull-right edit" data-id="{{ $department->id }}" data-name="{{ $department->name }}" data-slug="{{ $department->slug }}">
                <i class="voyager-edit"></i> @lang('Edit')
            </div>
        </div>
        <div class="dd-handle">
            @if($isModelTranslatable)
                @include('admin.multilingual.input-hidden', [
                    'isModelTranslatable' => true,
                    '_field_name'         => 'name'.$department->id,
                    '_field_trans'        => htmlspecialchars(json_encode($department->getTranslationsOf('name')))
                ])
            @endif
            <span>{{ $department->name }}</span>
        </div>
        @if(!$department->children->isEmpty())
            @include('admin.departments.partial.list_default', ['departments' => $department->children])
        @endif
    </li>

@endforeach

</ol>
