<?php

namespace App\Jobs;

use App\Mail\OrderEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendOrderEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $orderItems;
    public $customerFirstName;
    public $customerEmail;
    public $orderNo;
    public $deliveryFee;
    public $totalPrice;
    public $siteEmail;
    public $companyPhoneNumber;

    public function __construct(
        $orderItems,
        $customerFirstName,
        $customerEmail,
        $orderNo,
        $deliveryFee,
        $totalPrice,
        $siteEmail,
        $companyPhoneNumber
    ) {
        $this->orderItems = $orderItems;
        $this->customerFirstName = $customerFirstName;
        $this->customerEmail = $customerEmail;
        $this->orderNo = $orderNo;
        $this->deliveryFee = $deliveryFee;
        $this->totalPrice = $totalPrice;
        $this->siteEmail = $siteEmail;
        $this->companyPhoneNumber = $companyPhoneNumber;
    }

    public function handle(): void
    {
        try {
            Mail::to($this->customerEmail)->send(new OrderEmail(
                $this->orderItems,
                $this->customerFirstName,
                $this->customerEmail,
                $this->orderNo,
                $this->deliveryFee,
                $this->totalPrice,
                $this->siteEmail,
                $this->companyPhoneNumber
            ));
        } catch (\Exception $e) {
            \Log::error('Order email job failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
