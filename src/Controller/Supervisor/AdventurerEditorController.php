<?php

namespace App\Controller\Supervisor;

use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Adventurer;
use App\Entity\AdventurerAttribute;
use App\Form\Editor\AdventurerCreationData;
use App\Form\Editor\AdventurerCreationForm;
use App\Form\Type\AttributeAndValueData;
use App\Repository\AdventurerRepository;
use App\Repository\TileRepository;

/**
 * @Route("/super/editor/adventurer")
 */
class AdventurerEditorController extends EditorControllerBase
{
    private $advRepo;
    private $tRepo;
    
    public function __construct(AdventurerRepository $advRepo, TileRepository $tRepo)
    {
        $this->advRepo = $advRepo;
        $this->tRepo = $tRepo;
    }
    
    private function redirectToIndex(): Response
    {
        /** @var AdminUrlGenerator */
        $routeBuilder = $this->get(AdminUrlGenerator::class);
        return $this->redirect($routeBuilder->setController(AdventurerEditorController::class)->generateUrl());
    }

    private function redirectToEdit(Adventurer $adventurer): Response
    {
        /** @var AdminUrlGenerator */
        $routeBuilder = $this->get(AdminUrlGenerator::class);
        return $this->redirect($routeBuilder->setRoute('editor_adventurer_edit', array('id' => $adventurer->getId()))->generateUrl());
    }
    
    /**
     * @Route("/index", name="editor_adventurer_index")
     */
    public function index(): Response
    {
        $listAuto = $this->advRepo->findBy(array('controlType' => Adventurer::TYPE_AUTOMATED));
        
        return $this->render('editor/adventurer.html.twig', [
            'list_adv' => $listAuto,
            'attribute_types' => AdventurerAttribute::getAttributeTypes(),
            'can_create' => true,
        ]);
    }

    /**
     * @Route("/pawns", name="editor_adventurer_pawns")
     */
    public function pawns(): Response
    {
        $listGM = $this->advRepo->findBy(array('controlType' => Adventurer::TYPE_GAMEMASTER));
        
        return $this->render('editor/adventurer.html.twig', [
            'list_adv' => $listGM,
            'attribute_types' => AdventurerAttribute::getAttributeTypes(),
            'can_create' => false,
        ]);
    }
    
    private function createFromForm(AdventurerCreationData $data, EntityManagerInterface $em): Adventurer
    {
        $adventurer = new Adventurer();

        $adventurer->setName($data->getName() ?? '');
        $adventurer->setControlType(Adventurer::TYPE_AUTOMATED);
        $tile = $this->tRepo->findBy(array('x' => $data->getX(), 'y' => $data->getY(), 'z' => $data->getZ()));
        if (!$tile) {
            throw new \Exception('Invalid tile coordinates');
        }
        $adventurer->setTile($tile[0]);
        $em->persist($adventurer);

        foreach ($data->getAttributes() as $attribute) {
            if (!$attribute->getAttribute() || !$attribute->getValue()) {
                continue;
            }
            $adventurerAttribute = new AdventurerAttribute();
            $adventurerAttribute->setAttribute($attribute->getAttribute());
            $adventurerAttribute->setValue($attribute->getValue());
            $adventurer->addAttribute($adventurerAttribute);
            $em->persist($adventurerAttribute);
        }

        return $adventurer;
    }

    private function updateFromEntity(AdventurerCreationData $data, Adventurer $adventurer): void
    {
        $data->setName($adventurer->getName());
        $data->setX($adventurer->getTile()->getX());
        $data->setY($adventurer->getTile()->getY());
        $data->setZ($adventurer->getTile()->getZ());
        foreach ($adventurer->getAttributes() as $attribute) {
            $attrAndVal = new AttributeAndValueData();
            $attrAndVal->setAttribute($attribute->getAttribute());
            $attrAndVal->setValue($attribute->getValue());
            $data->addAttribute($attrAndVal);
        }
    }

    private function updateFromForm(Adventurer $adventurer, AdventurerCreationData $data, EntityManagerInterface $em): void
    {
        $adventurer->setName($data->getName() ?? '');
        $tile = $this->tRepo->findBy(array('x' => $data->getX(), 'y' => $data->getY(), 'z' => $data->getZ()));
        if (!$tile) {
            throw new \Exception('Invalid tile coordinates');
        }
        $adventurer->setTile($tile[0]);

        foreach ($adventurer->getAttributes() as $attributeI) {
            $attributeI->setValue(0);
        }

        foreach ($data->getAttributes() as $attribute) {
            if (!$attribute->getAttribute()) {
                continue;
            }
            $found = false;
            foreach ($adventurer->getAttributes() as $attributeI) {
                if ($attributeI->getAttribute() == $attribute->getAttribute()) {
                    $found = true;
                    $attributeI->setValue($attribute->getValue());
                    break;
                }
            }
            if (!$found && $attribute->getValue()) {
                $adventurerAttribute = new AdventurerAttribute();
                $adventurerAttribute->setAttribute($attribute->getAttribute());
                $adventurerAttribute->setValue($attribute->getValue());
                $adventurer->addAttribute($adventurerAttribute);
                $em->persist($adventurerAttribute);
            }
        }

        foreach ($adventurer->getAttributes() as $attributeI) {
            if (!$attributeI->getValue()) {
                $adventurer->removeAttribute($attributeI);
                $em->remove($attributeI);
            }
        }
    }

    /**
     * @Route("/create", name="editor_adventurer_create")
     */
    public function create(Request $request): Response
    {
        $data = new AdventurerCreationData();
        $data->addAttribute(new AttributeAndValueData());
        $form = $this->createForm(AdventurerCreationForm::class, $data, array(
            'edit_mode' => false)
        );
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var EntityManagerInterface */
            $em = $this->getDoctrine()->getManager();
            try {
                $adventurer = $this->createFromForm($form->getData(), $em);
                $em->flush();
                $this->addFlash('success', 'Adventurer created');
                return $this->redirectToEdit($adventurer);
            }
            catch (\Exception $e) {
                $this->addFlash('warning', 'Cannot add Adventurer: ' . $e->getMessage());
            }
        }
        
        return $this->renderForm('editor/adventurer_edit.html.twig', [
            'adventurer' => null,
            'form' => $form,
            'errors' => $form->getErrors(),
        ]);
    }
    
    /**
     * @Route("/edit/{id}", name="editor_adventurer_edit")
     */
    public function edit(int $id, Request $request): Response
    {
        $adventurer = $this->advRepo->find($id);
        if (!$adventurer) {
            return $this->redirectToIndex();
        }
        
        $data = new AdventurerCreationData();
        $this->updateFromEntity($data, $adventurer);
        if (!count($data->getAttributes())) {
            $data->addAttribute(new AttributeAndValueData());
        }
        $form = $this->createForm(AdventurerCreationForm::class, $data, array(
            'edit_mode' => true)
        );
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var EntityManagerInterface */
            $em = $this->getDoctrine()->getManager();
            try {
                $this->updateFromForm($adventurer, $form->getData(), $em);
                $em->flush();
                $this->addFlash('success', 'Adventurer updated');
            }
            catch (\Exception $e) {
                $this->addFlash('warning', 'Cannot edit Adventurer: ' . $e->getMessage());
            }
        }
        
        return $this->renderForm('editor/adventurer_edit.html.twig', [
            'adventurer' => $adventurer,
            'form' => $form,
            'errors' => $form->getErrors(),
        ]);
    }
}
