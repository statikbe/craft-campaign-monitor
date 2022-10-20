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
        if (!$this->apiKey){
            throw new \yii\base\Exception("Please provide an API key.");
        }
        return Craft::parseEnv($this->apiKey);
    }

    /**
     * Retrieve parse Client Id
     * @return string
     */
    public function getClientId(): string
    {
        if (!$this->clientId){
            throw new \yii\base\Exception("Please provide a Client ID.");
        }
        return Craft::parseEnv($this->clientId);
    }
}