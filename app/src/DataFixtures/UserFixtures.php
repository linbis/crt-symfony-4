<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Создание пользователя admin
 */
class UserFixtures extends Fixture
{
    private $encoder;

    /**
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        // create admin
        $user = new User();
        $user->setName('admin');
        $user->setEmail('admin@mail.ru');
        $user->setRoles(['ROLE_ADMIN']);

        $password = $this->encoder->encodePassword($user, 'nimda');
        $user->setPassword($password);

        $manager->persist($user);

        // create manager
        $userManager = new User();
        $userManager->setName('customer');
        $userManager->setEmail('customer@mail.ru');
        $userManager->setRoles(['ROLE_USER']);

        $password = $this->encoder->encodePassword($userManager, 'nimda');
        $userManager->setPassword($password);

        $manager->persist($userManager);

        $manager->flush();
    }
}
