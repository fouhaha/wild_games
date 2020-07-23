<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use Faker;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i< 10; $i++) {
            $user = new User();
            $user->setEmail('user'.$i.'@mail.com')
                ->setName($faker->firstName)
                ->setCoins(1000)
                ->setPassword($this->passwordEncoder->encodePassword($user, 'password'));
            $manager->persist($user);
        }

        $admin = new User();
        $admin->setEmail('admin@mail.com')
            ->setPassword($this->passwordEncoder->encodePassword($admin, 'adminpassword'))
            ->setRoles(["ROLE_ADMIN"])
            ->setCoins(1000000)
            ->setName('Franny');
        $manager->persist($admin);

        $manager->flush();
    }
}
