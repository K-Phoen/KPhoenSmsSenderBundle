<?php

namespace KPhoen\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller
{
    public function indexAction(Request $request)
    {
        $sender = $this->get('sms.sender');
        $sender->send($request->query->get('recipient'), $request->query->get('body'));

        return new Response('lala', 200, array(
            'Content-Type' => 'text/plain',
        ));
    }
}
