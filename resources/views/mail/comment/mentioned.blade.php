@component('mail::message')
# 收到新的{{ $type }}评论提及

 Hello, {{ $notifiable->name }}

您针对{{ $type }} : {{ $comment->commentable->title }} 发表的评论, 收到了一条来自 {{ $comment->user->name }} 的评论提及。
@component('mail::button', ['url' => $url])
 点击查看
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
