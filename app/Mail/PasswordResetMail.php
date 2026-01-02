<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;

    public function __construct(User $user, string $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    public function build()
    {
        return $this->view('emails.password-reset')
                    ->subject('Password Reset Request')
                    ->with([
                        'user' => $this->user,
                        'token' => $this->token,
                        'resetUrl' => config('app.frontend_url') . '/reset-password?token=' . $this->token . '&email=' . urlencode($this->user->email)
                    ]);
    }
}
