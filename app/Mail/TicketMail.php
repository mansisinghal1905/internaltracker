<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $ticket_code;
    public $attachment;

    /**
     * Create a new message instance.
     */
    public function __construct($ticket, $ticketcode, $attachments = [])
    {
        $this->user = $ticket;
        $this->ticket_code = $ticketcode;
        $this->attachment = is_array($attachments) ? $attachments : [];
    }

    public function build()
    {
        $cname = "";
        if($this->user->getAllUser->first_name){
            $cname .=$this->user->getAllUser->first_name ." ";
        }
        if($this->user->getAllUser->last_name){
            $cname .=$this->user->getAllUser->last_name;
        }
        $email = $this->view('emails.ticket_email')
                      ->subject('New Ticket Created')
                      ->with([
                          'customer_name' => $cname,
                          'subject' => $this->user->subject,
                          'priority' => $this->user->priority,
                          'ticket_code' => $this->ticket_code,
                      ]);

        // Attach files if there are any
        if (!empty($this->attachment)) {
            foreach ($this->attachment as $filePath) {
                $email->attach($filePath);
            }
        }

        return $email;
    }
}
