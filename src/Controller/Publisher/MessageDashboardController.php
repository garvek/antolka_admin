<?php

namespace App\Controller\Publisher;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/publi/message")
 */
class MessageDashboardController extends MessageControllerBase
{
    /**
     * @Route("/index", name="message_index")
     */
    public function index(): Response
    {
        return $this->redirectToRoute('message_news_index');
    }
}
