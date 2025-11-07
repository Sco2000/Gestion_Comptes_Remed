<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConfirmationNewCompteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $compte;

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        //
    }

    public function setUser($user)
    {
        $this->user = $user;
        // Assuming compte is related to user, but we need to get the latest compte
        // This might need adjustment based on how comptes are related
        $this->compte = $user->client->comptes()->latest()->first();
        return $this;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmation de création de votre nouveau compte bancaire',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.new-account-confirmation',
            with: [
                'compte' => $this->compte,
                'client' => $this->user->client,
                'user' => $this->user,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
