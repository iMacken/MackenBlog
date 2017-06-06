<?php

namespace App\Notifications;

use App\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;

class CommentReceived extends Notification implements ShouldQueue
{
    use Queueable;

    protected $comment;

	/**
	 * Create a new notification instance.
	 *
	 * @param Comment $comment
	 * @return void
	 */
	public function __construct(Comment $comment)
	{
		$this->comment = $comment;
	}

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
	    $comment = $this->comment;
	    $type = $comment->commentable_type;
	    $url = route('article.show', ['slug'=>$comment->commentable->slug]) . '#comment' . $comment->commentable->id;

	    return (new MailMessage)->markdown('mail.comment.received', compact('notifiable', 'type', 'comment', 'url'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return $this->comment->toArray();
    }
}
