<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail("salomejoinnet@hotmail.fr")
            ->setRoles(["ROLE_ADMIN"])
            ->setFirstname('Salome')
            ->setLastname('Joinnet')
            ->setStreet('626 Avenue du colonel Fabien')
            ->setPostal('77190')
            ->setCity('Dammarie-les-Lys')
            ->setCountry('France');
        $user->setPassword($this->passwordEncoder->encodePassword($user,'Charlie77'));
        $manager->persist($user);

        $user = new User();
        $user->setEmail("inscrit@hotmail.fr")
            ->setRoles(["ROLE_USER"])
            ->setFirstname('inscrit')
            ->setLastname('inscrit')
            ->setStreet('627 Avenue du colonel Fabien')
            ->setPostal('77190')
            ->setCity('Dammarie-les-Lys')
            ->setCountry('France');
        $user->setPassword($this->passwordEncoder->encodePassword($user,'mdp'));
        $manager->persist($user);


        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
