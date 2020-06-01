<?php

namespace App\Service;

use App\Entity\Request;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class RequestEmailSender
{
    /**
     * @var MailerInterface
     */
    private MailerInterface $mailer;

    /**
     * @var string
     */
    private string $supportEmail;

    /**
     * @param MailerInterface $mailer
     * @param string $supportEmail
     */
    public function __construct(MailerInterface $mailer, string $supportEmail)
    {
        $this->mailer = $mailer;
        $this->supportEmail = $supportEmail;
    }

    /**
     * @param Request $request
     */
    public function sendRequestEmail(Request $request)
    {
        $email = (new TemplatedEmail())
            ->from($this->supportEmail)
            ->to($request->getCreator()->getEmail())
            ->subject('Your request has been successfully submitted!')
            ->htmlTemplate('email/new_request.html.twig')
            ->context([
                'request' => $request,
            ]);

        $this->mailer->send($email);
    }
}
