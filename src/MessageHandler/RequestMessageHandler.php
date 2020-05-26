<?php

namespace App\MessageHandler;

use App\Entity\Request;
use App\Message\RequestMessage;
use App\Repository\RequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class RequestMessageHandler implements MessageHandlerInterface
{
    private $entityManager;
    private $requestRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        RequestRepository $commentRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->requestRepository = $commentRepository;
    }

    public function __invoke(RequestMessage $message)
    {
        /**
         * @var $request Request
         */
        $request = $this->requestRepository->find($message->getId());

        if (!$request) {
            return;
        }

        $request->setText('Rabbit!');

        $this->entityManager->flush();
    }
}