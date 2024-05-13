<?php

namespace statikbe\campaignmonitor;

use Craft;
use craft\base\Plugin;

class CampaignMonitor extends Plugin
{
    public bool $hasCpSettings = true;

    public function init()
    {
        parent::init();

        // Custom initialization code goes here...
    }

    protected function createSettingsModel(): ?craft\base\Model
    {
        return new \statikbe\campaignmonitor\models\Settings();
    }

    protected function settingsHtml(): ?string
    {
        return \Craft::$app->getView()->renderTemplate('campaign-monitor/settings', [
            'settings' => $this->getSettings(),
        ]);
    }
}
