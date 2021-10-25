<?php

namespace App\Controller\Cartographer;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/carto/index")
 */
class CartographerDashboardController extends CartographerControllerBase
{
    /**
     * @Route("/index", name="cartographer_index")
     */
    public function index(): Response
    {
        return $this->redirectToRoute('cartographer_region_index');
    }
}
