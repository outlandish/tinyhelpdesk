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
        $this->createUser($manager, 'user_pass', [User::ROLE_USER], self::USER_REFERENCE);
        $this->createUser($manager, 'admin_pass', [User::ROLE_ADMIN]);
        $this->createUser($manager, 'support_pass', [User::ROLE_SUPPORT]);
        $this->createUser($manager, 'api_pass', [User::ROLE_API]);

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     * @param string $password
     * @param array $roles
     * @param string|null $reference
     */
    private function createUser(
        ObjectManager $manager,
        string $password,
        array $roles,
        ?string $reference = null
    ): void {
        $faker = FakerFactory::create();

        $user = new User();

        $user->setFirstName($faker->firstName);
        $user->setLastName($faker->lastName);
        $user->setEmail($faker->email);
        $user->setUsername($user->getEmail());
        $user->setRoles($roles);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $password));

        if ($reference !== null) {
            $this->addReference($reference, $user);
        }

        $manager->persist($user);
    }
}
