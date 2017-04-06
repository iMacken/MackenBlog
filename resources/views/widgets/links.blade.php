@if(!empty($linkList))
    <section id="links" class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title">友链</div>
        </div>
        <ul>
            @foreach($links as $link)
                <li>
                    <a href="{{ $link->url }}" target="_blank" >
                        {{ $link->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </section>
@endif