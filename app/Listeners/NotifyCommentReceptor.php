<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use App\Notifications\NewCommentNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyCommentReceptor
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CommentCreated $event)
    {
        $commentReceptor = $event->comment->receptorUser;

        // Verifica si el receptor existe
        if ($commentReceptor) {
            $commentReceptor->notify(new NewCommentNotification($event->comment->issuingUser->name));
        }
    }
}
