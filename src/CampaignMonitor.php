<?php

namespace statikbe\campaignmonitor;

use Craft;
use craft\base\Model;
use craft\base\Plugin;
use statikbe\campaignmonitor\models\Settings;

class CampaignMonitor extends Plugin
{
    public bool $hasCpSettings = true;

    public function init(): void
    {
        parent::init();
    }

    protected function createSettingsModel(): ?Settings
    {
        return new Settings();
    }

    public function getSettings(): ?Settings
    {
        return new Settings();
    }


    protected function settingsHtml(): ?string
    {
        return \Craft::$app->getView()->renderTemplate('campaign-monitor/settings', [
            'settings' => $this->getSettings(),
        ]);
    }
}
