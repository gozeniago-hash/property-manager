<?php

namespace App\Mail;

use App\Models\Bill;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewBillMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Bill $bill)
    {
    }

    public function build(): self
    {
        $unitLabel = optional($this->bill->unit->property)->name.' / '.$this->bill->unit->name;

        return $this
            ->subject('New bill: '.ucfirst($this->bill->type).' due '.$this->bill->due_date->format('M j, Y'))
            ->view('emails.new-bill')
            ->with([
                'bill' => $this->bill,
                'unitLabel' => $unitLabel,
            ]);
    }
}
