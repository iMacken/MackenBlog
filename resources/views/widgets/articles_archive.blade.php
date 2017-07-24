<section id="archives" class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title">归档</div>
    </div>
    <ul class="list-group" >
        @if(!empty($archiveList))
            @foreach($archiveList as $v)
                <a href="{{ route('post-archive-list', sscanf($v->archive, "%d %d")) }}">
                    <li class="list-group-item">
                        <span class="badge">{{ $v->count }}</span>
                        <span>
                            {{ vsprintf("%s年  %s月", sscanf($v->archive, "%s %s")) }}
                        </span>
                    </li>
                </a>
            @endforeach
        @endif
    </ul>
</section>