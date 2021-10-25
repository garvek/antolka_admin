<?php

namespace App\Controller\Publisher;

use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Entity\Message;
use App\Form\Message\NotificationCreationData;
use App\Form\Message\NotificationCreationForm;

/**
 * @Route("/publi/message/news")
 */
class NewsPublisherController extends PublisherControllerBase
{
    private function redirectToIndex(): Response
    {
        /** @var AdminUrlGenerator */
        $routeBuilder = $this->get(AdminUrlGenerator::class);
        return $this->redirect($routeBuilder->setController(NewsMessageController::class)->generateUrl());
    }

    /**
     * @Route("/index", name="message_news_index")
     */
    public function index(): Response
    {
        return $this->render('message/news.html.twig', [
            'messages' => $this->mRepo->findBy(array('type' => Message::TYPE_GLOBAL))
        ]);
    }

    private function createFromForm(NotificationCreationData $data, EntityManagerInterface $em, TranslatorInterface $trans): Message
    {
        $message = new Message();

        $message->setAuthor($trans->trans('system'));
        $message->setType(Message::TYPE_GLOBAL);
        $message->setTitle($data->getTitle());
        $message->setContent($data->getContent());
        $message->setPublished(new \DateTime());
        $em->persist($message);

        return $message;
    }

    private function updateFromEntity(NotificationCreationData $data, Message $message): void
    {
        $data->setTitle($message->getTitle());
        $data->setContent($message->getContent());
    }

    private function updateFromForm(Message $message, NotificationCreationData $data /*, EntityManagerInterface $em */): void
    {
        $message->setTitle($data->getTitle());
        $message->setContent($data->getContent());
    }

    /**
     * @Route("/create", name="message_news_create")
     */
    public function create(Request $request, TranslatorInterface $trans)
    {
        $data = new NotificationCreationData();
        $form = $this->createForm(NotificationCreationForm::class, $data, array(
            'edit_mode' => false)
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
        
        return $this->renderForm('message/news_edit.html.twig', [
            'message' => null,
            'form' => $form,
            'errors' => $form->getErrors(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="message_news_edit")
     */
    public function edit(int $id, Request $request)
    {
        $message = $this->mRepo->find($id);
        if (!$message) {
            return $this->redirectToIndex();
        }
        
        $data = new NotificationCreationData();
        $this->updateFromEntity($data, $message);
        $form = $this->createForm(NotificationCreationForm::class, $data, array(
            'edit_mode' => true)
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
        
        return $this->renderForm('message/news_edit.html.twig', [
            'message' => $message,
            'form' => $form,
            'errors' => $form->getErrors(),
        ]);
    }

    /**
     * @Route("/remove/{msg}", name="message_news_remove")
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
