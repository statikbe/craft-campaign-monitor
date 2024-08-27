<?php

namespace statikbe\campaignmonitor\events;

use yii\base\Event;

class ApiResponseEvent extends Event
{
    public array $response;
    public string $listId;
    public array $subscriber;
}
