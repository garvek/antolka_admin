<?php

namespace App\Controller\Cartographer;

use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Entity\Region;
use App\Entity\Zone;
use App\Form\Cartographer\ZoneCreationData;
use App\Form\Cartographer\ZoneCreationForm;

/**
 * @Route("/mapper/carto/zone")
 */
class ZoneCartographerController extends CartographerControllerBase
{
    private function redirectToIndex(): Response
    {
        /** @var AdminUrlGenerator */
        $routeBuilder = $this->get(AdminUrlGenerator::class);
        return $this->redirect($routeBuilder->setController(ZoneCartographerController::class)->generateUrl());
    }

    private function redirectToRegionIndex($regionId)
    {
        /** @var AdminUrlGenerator */
        $routeBuilder = $this->get(AdminUrlGenerator::class);
        return $this->redirect($routeBuilder->setRoute('cartographer_zone_regionindex', array('id' => $regionId)));
    }

    /**
     * @Route("/index", name="cartographer_zone_index")
     */
    public function index(): Response
    {
        return $this->redirectToRegionIndex(1);
    }

    /**
     * @Route("/region/{id}", name="cartographer_zone_regionindex", defaults={"id":1})
     */
    public function regionIndex($id)
    {
        $region = $this->rRepo->find($id);

        return $this->render('carto/zone_regionindex.html.twig', [
            'region' => $region,
            'zones' => $this->zRepo->findBy(array('region' => $region)),
        ]);
    }

    private function createZoneFromForm(ZoneCreationData $data, EntityManagerInterface $em, TranslatorInterface $trans): Zone
    {
        $zone = new Zone();

        $zone->setName($data->getName());
        $zone->setRegion($data->getRegion());
        $em->persist($zone);

        return $zone;
    }

    private function updateZoneFromEntity(ZoneCreationData $data, Zone $zone): void
    {
        $data->setName($zone->getName());
        $data->setRegion($zone->getRegion());
    }

    private function updateZoneFromForm(Zone $zone, ZoneCreationData $data /*, EntityManagerInterface $em */): void
    {
        $zone->setName($zone->getName());
        $zone->setRegion($data->getRegion());
    }

    /**
     * @Route("/create/{region}", name="cartographer_zone_create")
     */
    public function create(Region $region, Request $request, TranslatorInterface $trans)
    {
        $data = new ZoneCreationData();
        $data->setRegion($region);
        $form = $this->createForm(ZoneCreationForm::class, $data, array(
            'edit_mode' => false,
            'regions' => $this->rRepo->findAll())
        );
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var EntityManagerInterface */
            $em = $this->getDoctrine()->getManager();
            try {
                $zone = $this->createZoneFromForm($form->getData(), $em, $trans);
                $em->flush();
                $this->addFlash('success', 'Zone created');
                return $this->redirectToRegionIndex($zone->getRegion()->getId());
            }
            catch (\Exception $e) {
                $this->addFlash('warning', 'Cannot add Zone: ' . $e->getMessage());
            }
        }
        
        return $this->renderForm('carto/zone_edit.html.twig', [
            'zone' => null,
            'form' => $form,
            'errors' => $form->getErrors(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="cartographer_zone_edit")
     */
    public function edit(int $id, Request $request)
    {
        $zone = $this->mRepo->find($id);
        if (!$zone) {
            return $this->redirectToIndex();
        }
        
        $data = new ZoneCreationData();
        $this->updateZoneFromEntity($data, $zone);
        $form = $this->createForm(ZoneCreationForm::class, $data, array(
            'edit_mode' => true,
            'regions' => $this->rRepo->findAll())
        );
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var EntityManagerInterface */
            $em = $this->getDoctrine()->getManager();
            try {
                $this->updateZoneFromForm($zone, $form->getData() /*, $em */);
                $em->flush();
                $this->addFlash('success', 'Zone updated');
            }
            catch (\Exception $e) {
                $this->addFlash('warning', 'Cannot edit Zone: ' . $e->getMessage());
            }
        }
        
        return $this->renderForm('carto/zone_edit.html.twig', [
            'zone' => $zone,
            'form' => $form,
            'errors' => $form->getErrors(),
        ]);
    }

    /**
     * @Route("/remove/{zone}", name="cartography_zone_remove")
     */
    public function remove(Zone $zone)
    {
        $regionId = $zone->getRegion()->getId();
        $em = $this->getDoctrine()->getManager();
        $em->remove($zone);
        $em->flush();
        $this->addFlash('success', 'Zone removed');
        return $this->redirectToRegionIndex($regionId);
    }
}
