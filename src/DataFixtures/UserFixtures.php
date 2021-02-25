<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder) {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // insert a user 3
        $user = new User();
        $user->setPassword($this->passwordEncoder->encodePassword($user, '123456789'));
        $user->setFirstName("Ahmed");
        $user->setLastName("Amor");
        $user->setRoles(['ROLE_ADMIN']);
        $user->setAge(15);
        $user->setEmail("fumahanzo30@gmail.com");
        $manager->persist($user);

        // insert a user 2
        $user = new User();
        $user->setPassword($this->passwordEncoder->encodePassword($user, '123456789'));
        $user->setFirstName("Ahmed");
        $user->setLastName("Amor");
        $user->setRoles(['ROLE_USER']);
        $user->setAge(15);
        $user->setEmail("domdom@gmail.com");
        $manager->persist($user);
       

        $manager->flush();
    }
}
