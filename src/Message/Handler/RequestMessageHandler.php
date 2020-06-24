<?php

namespace App\Message\Handler;

use App\Entity\Request;
use App\Message\RequestMessage;
use App\Repository\RequestRepository;
use App\Service\RequestEmailSender;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class RequestMessageHandler implements MessageHandlerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var RequestRepository
     */
    private RequestRepository $requestRepository;

    /**
     * @var RequestEmailSender
     */
    private RequestEmailSender $emailSender;

    /**
     * @param EntityManagerInterface $entityManager
     * @param RequestRepository $commentRepository
     * @param RequestEmailSender $emailSender
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        RequestRepository $commentRepository,
        RequestEmailSender $emailSender
    )
    {
        $this->entityManager = $entityManager;
        $this->requestRepository = $commentRepository;
        $this->emailSender = $emailSender;
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

        $this->emailSender->sendRequestEmail($request);
    }
}
