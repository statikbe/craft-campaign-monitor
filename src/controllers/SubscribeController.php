<?php

namespace statikbe\campaignmonitor\controllers;

use Craft;
use craft\web\Controller;
use statikbe\campaignmonitor\CampaignMonitor;
use statikbe\campaignmonitor\services\CampaignMonitorService;

class SubscribeController extends Controller
{
    protected array|int|bool $allowAnonymous = ['index'];

    public function actionIndex()
    {
        if(!CampaignMonitor::getInstance()->getSettings()->checkSettings()) {
            Craft::$app->getSession()->setError(Craft::t('site', "Please provide an API key and Client ID"));
            return $this->asFailure(Craft::t('site', "Please provide an API key and Client ID"));
        }
        $this->requirePostRequest();
        $request = Craft::$app->getRequest();

        if (CampaignMonitor::getInstance()->getSettings()->validateRecaptcha) {
            if (empty($_POST['g-recaptcha-response'])) {
                Craft::$app->getSession()->setError(Craft::t('site', "Failed to validate reCAPTCHA"));
                return $this->asFailure(Craft::t('site', "Failed to validate reCAPTCHA"));
            }
        }

        // Fetch list id from hidden input
        $listId = $request->getRequiredBodyParam('listId') ?? null;

        $email = $request->getRequiredBodyParam('email');
        if(!$email) {
            Craft::$app->getSession()->setError(Craft::t('site', "Please provide an email"));
            return $this->asFailure(Craft::t('site', "Please provide an email"));
        }

        $fullName = '';
        if ($request->getParam('fullname') !== null) {
            $fullName = $request->getParam('fullname');
        }
        if ($request->getParam('firstname') !== null) {
            $fullName = $request->getParam('firstname');
        }
        if ($request->getParam('lastname') !== null) {
            $fullName .= ' ' . $request->getParam('lastname');
        }

        $additionalFields = [];
        if ($request->getParam('fields') !== null) {
            foreach($request->getParam('fields') as $key => $value) {
                if ($key != 'email' && $key != 'firstname' && $key != 'lastname' && $key != 'fullname') {
                    $additionalFields[] = array(
                        'Key' => $key,
                        'Value' => $value
                    );
                }
            }
        }

        $subscriber = array(
            'EmailAddress' => $email,
            'Name' => $fullName,
            'CustomFields' => $additionalFields,
            'Resubscribe' => true,
            'ConsentToTrack' => 'yes'
        );

        if ($email) {
            if (is_array($listId)) {
                foreach ($listId as $id) {
                    if(!($id = Craft::$app->security->validateData($id))) {
                        continue;
                    }
                    $response = CampaignMonitorService::instance()->addSubscriber($id, $subscriber);
                }
                return $this->redirectToPostedUrl();
            } else {
                if(!($listId = Craft::$app->security->validateData($listId))) {
                    return $this->asJson([
                        'success' => false,
                        'statusCode' => 400,
                        'reason' => 'No valid list id',
                    ]);
                }
                $response = CampaignMonitorService::instance()->addSubscriber($listId, $subscriber);
                return $request->getBodyParam('redirect') ? $this->redirectToPostedUrl() : $this->asJson($response);
            }
        }

    }
}
