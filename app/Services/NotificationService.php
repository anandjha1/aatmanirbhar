<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    /**
     * Send a notification to Telegram.
     */
    public function sendTelegram(string $message): bool
    {
        $botToken = config('services.telegram.bot_token');
        $chatId = config('services.telegram.chat_id');

        if (! $botToken || ! $chatId) {
            Log::warning('Telegram notification skipped: credentials not set.');

            return false;
        }

        try {
            $response = Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Telegram notification error: '.$e->getMessage());

            return false;
        }
    }

    /**
     * Send an email notification.
     */
    public function sendEmail(string $to, string $subject, string $view, array $data = []): bool
    {
        try {
            Mail::send($view, $data, function ($message) use ($to, $subject) {
                $message->to($to)->subject($subject);
            });

            return true;
        } catch (\Exception $e) {
            Log::error('Email notification error: '.$e->getMessage());

            return false;
        }
    }

    /**
     * Notify Admin of new Enquiry.
     */
    public function notifyNewEnquiry($enquiry): void
    {
        $msg = "<b>New Enquiry Received!</b>\n\n";
        $msg .= "Name: {$enquiry->full_name}\n";
        $msg .= "Mobile: {$enquiry->mobile}\n";
        $msg .= "Source: {$enquiry->source->label()}\n";

        $this->sendTelegram($msg);
    }
}
