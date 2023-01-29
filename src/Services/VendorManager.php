<?php

namespace App\Services;

use App\Entity\Vendor;
use App\Repository\VendorRepository;
use Doctrine\Persistence\ManagerRegistry;

class VendorManager
{
    private $em;
    private $vendorRepository;

    public function __construct(
        VendorRepository $vendorRepository,
        ManagerRegistry $doctrine
    )
    {
        $this->em = $doctrine->getManager();
        $this->vendorRepository = $vendorRepository;
    }

    public function create(Vendor $vendor)
    {
        $this->em->persist($vendor);
        $this->em->flush();
    }

    public function edit(Vendor $vendor)
    {
        $this->em->flush();
    }

    public function delete(Vendor $vendor)
    {
        $this->em->remove($vendor);
        $this->em->flush();
    }

    public function validate(Vendor $vendor){
        $errors = [];

        if (empty($vendor->getName()) || empty($vendor->getEmail()) || empty($vendor->getPhone()) || empty($vendor->getType())){
            $errors['warning'] = "Todos los campos son obligatorios";
        }

        return $errors;
    }

}
