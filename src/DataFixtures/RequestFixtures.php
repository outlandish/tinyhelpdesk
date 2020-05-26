<?php

namespace App\DataFixtures;

use App\Entity\Request;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;

class RequestFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = FakerFactory::create();

        for ($i = 1; $i < 20; $i++) {
            $request = new Request();
            $request->setTitle($faker->sentence($nbWords = 6, $variableNbWords = true));
            $request->setText($faker->text($maxNbChars = 200) );
            $request->setCreator($this->getReference(UserFixtures::USER_REFERENCE));
            $request->setPriority($this->getReference(RequestPriorityFixtures::LOW_PRIORITY));

            $manager->persist($request);
        }

        $manager->flush();
    }

    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            RequestPriorityFixtures::class,
        ];
    }
}