<?php

namespace statikbe\campaignmonitor\services;

use craft\base\Component;
use statikbe\campaignmonitor\CampaignMonitor;
use statikbe\campaignmonitor\events\ApiResponseEvent;

class CampaignMonitorService extends Component
{
    public const EVENT_AFTER_SUBSCRIBE = 'afterSubscribe';

    private string|null $apiKey;
    private string|null $clientId;

    public function init(): void
    {
        parent::init();

        $settings = CampaignMonitor::getInstance()->getSettings();
        $this->apiKey = $settings->getApiKey();
        $this->clientId = $settings->getClientId();
    }

    public function addSubscriber(string $listId = '', array $subscriber = array()): array
    {
        try {
            $auth = [
                'api_key' => $this->apiKey,
            ];

            $client = new \CS_REST_Subscribers(
                $listId,
                $auth
            );
            $result = $client->add($subscriber);

            if($result->was_successful()) {
                $body = $result->response;

                $response = [
                    'success' => true,
                    'statusCode' => $result->http_status_code,
                    'body' => $body
                ];

                $this->trigger(self::EVENT_AFTER_SUBSCRIBE, new ApiResponseEvent([
                    'listId' => $listId,
                    'subscriber' => $subscriber,
                    'response' => $response,
                ]));

                return $response;
            } else {
                return [
                    'success' => false,
                    'statusCode' => $result->http_status_code,
                    'reason' => $result->response->Message
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'reason' => $e->getMessage()
            ];
        }
    }
}
