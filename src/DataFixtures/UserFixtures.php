<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker\Factory as FakerFactory;

class UserFixtures extends Fixture
{
    public const USER_REFERENCE = 'user-reference';

    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = FakerFactory::create();

        $user = new User();
        $user->setFirstName($faker->firstName);
        $user->setLastName($faker->lastName);
        $user->setEmail($faker->email);
        $user->setUsername($user->getEmail());
        $user->setRoles([User::ROLE_USER]);
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'user_pass'));

        $this->addReference(self::USER_REFERENCE, $user);

        $manager->persist($user);

        $adminUser = new User();
        $adminUser->setFirstName($faker->firstName);
        $adminUser->setLastName($faker->lastName);
        $adminUser->setEmail($faker->email);
        $adminUser->setUsername($adminUser->getEmail());
        $adminUser->setRoles([User::ROLE_ADMIN]);
        $adminUser->setPassword($this->passwordEncoder->encodePassword($user, 'admin_pass'));

        $manager->persist($adminUser);

        $supportUser = new User();
        $supportUser->setFirstName($faker->firstName);
        $supportUser->setLastName($faker->lastName);
        $supportUser->setEmail($faker->email);
        $supportUser->setUsername($supportUser->getEmail());
        $supportUser->setRoles([User::ROLE_SUPPORT]);
        $supportUser->setPassword($this->passwordEncoder->encodePassword($user, 'support_pass'));

        $manager->persist($supportUser);

        $manager->flush();
    }
}
