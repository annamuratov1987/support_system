<?php

namespace App\Mail;

use App\Complaint;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class CloseComplaint extends Mailable
{
    use Queueable, SerializesModels;

    public $complaint;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Complaint $complaint)
    {
        $this->complaint = $complaint;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $result = $this->from(Auth::user())->view('mail.close');
        if($this->complaint->file_path != null){
            $result->attach(storage_path('app/') . $this->complaint->file_path);
        }
        return $result;
    }
}
