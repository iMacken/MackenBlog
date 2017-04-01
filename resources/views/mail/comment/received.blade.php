@component('mail::message')
# 收到新的{{ $type }}评论

 Hello, {{ $notifiable->name }}

@component('mail::button', ['url' => {{ $url }}])
 您发布的 {{ $type }} : {{ $comment->commentable->title }}, 收到了一条来自 {{ $comment->user->name }} 的评论。
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
