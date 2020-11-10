<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Channels\MailChannel;
use Illuminate\Support\Facades\Log;
use NotificationChannels\Twilio\TwilioChannel;

/***
 * Class SthubAllowlistedUserNotification
 * @package App\Notifications
 */
abstract class SthubAllowlistedUserNotification extends ActionableNotification
{
    /**
     * Return a list of valid notification channels for
     * a notifiable.
     *
     * @param User $notifiable
     *
     * @return array
     */
    public function via(User $notifiable)
    {
        $contact_method = $notifiable->preferred_contact_method;

        if ($this->isOnlyDeliveryByEmail()) {
            $contact_method = 'email';
        }

        if ($this->isDeliveryByEmailIfItExists() && null === $notifiable->preferredEmail) {
            $contact_method = 'sms';
        } elseif ($this->isDeliveryByEmailIfItExists() && null !== $notifiable->preferredEmail) {
            $contact_method = 'email';
        }

        switch ($contact_method) {
            case 'email':
                return $this->viaEmail($notifiable);
            case 'sms':
                return $this->viaTwilio($notifiable);
            default:
                Log::error('No handler implemented for this contact method', [
                    'contact_method' => $contact_method,
                    'user_id' => $notifiable->id,
                ]);

                return [];
        }
    }

    /**
     * @param User $notifiable
     *
     * @return array|string[]
     */
    protected function viaEmail(User $notifiable)
    {
        if ($check_environment_overrides = $this->checkEnvironmentOverridesForUsers($notifiable, [MailChannel::class])) {
            return $check_environment_overrides;
        }

        $email_addresses_to_check = $notifiable->emails()->pluck('email')->toArray();
        $is_allowed = $this->areAnyEmailsOnAllowList($email_addresses_to_check);

        if ($is_allowed) {
            Log::debug('Allow List - Granted', ['email' => $notifiable->routeNotificationForMail()]);

            return [MailChannel::class];
        }

        Log::debug('Allow List - Failed: Not on the allow list', ['email' => $notifiable->routeNotificationForMail()]);

        return [];
    }

    /**
     * @param User $notifiable
     *
     * @return array|string[]
     */
    protected function viaTwilio(User $notifiable)
    {
        if ($check_environment_overrides = $this->checkEnvironmentOverridesForUsers($notifiable, [TwilioChannel::class])) {
            return $check_environment_overrides;
        }

        $phone_numbers_to_check = $notifiable->phones()->pluck('phone')->toArray();
        $is_allowed = $this->areAnyPhoneNumbersOnAllowList($phone_numbers_to_check);

        if ($is_allowed) {
            Log::debug('Allow List - Granted', ['phone' => $notifiable->routeNotificationForTwilio()]);

            return [TwilioChannel::class];
        }

        Log::debug('Allow List - Failed: Not on the allow list', ['phone' => $notifiable->routeNotificationForTwilio()]);

        return [];
    }

    /**
     * Do any email addresses belonging to this notifiable exist on the
     * allow list?
     *
     * @param array|null $email_addresses_to_check
     *
     * @return bool
     */
    public function areAnyEmailsOnAllowList(array $email_addresses_to_check = null)
    {
        foreach ($email_addresses_to_check as $email) {
            if ($this->isEmailOnAllowList($email)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Does this email address exist on the allow list?
     *
     * @param string $email
     *
     * @return bool
     */
    protected function isEmailOnAllowList(string $email)
    {
        $allowlist_email_domain = config('constants.allowlist_email_domains');
        $email_domain = explode('@', $email)[1];

        return in_array($email_domain, $allowlist_email_domain) || in_array($email, $this->allowlist_emails);
    }

    /**
     * Do any email addresses belonging to this notifiable exist on the
     * allow list?
     *
     * @param array|null $phone_numbers_to_check
     *
     * @return bool
     */
    public function areAnyPhoneNumbersOnAllowList(array $phone_numbers_to_check = null)
    {
        foreach ($phone_numbers_to_check as $phone) {
            if (in_array($phone, $this->allowlist_sms)) {
                return true;
            }
        }

        return false;
    }
}
