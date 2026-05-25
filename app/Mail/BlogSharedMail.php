<?php

namespace App\Mail;

use App\Models\Blog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BlogSharedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $blog;
    public $subscriberId;

    /**
     * Create a new message instance.
     */
    public function __construct(Blog $blog, $subscriberId = null)
    {
        $this->blog = $blog;
        $this->subscriberId = $subscriberId;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('New Blog Post: ' . $this->blog->title)
                    ->view('emails.blog_shared')
                    ->with(['subscriberId' => $this->subscriberId]);
    }
}
?>
