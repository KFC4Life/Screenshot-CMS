<?php

namespace App\Notifications\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;
use NotificationChannels\DiscordWebhook\DiscordWebhookChannel;
use NotificationChannels\DiscordWebhook\DiscordWebhookMessage;

class NewScreenshotUploaded extends Notification implements ShouldQueue
{
    use Queueable;

    protected $screenshot;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($screenshot)
    {
        $this->screenshot = $screenshot;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack', DiscordWebhookChannel::class];
    }

    /**
     * Get the slack representation of the notification
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\SlackMessage
     */
    public function toSlack($notifiable)
    {
        $url = route('screenshot.get', $this->screenshot->name);

        return (new SlackMessage)
            ->from('Screenshot CMS')
            ->content('A new screenshot has been uploaded, check out the details below!')
            ->attachment(function ($attachment) use ($url) {
            $attachment->title('Screenshot')
                ->fields([
                    'Generated name' => $this->screenshot->name,
                    'URL' => $url,
                ]);
    });
    }

    /**
     * Get the discord representation of the notification
     *
     * @param mixed $notifiable
     * @return \NotificationChannels\DiscordWebhook\DiscordWebhookMessage
     */
    public function toDiscordWebhook($notifiable)
    {
        return (new DiscordWebhookMessage)
            ->from('Screenshot CMS')
            ->content('A new screenshot has been uploaded.')
            ->embed(function ($embed) {
                $url = route('screenshot.get', $this->screenshot->name);
                $file_url = url('/storage/screenshots/'.$this->screenshot->full_name);

                $embed->field('Generated name', $this->screenshot->name, true)
                      ->field('URL', $url, true)
                      ->image($file_url);
            });
    }
}
