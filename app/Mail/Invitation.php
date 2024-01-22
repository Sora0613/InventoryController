<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Invitation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct($inviterName, $invitationLink)
    {
        $this->title = "[参加依頼のお知らせ]";
        $this->inviterName = $inviterName;
        $this->invitationLink = $invitationLink;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('emails.invitation')
            ->subject($this->title)
            ->with([
                'inviterName' => $this->inviterName,
                'invitationLink' => $this->invitationLink,
            ]);
    }
}
