<?php

namespace App\Controller\Publisher;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/publi/message")
 */
class PublisherDashboardController extends PublisherControllerBase
{
    /**
     * @Route("/index", name="message_index")
     */
    public function index(): Response
    {
        return $this->redirectToRoute('message_news_index');
    }
}
