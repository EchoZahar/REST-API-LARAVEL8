<?php

namespace App\Mail;

use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendQuestionMail extends Mailable
{
    use Queueable, SerializesModels;

    private $question;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Question $question)
    {
        $this->question = $question;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('app@example.com')
            ->view('email.sendQuestion')
            ->with([
                'qId' => $this->question->id,
                'qName' => $this->question->name,
                'qMessage' => $this->question->message,
                'qComment' => $this->question->comment,
                'qDateTime' => Carbon::parse($this->question->dateTime)->format('d.m.Y H:i'),
                'qStatus' => $this->question->status,
            ]);
    }
}
