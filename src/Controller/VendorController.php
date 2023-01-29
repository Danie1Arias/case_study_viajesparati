<?php

namespace App\Controller;

use App\Entity\Vendor;
use App\Repository\VendorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VendorController extends AbstractController
{
    #[Route('/', name: 'app_list_vendor')]
    public function list(VendorRepository $vendorRepository): Response
    {
        $vendors = $vendorRepository->findAll();
        return $this->render('vendor/list.html.twig', [
            'vendors' => $vendors,
        ]);
    }

    #[Route('/vendor/add', name: 'app_add_vendor')]
    public function add(Request $request, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $vendor = new Vendor();
        $name = $request->request->get('name', null);
        $email = $request->request->get('email', null);
        $phone = $request->request->get('phone', null);
        $type = $request->request->get('type', null);
        $active = $request->request->get('active', 0);
        $start_date = new \DateTime();
        $update_date = new \DateTime();

        if (null !== $name &&
            null !== $email &&
            null !== $phone &&
            null !== $type){

            if(!empty($name)){
                $vendor->setName($name);
                $vendor->setEmail($email);
                $vendor->setPhone($phone);
                $vendor->setType($type);
                $vendor->setActive($active);
                $vendor->setStartDate($start_date);
                $vendor->setUpdateDate($update_date);

                $em->persist($vendor);
                $em->flush();
                $this->addFlash('success', "Proveedor creado correctamente");

                return $this->redirectToRoute('app_list_vendor');

            } else {
                $this->addFlash('warning', "Todos los campos son obligatorios");

                return $this->redirectToRoute('app_add_vendor');
            }
        }
        return $this->render('vendor/add.html.twig', [
            'vendor' => $vendor,
        ]);
    }

    #[Route('/vendor/edit/{id}', name: 'app_edit_vendor')]
    public function edit(Vendor $vendor, VendorRepository $vendorRepository, Request $request, ManagerRegistry $doctrine): Response
    {
        $name = $request->request->get('name', null);
        $email = $request->request->get('email', null);
        $phone = $request->request->get('phone', null);
        $type = $request->request->get('type', null);
        $active = $request->request->get('active', 0);

        if (null !== $name && null !== $email && null !== $phone && null !== $type){

            if(!empty($name) && !empty($email) && !empty($phone) && !empty($type)){
                $em = $doctrine->getManager();

                $vendor->setName($name);
                $vendor->setEmail($email);
                $vendor->setPhone($phone);
                $vendor->setType($type);
                $vendor->setActive($active);
                $vendor->setUpdateDate(new \DateTime());

                $em->flush();
                $this->addFlash('success', "Proveedor editado correctamente");

                return $this->redirectToRoute('app_list_vendor');

            } else {
                $this->addFlash('warning', "Todos los campos son obligatorios");
            }
        }
        return $this->render('vendor/edit.html.twig', [
            'vendor' => $vendor,
        ]);
    }

    #[Route('/vendor/delete/{id}', name: 'app_delete_vendor')]
    public function delete(int $id): Response
    {
        return $this->render('vendor/delete.html.twig', [
            'controller_name' => 'VendorController',
        ]);
    }
}
