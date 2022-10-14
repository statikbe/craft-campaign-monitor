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

        $email = $request->getParam('email');
        $fullName = '';
        if ($request->getParam('fullname') !== null)
            $fullName = $request->getParam('fullname');
        if ($request->getParam('firstname') !== null)
            $fullName = $request->getParam('firstname');
        if ($request->getParam('lastname') !== null)
            $fullName .= ' ' . $request->getParam('lastname');

         $subscriber = array(
             'EmailAddress' => $email,
             'Name' => $fullName,
             'Resubscribe' => true,
             'ConsentToTrack' => 'yes'
         );

         if ($email !== null) {
             $response = CampaignMonitorService::instance()->addSubscriber($listId, $subscriber);
            return $request->getBodyParam('redirect') ? $this->redirectToPostedUrl() : $this->asJson($response);
         }

    }
}