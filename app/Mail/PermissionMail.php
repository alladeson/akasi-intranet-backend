<?php

namespace App\Mail;

use App\Models\Permission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PermissionMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var \App\Models\Permission
     */
    public $permission;
/*     public $storePath;
 */
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
/*         $this->storePath = $storePath;
 */    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject:'DEMANDE DE PERMISSION - AKASI INTRANET',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view:'emails.permission',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        
       /*
       if ($this->permission->piece == null) {
            return [
                Attachment::fromPath($this->storePath),
            ];
        } else {
            return [
                Attachment::fromPath($this->storePath),
                Attachment::fromPath($this->permission->piece),
            ];

        }
         return [
            Attachment::fromPath('/var/www/akasi-intranet-backend/resources/images/logo.png'),
            Attachment::fromStorageDisk('local', $this->storePath)
                ->withMime('application/pdf'),
            Attachment::fromPath($this->storePath),
            $this->permission->piece !== null ? Attachment::fromPath($this->permission->piece) : "",
        ]; */
    }
}
