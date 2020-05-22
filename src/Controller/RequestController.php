<?php

namespace App\Controller;

use App\Entity\Request;
use App\Form\DataClass\RequestSearchDataClass;
use App\Service\RequestSearchProcessor;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use App\Form\Type\RequestSearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\User;

class RequestController extends AbstractController
{
    /**
     * @param EntityManagerInterface $manager
     *
     * @Route("/my-requests", name="app_my_requests")
     * @IsGranted(User::ROLE_USER)
     *
     * @return Response
     */
    public function myRequests(EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();

        if ($this->isGranted([User::ROLE_SUPPORT])) {
            $requests = $manager->getRepository(Request::class)->findByAssignee($user);
        } else {
            $requests = $manager->getRepository(Request::class)->findByCreator($user);
        }

        return $this->render(
            'request/my_requests.html.twig',
            [
                'requests' => $requests,
            ]
        );
    }

    /**
     * @param RequestSearchProcessor $requestSearchProcessor
     * @param HttpRequest $request
     *
     * @Route("/requests", name="app_requests")
     * @IsGranted(User::ROLE_SUPPORT)
     *
     * @return Response
     */
    public function allRequests(HttpRequest $request, RequestSearchProcessor $requestSearchProcessor): Response
    {
        $form = $this->createForm(RequestSearchType::class)->handleRequest($request);

        /**
         * @var $searchDataClass RequestSearchDataClass
         */
        $searchDataClass = $form->getData();
        $searchResult = $requestSearchProcessor->getResult($searchDataClass);

        return $this->render(
            'request/requests.html.twig',
            [
                'requestsPagination' => array_merge($searchResult, ['page' => $searchDataClass->getPage()]),
                'form' => $form->createView(),
            ]
        );
    }
}