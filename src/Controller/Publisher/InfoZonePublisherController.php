<?php

namespace App\Controller\Publisher;

use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Entity\Message;
use App\Form\Message\InfoZoneCreationData;
use App\Form\Message\InfoZoneCreationForm;
use App\Repository\ZoneRepository;

/**
 * @Route("/publi/message/info-zone")
 */
class InfoZonePublisherController extends PublisherControllerBase
{
    private function redirectToIndex(): Response
    {
        /** @var AdminUrlGenerator */
        $routeBuilder = $this->get(AdminUrlGenerator::class);
        return $this->redirect($routeBuilder->setController(InfoZoneMessageController::class)->generateUrl());
    }

    /**
     * @Route("/index", name="message_infozone_index")
     */
    public function index(): Response
    {
        return $this->render('message/info-zone.html.twig', [
            'messages' => $this->mRepo->findBy(array('type' => Message::TYPE_ZONE))
        ]);
    }

    private function createFromForm(InfoZoneCreationData $data, EntityManagerInterface $em, TranslatorInterface $trans): Message
    {
        $message = new Message();

        $message->setAuthor($trans->trans('zone') . ' ' . $data->getZone()->getName());
        $message->setType(Message::TYPE_ZONE);
        $message->setTag($data->getZone()->getId());
        $message->setTitle($data->getTitle());
        $message->setContent($data->getContent());
        $message->setPublished(new \DateTime());
        $em->persist($message);

        return $message;
    }

    private function updateFromEntity(InfoZoneCreationData $data, Message $message): void
    {
        $data->setTitle($message->getTitle());
        $data->setContent($message->getContent());
    }

    private function updateFromForm(Message $message, InfoZoneCreationData $data /*, EntityManagerInterface $em */): void
    {
        $message->setTitle($data->getTitle());
        $message->setContent($data->getContent());
    }

    /**
     * @Route("/create", name="message_infozone_create")
     */
    public function create(ZoneRepository $repo, Request $request, TranslatorInterface $trans)
    {
        $data = new InfoZoneCreationData();
        $form = $this->createForm(InfoZoneCreationForm::class, $data, array(
            'edit_mode' => false,
            'zones' => $repo->findAll())
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
        
        return $this->renderForm('message/info-zone_edit.html.twig', [
            'message' => null,
            'form' => $form,
            'errors' => $form->getErrors(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="message_infozone_edit")
     */
    public function edit(ZoneRepository $repo, int $id, Request $request)
    {
        $message = $this->mRepo->find($id);
        if (!$message) {
            return $this->redirectToIndex();
        }
        
        $data = new InfoZoneCreationData();
        $this->updateFromEntity($data, $message);
        $form = $this->createForm(InfoZoneCreationForm::class, $data, array(
            'edit_mode' => true,
            'zones' => $repo->findAll())
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
        
        return $this->renderForm('message/info-zone_edit.html.twig', [
            'message' => $message,
            'form' => $form,
            'errors' => $form->getErrors(),
        ]);
    }

    /**
     * @Route("/remove/{msg}", name="message_infozone_remove")
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
