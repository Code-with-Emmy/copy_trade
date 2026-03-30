<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Plan;
use App\Models\UserPlan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PlanCompleted extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $plan;
    public $userPlan;
    public $settings;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param Plan $plan
     * @param UserPlan $userPlan
     */
    public function __construct(User $user, Plan $plan, UserPlan $userPlan)
    {
        $this->user = $user;
        $this->plan = $plan;
        $this->userPlan = $userPlan;
        $this->settings = \App\Models\Settings::find(1);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $siteName = optional($this->settings)->site_name ?: config('app.name');
        $currency = optional($this->settings)->currency ?: '$';
        $startDate = optional($this->userPlan->activated_at)->format('M d, Y')
            ?: optional($this->userPlan->created_at)->format('M d, Y')
            ?: now()->format('M d, Y');
        $endDate = optional($this->userPlan->expires_at)->format('M d, Y')
            ?: now()->format('M d, Y');

        return $this->subject("Investment Plan Completed: {$this->plan->name}")
            ->markdown('emails.plans.completed')
            ->with([
                'name' => $this->user->name,
                'planName' => $this->plan->name,
                'amount' => $this->userPlan->invested_amount,
                'profit' => $this->userPlan->total_profit,
                'currency' => $currency,
                'totalReturn' => $this->userPlan->invested_amount + $this->userPlan->total_profit,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'siteName' => $siteName,
                'siteUrl' => url('/'),
            ]);
    }
}
