<?php

namespace App\Mail;

use App\Models\BusinessMember;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BusinessRegistered extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public BusinessMember $businessMember;

    public function __construct(BusinessMember $businessMember)
    {
        $this->businessMember = $businessMember;
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

    public function build()
    {
        $subject = $this->businessMember->subject ?? 'Đăng ký tham gia app';

        return $this->view('emails.business_registered')
                    ->with('businessMember', $this->businessMember)
                    ->subject($subject);
    }
    
}
