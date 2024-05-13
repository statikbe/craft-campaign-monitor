<?php

namespace statikbe\campaignmonitor\models;

use Craft;
use craft\base\Model;
use craft\helpers\App;

class Settings extends Model
{
    public ?string $apiKey = null;

    /**
     * @return array<mixed>
     */
    public function rules(): array
    {
        return [
            [['apiKey'], 'string'],
            [['apiKey'], 'required'],
        ];
    }

    public function checkSettings(): bool
    {
        if ($this->getApiKey()) {
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
        return App::parseEnv($this->apiKey);
    }

}
