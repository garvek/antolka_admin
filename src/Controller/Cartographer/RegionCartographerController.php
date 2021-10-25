<?php

namespace App\Controller\Cartographer;

use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Entity\Region;
use App\Form\Cartographer\RegionCreationData;
use App\Form\Cartographer\RegionCreationForm;

/**
 * @Route("/mapper/carto/region")
 */
class RegionCartographerController extends CartographerControllerBase
{
    private function redirectToIndex(): Response
    {
        /** @var AdminUrlGenerator */
        $routeBuilder = $this->get(AdminUrlGenerator::class);
        return $this->redirect($routeBuilder->setController(RegionCartographerController::class)->generateUrl());
    }

    /**
     * @Route("/index", name="cartographer_region_index")
     */
    public function index(): Response
    {
        return $this->render('carto/region.html.twig', [
            'regions' => $this->rRepo->findAll(),
        ]);
    }

    private function createRegionFromForm(RegionCreationData $data, EntityManagerInterface $em, TranslatorInterface $trans): Region
    {
        $region = new Region();

        $region->setName($data->getName());
        $em->persist($region);

        return $region;
    }

    private function updateRegionFromEntity(RegionCreationData $data, Region $region): void
    {
        $data->setName($region->getName());
    }

    private function updateRegionFromForm(Region $region, RegionCreationData $data /*, EntityManagerInterface $em */): void
    {
        $region->setName($region->getName());
    }

    /**
     * @Route("/create", name="cartographer_region_create")
     */
    public function createRegion(Request $request, TranslatorInterface $trans)
    {
        $data = new RegionCreationData();
        $form = $this->createForm(RegionCreationForm::class, $data, array(
            'edit_mode' => false)
        );
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var EntityManagerInterface */
            $em = $this->getDoctrine()->getManager();
            try {
                $message = $this->createRegionFromForm($form->getData(), $em, $trans);
                $em->flush();
                $this->addFlash('success', 'Region created');
                return $this->redirectToIndex();
            }
            catch (\Exception $e) {
                $this->addFlash('warning', 'Cannot add Region: ' . $e->getMessage());
            }
        }
        
        return $this->renderForm('carto/region_edit.html.twig', [
            'region' => null,
            'form' => $form,
            'errors' => $form->getErrors(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="cartographer_region_edit")
     */
    public function edit(int $id, Request $request)
    {
        $region = $this->rRepo->find($id);
        if (!$region) {
            return $this->redirectToIndex();
        }
        
        $data = new RegionCreationData();
        $this->updateRegionFromEntity($data, $region);
        $form = $this->createForm(RegionCreationForm::class, $data, array(
            'edit_mode' => true)
        );
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var EntityManagerInterface */
            $em = $this->getDoctrine()->getManager();
            try {
                $this->updateRegionFromForm($region, $form->getData() /*, $em */);
                $em->flush();
                $this->addFlash('success', 'Region updated');
            }
            catch (\Exception $e) {
                $this->addFlash('warning', 'Cannot edit Region: ' . $e->getMessage());
            }
        }
        
        return $this->renderForm('carto/region_edit.html.twig', [
            'region' => $region,
            'form' => $form,
            'errors' => $form->getErrors(),
        ]);
    }

    /**
     * @Route("/remove/{msg}", name="cartographer_region_remove")
     */
    public function remove(Region $region)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($region);
        $em->flush();
        $this->addFlash('success', 'Region removed');
        return $this->redirectToIndex();
    }
}
