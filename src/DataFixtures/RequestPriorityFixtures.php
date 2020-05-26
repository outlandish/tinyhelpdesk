<?php

namespace App\DataFixtures;

use App\Entity\Request;
use App\Entity\RequestPriority;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RequestPriorityFixtures extends Fixture
{
    public const LOW_PRIORITY = 'priority-low';

    public function load(ObjectManager $manager)
    {
        $priorityHandles = [
            RequestPriority::CRITICAL,
            RequestPriority::LOW,
            RequestPriority::TRIVIAL,
            RequestPriority::HIGH,
        ];

        foreach ($priorityHandles as $handle) {
            $priority = new RequestPriority();
            $priority->setHandle($handle);
            $priority->setName(ucfirst(strtolower($handle)));

            if ($handle === RequestPriority::LOW) {
                $this->addReference(self::LOW_PRIORITY, $priority);
            }

            $manager->persist($priority);
        }

        $manager->flush();
    }
}