<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserDetailsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;
    /**
     * Create a new message instance.
     */
    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function build()
    {
        return $this->view('emails.user_email')
                    ->subject('Your Account Details')
                    ->with([
                        'first_name' => $this->user->first_name,
                        'last_name' => $this->user->last_name,
                        'email' => $this->user->email,
                        'password' => $this->password,
                    ]);
    }
    
}
