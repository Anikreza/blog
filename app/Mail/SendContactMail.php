<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendContactMail extends Mailable
{
    use Queueable, SerializesModels;

    private $data;

    /**
     * Create a new message instance.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): SendContactMail
    {
        return $this
            ->subject($this->data['subject'] . ' - ' . env('APP_NAME'))
            ->from($this->data['email'], $this->data['name'])
            ->replyTo($this->data['email'], $this->data['name'])
            ->markdown('email.contact-template', ['data' => $this->data]);
    }
}
