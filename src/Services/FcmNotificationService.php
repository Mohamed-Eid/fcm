<?php

namespace Bluex\Fcm\Serices;

class FcmNotificationService
{
    protected $FCM_KEY;

    private $title;

    private $body;

    private $clickAction;

    private $image;

    private $icon;

    private $sound;

    private $additionalData;

    public function __construct()
    {
        $this->FCM_KEY = config('fcm.fcm_server_key');
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    public function setClickAction($clickAction)
    {
        $this->clickAction = $clickAction;
        return $this;
    }

    public function setSound($sound)
    {
        $this->sound = $sound;
        return $this;
    }

    public function setAdditionalData($additionalData)
    {
        $this->additionalData = $additionalData;
        return $this;
    }

    public function sendNotificationTo(array $tokens)
    {
        $body = [
            'registration_ids' => $tokens,
            'notification' => [
                'title' => $this->title,
                'body' => $this->body,
                'image' => $this->image,
                'icon' => $this->icon,
                'content-available' => 1,
                'sound' => $this->sound ?? 'default',
                'click_action' => $this->clickAction
            ],
            'data' => $this->additionalData,
            'priority' => 'high'
        ];

        $res = $this->sendRequestToFcm($body);

        return json_decode($res->getBody());
    }

    public function sendDataTo(array $tokens)
    {
        $data = array_merge([
            'title' => $this->title,
            'body' => $this->body,
            'image' => $this->image,
            'icon' => $this->icon,
            'content-available' => 1,
            'sound' => $this->sound ?? 'default',
            'click_action' => $this->clickAction
        ], $this->additionalData);

        $body = [
            'registration_ids' => $tokens,
            'data' => $data,
            'priority' => 'high'
        ];

        $res = $this->sendRequestToFcm($body);

        return json_decode($res->getBody());
    }

    private function getHeaders()
    {
        return [
            'Authorization' => 'key=' . $this->FCM_KEY,
            'Content-Type' => 'application/json'
        ];
    }

    private function sendRequestToFcm($body)
    {
        $client = new \GuzzleHttp\Client(['headers' => $this->getHeaders()]);

        $response = $client->post('https://fcm.googleapis.com/fcm/send', [
            'body' => json_encode($body),
        ]);

        //dd(json_decode($response->getBody()));
        return $response;
    }
}
