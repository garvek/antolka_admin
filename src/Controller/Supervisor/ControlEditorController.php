<?php

namespace App\Controller\Supervisor;

use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Adventurer;
use App\Entity\ControlInfo;
use App\Entity\User;
use App\Form\Editor\AdventurerControlData;
use App\Form\Editor\AdventurerControlForm;
use App\Repository\AdventurerRepository;
use App\Repository\ControlInfoRepository;
use App\Repository\UserRepository;

/**
 * @Route("/super/editor/control")
 */
class ControlEditorController extends EditorControllerBase
{
    private $advRepo;
    private $uRepo;
    private $cRepo;
    
    public function __construct(AdventurerRepository $advRepo, UserRepository $uRepo, ControlInfoRepository $cRepo)
    {
        $this->advRepo = $advRepo;
        $this->uRepo = $uRepo;
        $this->cRepo = $cRepo;
    }
    
    private function redirectToIndex(): Response
    {
        /** @var AdminUrlGenerator */
        $routeBuilder = $this->get(AdminUrlGenerator::class);
        return $this->redirect($routeBuilder->setController(ControlEditorController::class)->generateUrl());
    }

    /**
     * @Route("/index", name="editor_control_index")
     */
    public function index(): Response
    {
        $list = $this->cRepo->findAll();
        
        return $this->render('editor/control.html.twig', [
            'list' => $list,
        ]);
    }

    private function createFromForm(AdventurerControlData $data, EntityManagerInterface $em): ControlInfo
    {
        $control = new ControlInfo();

        $control->setAdventurer($data->getAdventurer());
        $control->setUser($data->getUser());
        $em->persist($control);

        return $control;
    }

    /**
     * @Route("/create", name="editor_control_create")
     */
    public function create(Request $request): Response
    {
        $users = $this->uRepo->findAll();
        $allowedUsers = array();
        foreach ($users as $user) {
            if (!empty(array_intersect(array(User::ROLE_PAWN, User::ROLE_SUPERVISOR, User::ROLE_ADMIN), $user->getRoles()))) {
                $allowedUsers[] = $user;
            }
        }
        $adventurers = $this->advRepo->findBy(array('controlType' => array(Adventurer::TYPE_GAMEMASTER, Adventurer::TYPE_AUTOMATED)));
        
        $data = new AdventurerControlData();
        $form = $this->createForm(AdventurerControlForm::class, $data, array(
            'allowed_users' => $allowedUsers,
            'adventurers' => $adventurers
        ));
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var EntityManagerInterface */
            $em = $this->getDoctrine()->getManager();
            try {
                $this->createFromForm($form->getData(), $em);
                $em->flush();
                $this->addFlash('success', 'Control created');
                return $this->redirectToIndex();
            }
            catch (\Exception $e) {
                $this->addFlash('warning', 'Cannot add Control: ' . $e->getMessage());
            }
        }
        
        return $this->renderForm('editor/control_edit.html.twig', [
            'form' => $form,
            'errors' => $form->getErrors(),
        ]);
    }
    
    /**
     * @Route("/remove/{control}", name="editor_control_remove")
     */
    public function remove(ControlInfo $control): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($control);
        $em->flush();
        $this->addFlash('success', 'Control removed');
        return $this->redirectToIndex();
    }
}
