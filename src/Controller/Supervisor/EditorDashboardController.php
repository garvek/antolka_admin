<?php

namespace App\Controller\Supervisor;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/super/editor")
 */
class EditorDashboardController extends EditorControllerBase
{
    /**
     * @Route("/index", name="editor_index")
     */
    public function index(): Response
    {
        return $this->redirectToRoute('editor_adventurer_index');
    }
}
