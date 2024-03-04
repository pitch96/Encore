<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class MailJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $template;
    protected $bodyData;
    protected $emailTo;
    protected $emailFrom;
    protected $subject;
    protected $mailType;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($template, $bodyData, $emailTo, $emailFrom, $subject, $mailType)
    {
        $this->template     = $template;
        $this->bodyData     = $bodyData;
        $this->emailTo      = $emailTo;
        $this->emailFrom    = $emailFrom;
        $this->subject      = $subject;
        $this->mailType     = $mailType;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $template       = $this->template;
        $bodyData       = $this->bodyData;
        $emailTo        = $this->emailTo;
        $emailFrom      = $this->emailFrom;
        $subject        = $this->subject;
        $mailType       = $this->mailType;

        Mail::send($template, $bodyData, function ($message) use ($emailTo, $emailFrom, $mailType, $subject) {
            $message->from($emailFrom, $mailType);
            $message->to($emailTo);
            $message->subject($subject);
        });
    }
}
