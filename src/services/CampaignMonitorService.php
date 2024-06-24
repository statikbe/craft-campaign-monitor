<?php

namespace statikbe\campaignmonitor\services;

use craft\base\Component;
use statikbe\campaignmonitor\CampaignMonitor;

class CampaignMonitorService extends Component
{
    private string|null $apiKey;

    public function init(): void
    {
        parent::init();
        $settings = CampaignMonitor::getInstance()->getSettings();
        $this->apiKey = $settings->getApiKey();
    }

    /**
     * @param string $listId
     * @param array<mixed> $subscriber
     * @return array<mixed>
     */
    public function addSubscriber(string $listId = '', array $subscriber = []): array
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
            }

            return [
                'success' => false,
                'statusCode' => $result->http_status_code,
                'reason' => $result->response->Message,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'reason' => $e->getMessage(),
            ];
        }
    }
}
