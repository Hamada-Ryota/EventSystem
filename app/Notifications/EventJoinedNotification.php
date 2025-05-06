<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class EventJoinedNotification extends Notification
{
    use Queueable;

    public $event;

    public function __construct($event)
    {
        $this->event = $event;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('イベント参加のお知らせ')
            ->greeting("こんにちは、{$notifiable->name}さん")
            ->line("「{$this->event->title}」に参加登録しました。")
            ->action('イベントを見る', route('events.show', $this->event->id))
            ->line('ご参加ありがとうございます！');
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "「{$this->event->title}」に参加登録しました。",
            'event_id' => $this->event->id,
        ];
    }
}
