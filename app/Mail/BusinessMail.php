<?php

namespace App\Mail;

use App\Models\Business;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Bus;

class BusinessMail extends Mailable
{
    use Queueable, SerializesModels;


    public Business $business;
    
    /**
     * Create a new message instance.
     */
    public function __construct(Business $business)
    {
        $this->business = $business;
    }

    public function build()
    {
        $subject = $this->business->subject ?? 'Đăng ký kết nối giao thương';

        return $this->view('emails.business_mail')
                    ->with('business', $this->business)
                    ->subject($subject);
    }
}
