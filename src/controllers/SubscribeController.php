<?php

namespace statikbe\campaignmonitor\controllers;

use Craft;
use craft\web\Controller;
use statikbe\campaignmonitor\services\CampaignMonitorService;

class SubscribeController extends Controller
{
    protected array|int|bool $allowAnonymous = ['index'];

    public function actionIndex()
    {
        $this->requirePostRequest();
        $request = Craft::$app->getRequest();

        // Fetch list id from hidden input
        $listId = $request->getRequiredBodyParam('listId') ? Craft::$app->security->validateData($request->post('listId')) : null;
        $redirect =  $request->getParam('redirect') ? Craft::$app->security->validateData($request->post('redirect')) : null;

        $email = $request->getParam('email');

         $subscriber = array(
             'EmailAddress' => $email,
             'Resubscribe' => true,
             'ConsentToTrack' => 'yes'
         );

         if ($request->getParam('email') !== null) {
             $response = CampaignMonitorService::instance()->addSubscriber($listId, $subscriber);
            return $request->getBodyParam('redirect') ? $this->redirectToPostedUrl() : $this->asJson($response);
         }

    }
}