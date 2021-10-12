<?php

namespace App\Controller\Publisher;

use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Adventurer;
use App\Entity\Message;
use App\Entity\MessageRecipient;
use App\Form\Message\EventCreationData;
use App\Form\Message\EventCreationForm;
use App\Repository\AdventurerRepository;

/**
 * @Route("/publi/message/event")
 */
class EventMessageController extends MessageControllerBase
{
    private function redirectToIndex(): Response
    {
        /** @var AdminUrlGenerator */
        $routeBuilder = $this->get(AdminUrlGenerator::class);
        return $this->redirect($routeBuilder->setController(EventMessageController::class)->generateUrl());
    }

    private function redirectToEdit(Message $message): Response
    {
        /** @var AdminUrlGenerator */
        $routeBuilder = $this->get(AdminUrlGenerator::class);
        return $this->redirect($routeBuilder->setRoute('message_event_edit', array('id' => $message->getId()))->generateUrl());
    }
    
    /**
     * @Route("/index", name="message_event_index")
     */
    public function index(): Response
    {
        $messages = $this->mRepo->findBy(array('type' => Message::TYPE_SPECIAL));
        
        return $this->render('message/event.html.twig', [
            'messages' => $messages,
        ]);
    }

    private function createFromForm(EventCreationData $data, EntityManagerInterface $em): Message
    {
        $message = new Message();

        $message->setAuthor($data->getPublisher() ?? '');
        $message->setType(Message::TYPE_SPECIAL);
        $message->setTitle($data->getTitle() ?? '');
        $message->setContent($data->getContent() ?? '');
        $message->setPublished(new \DateTime());
        $em->persist($message);

        foreach ($data->getRecipients() as $recipient) {
            if (!$recipient->getId()) {
                continue;
            }
            $messageRecipient = new MessageRecipient();
            $messageRecipient->setMessage($message);
            $messageRecipient->setRecipient($recipient);
            $messageRecipient->setOpened(false);
            $em->persist($messageRecipient);
        }

        return $message;
    }

    private function updateFromEntity(EventCreationData $data, Message $message): void
    {
        $data->setTitle($message->getTitle());
        $data->setPublisher($message->getAuthor());
        $data->setContent($message->getContent());
        foreach ($message->getRecipients() as $messageRecipient) {
            $data->addRecipient($messageRecipient->getRecipient());
        }
    }

    private function updateFromForm(Message $message, EventCreationData $data, EntityManagerInterface $em): void
    {
        $message->setTitle($data->getTitle() ?? '');
        $message->setAuthor($data->getPublisher() ?? '');
        $message->setContent($data->getContent() ?? '');

        foreach ($message->getRecipients() as $messageRecipientI) {
            $messageRecipientI->setMessage(null);
        }

        foreach ($data->getRecipients() as $recipient) {
            if (!$recipient->getId()) {
                continue;
            }
            $found = false;
            foreach ($message->getRecipients() as $messageRecipientI) {
                if ($messageRecipientI->getRecipient()->getId() == $recipient->getId()) {
                    $found = true;
                    $messageRecipientI->setMessage($message);
                    break;
                }
            }
            if (!$found) {
                $messageRecipient = new MessageRecipient();
                $messageRecipient->setMessage($message);
                $messageRecipient->setRecipient($recipient);
                $messageRecipient->setOpened(false);
                $em->persist($messageRecipient);
            }
        }

        foreach ($message->getRecipients() as $messageRecipientI) {
            if (!$messageRecipientI->getMessage()) {
                $message->removeRecipient($messageRecipientI);
                $em->remove($messageRecipientI);
            }
        }
    }

    /**
     * @Route("/create", name="message_event_create")
     */
    public function create(AdventurerRepository $advRepo, Request $request): Response
    {
        $data = new EventCreationData();
        $data->addRecipient(new Adventurer());
        $form = $this->createForm(EventCreationForm::class, $data, array(
            'edit_mode' => false,
            'allowed_adventurers' => $advRepo->findBy(array('controlType' => Adventurer::TYPE_PLAYER_MAIN)))
        );
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var EntityManagerInterface */
            $em = $this->getDoctrine()->getManager();
            try {
                $message = $this->createFromForm($form->getData(), $em);
                $em->flush();
                $this->addFlash('success', 'Message created');
                return $this->redirectToEdit($message);
            }
            catch (\Exception $e) {
                $this->addFlash('warning', 'Cannot add Message: ' . $e->getMessage());
            }
        }
        
        return $this->renderForm('message/event_edit.html.twig', [
            'message' => null,
            'form' => $form,
            'errors' => $form->getErrors(),
        ]);
    }
    
    /**
     * @Route("/edit/{id}", name="message_event_edit")
     */
    public function edit(AdventurerRepository $advRepo, int $id, Request $request): Response
    {
        $message = $this->mRepo->find($id);
        if (!$message) {
            return $this->redirectToIndex();
        }
        
        $data = new EventCreationData();
        $this->updateFromEntity($data, $message);
        if (!count($data->getRecipients())) {
            $data->addRecipient(new Adventurer());
        }
        $form = $this->createForm(EventCreationForm::class, $data, array(
            'edit_mode' => true,
            'allowed_adventurers' => $advRepo->findBy(array('controlType' => Adventurer::TYPE_PLAYER_MAIN)))
        );
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var EntityManagerInterface */
            $em = $this->getDoctrine()->getManager();
            try {
                $this->updateFromForm($message, $form->getData(), $em);
                $em->flush();
                $this->addFlash('success', 'Message updated');
            }
            catch (\Exception $e) {
                $this->addFlash('warning', 'Cannot edit Message: ' . $e->getMessage());
            }
        }
        
        return $this->renderForm('message/event_edit.html.twig', [
            'message' => $message,
            'form' => $form,
            'errors' => $form->getErrors(),
        ]);
    }

    /**
     * @Route("/remove/{msg}", name="message_event_remove")
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
