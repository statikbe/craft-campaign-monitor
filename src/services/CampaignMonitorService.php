<?php

namespace statikbe\campaignmonitor\services;

use craft\base\Component;
use statikbe\campaignmonitor\CampaignMonitor;

class CampaignMonitorService extends Component
{
    private string|null $apiKey;
    private string|null $clientId;

    public function init(): void
    {
        parent::init();

        $settings = CampaignMonitor::getInstance()->getSettings();
        $this->apiKey = $settings->getApiKey();
        $this->clientId = $settings->getClientId();
    }

    public function addSubscriber($listId = '', $subscriber = array())
    {
        try {
            $auth = [
                'api_key' => $this->apiKey,
            ];

            $client = new \CS_REST_Subscribers(
                $listId,
                $auth);
            $result = $client->add($subscriber);

            if ($result->was_successful()) {
                $body = $result->response;
                return [
                    'success' => true,
                    'statusCode' => $result->http_status_code,
                    'body' => $body,
                ];
            } else {
                return [
                    'success' => false,
                    'statusCode' => $result->http_status_code,
                    'reason' => $result->response->Message,
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'reason' => $e->getMessage(),
            ];
        }
    }
}
