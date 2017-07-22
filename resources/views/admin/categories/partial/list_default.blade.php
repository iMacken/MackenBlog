<ol class="dd-list">

@foreach ($categories->sortBy('order') as $category)

    <li class="dd-item" data-id="{{ $category->id }}">
        <div class="pull-right item_actions">
            <div class="btn-sm btn-danger pull-right delete" data-id="{{ $category->id }}">
                <i class="voyager-trash"></i> @lang('Delete')
            </div>
            <div class="btn-sm btn-primary pull-right edit" data-id="{{ $category->id }}" data-name="{{ $category->name }}" data-slug="{{ $category->slug }}">
                <i class="voyager-edit"></i> @lang('Edit')
            </div>
        </div>
        <div class="dd-handle">
            @if($isModelTranslatable)
                @include('admin.multilingual.input-hidden', [
                    'isModelTranslatable' => true,
                    '_field_name'         => 'name'.$category->id,
                    '_field_trans'        => htmlspecialchars(json_encode($category->getTranslationsOf('name')))
                ])
            @endif
            <span>{{ $category->name }}</span>
        </div>
        @if(!$category->children->isEmpty())
            @include('admin.categories.partial.list_default', ['categories' => $category->children])
        @endif
    </li>

@endforeach

</ol>
