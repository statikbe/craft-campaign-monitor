<?php

namespace statikbe\campaignmonitor;

use Craft;
use craft\base\Model;
use craft\base\Plugin;
use statikbe\campaignmonitor\models\Settings;

class CampaignMonitor extends Plugin
{
    public bool $hasCpSettings = true;

    /**
     * @var CampaignMonitor
     */
    public static $plugin;

    public function init(): void
    {
        parent::init();
    }

    protected function createSettingsModel(): ?Model
    {
        return Craft::createObject(Settings::class);
    }

    protected function settingsHtml(): ?string
    {
        return \Craft::$app->getView()->renderTemplate('campaign-monitor/settings', [
            'settings' => $this->getSettings(),
        ]);
    }
}
