<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Company;
use AppBundle\Entity\MilesProfile;
use AppBundle\Entity\Profile;
use AppBundle\Entity\ProfileApplicant;
use AppBundle\Entity\ProfileRecruiter;
use AppBundle\Entity\User;
use AppBundle\Service\EmailApi;
use AppBundle\Service\MilesService;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Listener responsible to change the redirection at the end of the password resetting
 */
class RegistrationListener implements EventSubscriberInterface
{
    private $router;
    private $em;
    private $emailConfirmed = false;
    protected $mailer;
    protected $twig;
    protected $emailApi;
    protected $milesService;

    public function __construct(UrlGeneratorInterface $router,
                                EntityManagerInterface $em,
                                \Twig_Environment $twig,
                                \Swift_Mailer $mailer,
                                EmailApi $emailApi){
        $this->twig = $twig;
        $this->router = $router;
        $this->mailer = $mailer;
        $this->emailApi = $emailApi;
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess',
            FOSUserEvents::REGISTRATION_CONFIRMED => 'onRegistrationConfirmed'
        );
    }

    public function onRegistrationConfirmed(\FOS\UserBundle\Event\FilterUserResponseEvent $event)
    {
        /** @var User $user */
        $user = $event->getUser();

        if (!$this->emailConfirmed) {
            $this->emailApi->sendConfirmation($user);
            $this->emailConfirmed = true;
        }


    }

    public function onRegistrationSuccess(FormEvent $event)
    {
    }

    static public function generateRandomSponsorCode(EntityManagerInterface $em)
    {
        $repeat = true;

        while ($repeat) {
            $code = substr(strtoupper(str_shuffle(md5(uniqid()))), 0, 12);
            if (null === $em->getRepository(Profile::class)->findOneBy(['sponsorCode' => $code])) {
                $repeat = false;
            }
        }

        return $code;
    }
}