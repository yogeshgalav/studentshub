<?php

namespace App\Notifications;

use App\Models\ScheduledJob;
use App\Models\User;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Channels\MailChannel;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use NotificationChannels\Twilio\TwilioChannel;

class SthubNotification extends Notification
{
    use Queueable;

    /** @var ScheduledJob */
    protected $scheduled_job;

    /* @var array */
    protected $allowlist_emails;

    /* @var array */
    protected $allowlist_email_domains;

    /* @var array */
    protected $allowlist_sms;

    /* @var bool */
    protected bool $abort_sending = false;

    /* @var bool */
    protected bool $delivery_by_email_if_it_exists = false;

    /* @var bool */
    protected bool $only_delivery_by_email = false;

    /**
     * @return bool
     */
    public function isDeliveryByEmailIfItExists(): bool
    {
        return $this->delivery_by_email_if_it_exists;
    }

    /**
     * @param bool $delivery_by_email_if_it_exists
     */
    public function setDeliveryByEmailIfItExists(bool $delivery_by_email_if_it_exists): void
    {
        $this->delivery_by_email_if_it_exists = $delivery_by_email_if_it_exists;
    }

    /**
     * @return bool
     */
    public function isOnlyDeliveryByEmail(): bool
    {
        return $this->only_delivery_by_email;
    }

    /**
     * @param bool $only_delivery_by_email
     */
    public function setOnlyDeliveryByEmail(bool $only_delivery_by_email): void
    {
        $this->only_delivery_by_email = $only_delivery_by_email;
    }

    /**
     * ActionableNotification constructor.
     * @return void
     */
    public function __construct()
    {
        $this->allowlist_emails = config('constants.allowlist_emails');
        $this->allowlist_email_domains = config('constants.allowlist_email_domains');
        $this->allowlist_sms = config('constants.allowlist_phone_sms');
        $this->only_delivery_by_email = false;
        $this->delivery_by_email_if_it_exists = false;
    }

    /**
     * @return ScheduledJob
     */
    public function getScheduledJob()
    {
        return $this->scheduled_job;
    }

    /**
     * Call this function to abort sending the notification.
     *
     * @param string $reason
     *
     * @return bool
     */
    public function abortSending(string $reason) : bool
    {
        Log::info('Aborting Notification', [
            'reason' => $reason,
            'scheduled_job_id' => $this->scheduled_job->id,
        ]);

        $this->scheduled_job->update([
            'response' => json_encode($reason),
        ]);

        $this->abort_sending = true;

        return true;
    }

    /**
     * @param string $url
     *
     * @return string
     */
    public function urlShortener(string $url)
    {
        // TODO: Implement at a later date.
        return $url;
    }

    /**
     * Check for special conditions, like being in production, or using
     * maildev or a log for local testing.
     *
     * @param User $user
     *
     * @param array $channels
     *
     * @return string[]
     */
    public function checkEnvironmentOverridesForUsers(User $user, array $channels)
    {
        return $this->checkEnvironmentOverrides($user, $channels);
    }

    /**
     * Check for special conditions, like being in production, or using
     * maildev or a log for local testing.
     *
     * @param Buddy $buddy
     *
     * @param array $channels
     *
     * @return string[]
     */
    public function checkEnvironmentOverridesForBuddies(Buddy $buddy, array $channels)
    {
        return $this->checkEnvironmentOverrides($buddy, $channels);
    }

    /**
     * Check for special conditions, like being in production, or using
     * maildev or a log for local testing.
     *
     * @param User|Buddy $notifiable
     *
     * @param array $channels
     *
     * @return string[]
     */
    public function checkEnvironmentOverrides($notifiable, array $channels)
    {
        // No allow list applies to production messages
        if ('production' === config('app.env')) {
            return $channels;
        }

        // No allow list applies to testing messages
        if ('testing' === config('app.env')) {
            Log::debug('Allow List - Granted for Automated Tests', [
                'email' => $notifiable->routeNotificationForMail(),
                'sms' => $notifiable->routeNotificationForTwilio(),
                ]);

            return $channels;
        }

        // Allow all delivery if using "maildev" host or when the mail destination is a log file
        if ('maildev' === config('mail.host') || 'log' === config('mail.default')) {
            Log::debug('Allow List - Granted: MailDev Host or Logging Driver', [
                'email' => $notifiable->routeNotificationForMail(),
                'sms' => $notifiable->routeNotificationForTwilio(),
            ]);

            return $channels;
        }

        // Blocks by Default
        return [];
    }

    /**
     * Converts a Notification Channel class name to a string for
     * inclusion in message querystring.
     *
     * @param string $string
     *
     * @return string
     * @throws Exception
     */
    public function convertChannelToQuerystringParameter(string $string) : string
    {
        switch ($string) {
            case TwilioChannel::class:
                return 'sms';
            case MailChannel::class:
                return 'mail';
        }

        throw new Exception('Unknown Notification Channel');
    }
}
