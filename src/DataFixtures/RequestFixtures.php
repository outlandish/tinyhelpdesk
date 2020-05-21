<?php

namespace App\DataFixtures;

use App\Entity\Request;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RequestFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 20; $i++) {
            $request = new Request();
            $request->setTitle('Request #' . $i);
            $request->setText('Hello! I have an issue with my PC');
            $request->setCreator($this->getReference(UserFixtures::USER_REFERENCE));

            $manager->persist($request);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }

}