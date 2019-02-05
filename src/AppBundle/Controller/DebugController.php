<?php

namespace AppBundle\Controller;

use AppBundle\Entity\City;
use AppBundle\Entity\Profile;
use AppBundle\Entity\School;
use AppBundle\Entity\User;
use AppBundle\Form\CityType;
use AppBundle\Form\ProfileType;
use AppBundle\Form\SchoolType;
use AppBundle\Form\UserRegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DebugController extends Controller
{
    /**
     * Use this function to test out stuff
     *
     * @Route(path="/form")
     *
     */
    public function debugFormAction(Request $request)
    {
        $entity = new Profile();
        $form = $this->createForm(ProfileType::class, $entity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($entity);
        }

        return $this->render(':default:debug_form.html.twig', ['form' => $form->createView()]);
    }
}
