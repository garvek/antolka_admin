<?php

namespace App\Controller\Publisher;

use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Entity\Message;
use App\Form\Message\InfoRegionCreationData;
use App\Form\Message\InfoRegionCreationForm;
use App\Repository\RegionRepository;

/**
 * @Route("/publi/message/info-region")
 */
class InfoRegionPublisherController extends PublisherControllerBase
{
    private function redirectToIndex(): Response
    {
        /** @var AdminUrlGenerator */
        $routeBuilder = $this->get(AdminUrlGenerator::class);
        return $this->redirect($routeBuilder->setController(InfoRegionMessageController::class)->generateUrl());
    }

    /**
     * @Route("/index", name="message_inforegion_index")
     */
    public function index(): Response
    {
        return $this->render('message/info-region.html.twig', [
            'messages' => $this->mRepo->findBy(array('type' => Message::TYPE_REGION))
        ]);
    }

    private function createFromForm(InfoRegionCreationData $data, EntityManagerInterface $em, TranslatorInterface $trans): Message
    {
        $message = new Message();

        $message->setAuthor($trans->trans('region') . ' ' . $data->getRegion()->getName());
        $message->setType(Message::TYPE_REGION);
        $message->setTag($data->getRegion()->getId());
        $message->setTitle($data->getTitle());
        $message->setContent($data->getContent());
        $message->setPublished(new \DateTime());
        $em->persist($message);

        return $message;
    }

    private function updateFromEntity(InfoRegionCreationData $data, Message $message): void
    {
        $data->setTitle($message->getTitle());
        $data->setContent($message->getContent());
    }

    private function updateFromForm(Message $message, InfoRegionCreationData $data /*, EntityManagerInterface $em */): void
    {
        $message->setTitle($data->getTitle());
        $message->setContent($data->getContent());
    }

    /**
     * @Route("/create", name="message_inforegion_create")
     */
    public function create(RegionRepository $repo, Request $request, TranslatorInterface $trans)
    {
        $data = new InfoRegionCreationData();
        $form = $this->createForm(InfoRegionCreationForm::class, $data, array(
            'edit_mode' => false,
            'regions' => $repo->findAll())
        );
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var EntityManagerInterface */
            $em = $this->getDoctrine()->getManager();
            try {
                $message = $this->createFromForm($form->getData(), $em, $trans);
                $em->flush();
                $this->addFlash('success', 'Message created');
                return $this->redirectToIndex();
            }
            catch (\Exception $e) {
                $this->addFlash('warning', 'Cannot add Message: ' . $e->getMessage());
            }
        }
        
        return $this->renderForm('message/info-region_edit.html.twig', [
            'message' => null,
            'form' => $form,
            'errors' => $form->getErrors(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="message_inforegion_edit")
     */
    public function edit(RegionRepository $repo, int $id, Request $request)
    {
        $message = $this->mRepo->find($id);
        if (!$message) {
            return $this->redirectToIndex();
        }
        
        $data = new InfoRegionCreationData();
        $this->updateFromEntity($data, $message);
        $form = $this->createForm(InfoRegionCreationForm::class, $data, array(
            'edit_mode' => true,
            'regions' => $repo->findAll())
        );
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var EntityManagerInterface */
            $em = $this->getDoctrine()->getManager();
            try {
                $this->updateFromForm($message, $form->getData() /*, $em */);
                $em->flush();
                $this->addFlash('success', 'Message updated');
            }
            catch (\Exception $e) {
                $this->addFlash('warning', 'Cannot edit Message: ' . $e->getMessage());
            }
        }
        
        return $this->renderForm('message/info-region_edit.html.twig', [
            'message' => $message,
            'form' => $form,
            'errors' => $form->getErrors(),
        ]);
    }

    /**
     * @Route("/remove/{msg}", name="message_inforegion_remove")
     */
    public function remove(Message $msg)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($msg);
        $em->flush();
        $this->addFlash('success', 'Message removed');
        return $this->redirectToIndex();
    }
}
