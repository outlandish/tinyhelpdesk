<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    public const USER_REFERENCE = 'user-reference';

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setFirstName('Massimo');
        $user->setLastName('User');
        $user->setEmail('rizzoni@tinyhelpdesk.com');
        $user->setUsername('rizzoni@tinyhelpdesk.com');
        $user->setRoles([User::ROLE_USER]);
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'user_pass'));

        $this->addReference(self::USER_REFERENCE, $user);

        $manager->persist($user);

        $adminUser = new User();

        $adminUser->setFirstName('John');
        $adminUser->setLastName('Admin');
        $adminUser->setEmail('johnadmin@tinyhelpdesk.com');
        $adminUser->setUsername('johnadmin@tinyhelpdesk.com');
        $adminUser->setRoles([User::ROLE_ADMIN]);
        $adminUser->setPassword($this->passwordEncoder->encodePassword($user, 'admin_pass'));

        $manager->persist($adminUser);

        $supportUser = new User();

        $supportUser->setFirstName('Bob');
        $supportUser->setLastName('Support');
        $supportUser->setEmail('bobsupport@tinyhelpdesk.com');
        $supportUser->setUsername('bobsupport@tinyhelpdesk.com');
        $supportUser->setRoles([User::ROLE_SUPPORT]);
        $supportUser->setPassword($this->passwordEncoder->encodePassword($user, 'support_pass'));

        $manager->persist($supportUser);

        $manager->flush();
    }
}
