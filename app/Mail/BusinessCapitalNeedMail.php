<?php

namespace App\Mail;

use App\Models\BusinessCapitalNeed;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BusinessCapitalNeedMail extends Mailable
{
    use Queueable, SerializesModels;

    public BusinessCapitalNeed $businessCapitalNeed;
    public $emailBody;

    public $email;
    
    /**
     * Create a new message instance.
     */
    public function __construct(BusinessCapitalNeed $businessCapitalNeed, $emailBody, $email = null)
    {
        $this->businessCapitalNeed = $businessCapitalNeed;
        $this->emailBody = $emailBody;
        $this->email = $email;
    }

    public function build()
    {
        $subject = $this->businessCapitalNeed->subject ?? 'Đăng ký nhu cầu vốn';

        return $this->view('emails.business_capital_need')
                    ->with('businessCapitalNeed', $this->businessCapitalNeed)
                    ->with(['emailBody' => $this->emailBody])
                    ->with(['email' => $this->email])
                    ->subject($subject);
    }
}
