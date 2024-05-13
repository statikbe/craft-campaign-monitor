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

    public function checkSettings()
    {
        if ($this->getApiKey() && $this->getClientId()) {
            return true;
        }
        return false;
    }

    /**
     * Retrieve parsed API Key
     * @return string|null
     */
    public function getApiKey(): ?string
    {
        if (!$this->apiKey) {
//            Craft::$app->getUrlManager()->setRouteParams(['error' => Craft::t('site', "Please provide an API key")]);
            return null;
        }
        return Craft::parseEnv($this->apiKey);
    }

    /**
     * Retrieve parse Client Id
     * @return string|null
     */
    public function getClientId(): ?string
    {
        if (!$this->clientId) {
//            Craft::$app->getUrlManager()->setRouteParams(['error' => Craft::t('site', "Please provide a Client ID")]);
            return null;
        }
        return Craft::parseEnv($this->clientId);
    }
}
