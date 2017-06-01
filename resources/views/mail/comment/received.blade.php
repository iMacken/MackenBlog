@component('mail::message')
# 收到新的{{ $type }}评论

 Hello, {{ $notifiable->name }}

您发布的1 {{ $type }} : {{ $comment->commentable->title }}, 收到了一条来自 {{ $comment->user->name }} 的评论。

@component('mail::button', ['url' => $url])
 点击查看
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
