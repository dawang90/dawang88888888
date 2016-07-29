<?php

class SiteController extends Controller
{
    // ...其它代码...

    public function actionSay($message = 'Hello')
    {
        return $this->render('say', ['message' => $message]);
    }
}
