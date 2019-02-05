<?php

namespace AppBundle\Service;

use AppBundle\Entity\Application;
use AppBundle\Entity\Offer;
use AppBundle\Entity\Profile;
use AppBundle\Entity\User;
use Swift_Attachment;
use Swift_Mailer;
use Swift_Message;

class EmailApi
{
    private $mailer;
    private  $twig;
    private $confirmationEmailSent = false;

    /**
     * EmailApi constructor.
     * @param Swift_Mailer $mailer
     * @param \Twig_Environment $twig
     */
    public function __construct(Swift_Mailer $mailer, \Twig_Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendContactForm($senderMail,$civility, $firstName, $lastName,$tel,$type, $subject, $object, $message){
        $message = Swift_Message::newInstance()
            ->setSubject($object)
            ->setFrom($senderMail)
            ->setTo("bonjour@oncommencelundi.com", $senderMail)
            ->setContentType('text/html')
            ->setBody(
                $this->twig->render(
                // app/Resources/views/Emails/registration.html.twig
                    "Emails/contact.html.twig", array(
                        'civility' => $civility,
                        'firstName' => $firstName,
                        'lastName' => $lastName,
                        'tel' => $tel,
                        'type' => $type,
                        'subject' => $subject,
                        'message' => $message
                    )
                )
            );


        $email = $this->mailer->send($message);

        return $email;
    }

    /**
     * @param $user
     * @return null
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendConfirmation($user) {
        if ($this->confirmationEmailSent === true) {
            return ;
        }

        $message = (new \Swift_Message('[On commence lundi] Activation du compte'))
            ->setFrom('noreply@oncommencelundi.com', 'On Commence Lundi')
            ->setTo($user->getEmail())
            ->setBody(
                $this->twig->render(
                // app/Resources/views/Emails/registration.html.twig
                    'Emails/confirmation.html.twig',
                    array('user' => $user)
                ),
                'text/html'
            );


        $this->mailer->send($message);
        $this->confirmationEmailSent = true;
    }

    public function sendInvitation(string $mail, Profile $profile){
        $message = (new \Swift_Message('[On commence lundi] Invitation'))
            ->setFrom('noreply@oncommencelundi.com', 'On Commence Lundi')
            ->setTo($mail)
            ->setBody(
                $this->twig->render(
                // app/Resources/views/Emails/registration.html.twig
                    'Emails/invitation.html.twig', [
                        "firstName" => $profile->getFirstName(),
                        "lastName" => $profile->getLastName(),
                        "sponsor" => $profile->getSponsorCode()
                    ]
                ),
                'text/html'
            );


        $this->mailer->send($message);
    }

    public function sendProfileMaj(Profile $profile, $percent){
        $message = (new \Swift_Message('[ON COMMENCE LUNDI] Mise à jour de votre profil'))
            ->setFrom('noreply@oncommencelundi.com', 'On Commence Lundi')
            ->setTo($profile->getUser()->getEmail())
            ->setBody(
                $this->twig->render(
                // app/Resources/views/Emails/registration.html.twig
                    'Emails/profile_maj.html.twig',
                    array(
                        'FirstName' => $profile->getFirstName(),
                        'maj' => $profile->getUpdatedAt(),
                        'percent' => $percent
                    )
                ),
                'text/html'
            );


        $this->mailer->send($message);
    }

    public function sendProfileIncomplet(Profile $profile, $percent){
        $message = (new \Swift_Message('[On commence lundi] Vous devriez completer votre profil'))
            ->setFrom('noreply@oncommencelundi.com', 'On Commence Lundi')
            ->setTo($profile->getUser()->getEmail())
            ->setBody(
                $this->twig->render(
                // app/Resources/views/Emails/registration.html.twig
                    'Emails/profile_incomplet.html.twig',
                    array(
                        'FirstName' => $profile->getFirstName(),
                        'percent' => $percent
                    )
                ),
                'text/html'
            );


        $this->mailer->send($message);
    }

    public function sendConfirmationSuppression(Profile $profile){
        $message = (new \Swift_Message('[On commence lundi] Suppression de votre compte'))
            ->setFrom('noreply@oncommencelundi.com', 'On Commence Lundi')
            ->setTo($profile->getUser()->getEmail())
            ->setBody(
                $this->twig->render(
                // app/Resources/views/Emails/registration.html.twig
                    'Emails/suppression_confirmed.html.twig',
                    array(
                        'FirstName' => $profile->getFirstName()
                    )
                ),
                'text/html'
            );


        $this->mailer->send($message);
    }

}