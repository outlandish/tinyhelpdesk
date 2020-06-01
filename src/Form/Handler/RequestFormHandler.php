<?php

namespace App\Form\Handler;

use App\Entity\Request;
use App\Message\RequestMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Transport\AmqpExt\AmqpStamp;
use Symfony\Component\Security\Core\Security;

class RequestFormHandler
{
    /**
     * @var Security
     */
    private Security $security;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;

    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $bus;

    public function __construct(Security $security, EntityManagerInterface $manager, MessageBusInterface $bus)
    {
        $this->security = $security;
        $this->manager = $manager;
        $this->bus = $bus;
    }

    public function handle(FormInterface $form)
    {
        /**
         * @var $request Request
         */
        $request = $form->getData();
        $request->setCreator($this->security->getUser());

        $this->manager->persist($request);
        $this->manager->flush();

        $this->bus->dispatch(
            new RequestMessage($request->getId(), []),
            [new AmqpStamp('second')]
        );
    }
}