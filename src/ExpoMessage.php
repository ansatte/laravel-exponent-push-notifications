<?php

namespace NotificationChannels\ExpoPushNotifications;

use NotificationChannels\ExpoPushNotifications\Exceptions\CouldNotCreateMessage;

class ExpoMessage
{
    /**
     * The message title.
     *
     * @var string
     */
    protected $title;

    /**
     * The message body.
     *
     * @var string
     */
    protected $body;

    /**
     * The sound to play when the recipient receives this notification.
     *
     * @var string|null
     */
    protected $sound = 'default';

    /**
     * The number to display next to the push notification (iOS).
     * Specify zero to clear the badge.
     *
     * @var int
     */
    protected $badge = 0;

    /**
     * The number of seconds for which the message may be kept around for redelivery if it has not been delivered yet.
     *
     * @var int
     */
    protected $ttl = 0;

    /**
     * ID of the Notification Channel through which to display this notification on Android devices.
     *
     * @var string
     */
    protected $channelId = 'Default';

    /**
     * The json data attached to the message.
     *
     * @var string
     */
    protected $jsonData = '{}';

    /**
     * Create a message with given body.
     *
     * @param string $body
     *
     * @return static
     */
    public static function create($body = '')
    {
        return new static($body);
    }

    /**
     * ExpoMessage constructor.
     *
     * @param string $body
     */
    public function __construct(string $body = '')
    {
        $this->body = $body;
    }

    /**
     * Set the message title.
     *
     * @param string $value
     *
     * @return $this
     */
    public function title(string $value)
    {
        $this->title = $value;

        return $this;
    }

    /**
     * Set the message body.
     *
     * @param string $value
     *
     * @return $this
     */
    public function body(string $value)
    {
        $this->body = $value;

        return $this;
    }

    /**
     * Enable the message sound.
     *
     * @return $this
     */
    public function enableSound()
    {
        $this->sound = 'default';

        return $this;
    }

    /**
     * Disable the message sound.
     *
     * @return $this
     */
    public function disableSound()
    {
        $this->sound = null;

        return $this;
    }

    /**
     * Set the message badge (iOS).
     *
     * @param int $value
     *
     * @return $this
     */
    public function badge(int $value)
    {
        $this->badge = $value;

        return $this;
    }

    /**
     * Set the time to live of the notification.
     *
     * @param int $ttl
     *
     * @return $this
     */
    public function setTtl(int $ttl)
    {
        $this->ttl = $ttl;

        return $this;
    }

    /**
     * Set the channelId of the notification for Android devices.
     *
     * @param string $channelId
     *
     * @return $this
     */
    public function setChannelId(string $channelId)
    {
        $this->channelId = $channelId;

        return $this;
    }

    /**
     * Set the json Data attached to the message.
     *
     * @param array|string $data
     *
     * @return $this
     *
     * @throws CouldNotCreateMessage
     */
    public function setJsonData($data)
    {
        if (is_array($data)) {
            $data = json_encode($data);
        } elseif (is_string($data)) {
            @json_decode($data);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new CouldNotCreateMessage('Invalid json format passed to the setJsonData().');
            }
        }

        $this->jsonData = $data;

        return $this;
    }

    /**
     * Get an array representation of the message.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'title'     =>  $this->title,
            'body'      =>  $this->body,
            'sound'     =>  $this->sound,
            'badge'     =>  $this->badge,
            'ttl'       =>  $this->ttl,
            'data'      => $this->jsonData,
        ];
    }
}
