<?php

namespace App\Mail;

use App\Answer;
use App\Complaint;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class AnswerComplaint extends Mailable
{
    use Queueable, SerializesModels;

    public $complaint;
    public $answer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Complaint $complaint, Answer $answer)
    {
        $this->complaint = $complaint;
        $this->answer = $answer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $result = $this->from(Auth::user())->view('mail.answer');
        if($this->answer->file_path != null){
            $result->attach(storage_path('app/') . $this->answer->file_path);
        }
        return $result;
    }
}
