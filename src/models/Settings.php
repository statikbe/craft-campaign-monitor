<?php

namespace statikbe\campaignmonitor\models;

use Craft;
use craft\base\Model;

class Settings extends Model
{
    public ?string $apiKey = null;
    public ?string $clientId = null;

    public function rules(): array
    {
        return [
            [['apiKey'], 'string'],
            [['apiKey'], 'required'],
            [['clientId'], 'string'],
            [['clientId'], 'required'],
        ];
    }

    /**
     * Retrieve parsed API Key
     * @return string
     */
    public function getApiKey(): string
    {
        return Craft::parseEnv($this->apiKey);
    }

    /**
     * Retrieve parse Client Id
     * @return string
     */
    public function getClientId(): string
    {
        return Craft::parseEnv($this->clientId);
    }
}