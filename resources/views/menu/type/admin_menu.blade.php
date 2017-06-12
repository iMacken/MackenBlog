<ul class="nav navbar-nav">

@foreach ($items->sortBy('order') as $item)
    
    @php
        
        $listItemClass = [];
        $styles = null;
        $linkAttributes = null;

        if(url($item->link()) == url()->current())
        {
            array_push($listItemClass,'active');
        }

        // With Children Attributes
        if(!$item->children->isEmpty())
        {
            foreach($item->children as $children)
            {
                if(url($children->link()) == url()->current())
                {
                    array_push($listItemClass,'active');
                }
            }
            $linkAttributes =  'href="#' . str_slug($item->title, '-') .'-dropdown-element" data-toggle="collapse" aria-expanded="'. (in_array('active', $listItemClass) ? 'true' : 'false').'"';
            array_push($listItemClass, 'dropdown');
        }
        else
        {
            $linkAttributes =  'href="' . url($item->link()) .'"';
        }
        
    @endphp

    <li class="{{ implode(" ", $listItemClass) }}">
        <a {!! $linkAttributes !!} target="{{ $item->target }}">
            <span class="icon {{ $item->icon_class }}"></span>
            <span class="title">@lang($item->title)</span>
        </a>
        @if(!$item->children->isEmpty())
        <div id="{{ str_slug($item->title, '-') }}-dropdown-element" class="panel-collapse collapse {{ (in_array('active', $listItemClass) ? 'in' : '') }}">
            <div class="panel-body">
                @include('menu.admin_menu', ['items' => $item->children, 'options' => $options, 'innerLoop' => true])
            </div>
        </div>
        @endif
    </li>
@endforeach

</ul>
