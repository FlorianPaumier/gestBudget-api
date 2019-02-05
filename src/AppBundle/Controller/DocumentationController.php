<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DocumentationController extends Controller
{
    /**
     * @Route(path="/")
     */
    public function homepageAction()
    {
        return $this->redirectToRoute('app_documentation_index');
    }


    /**
     * @Route(path="/doc.json")
     */
    public function jsonDocAction()
    {
        $openapi = \OpenApi\scan($this->getParameter('kernel.project_dir').'/src');

        return JsonResponse::create($openapi);
    }

    /**
     * @Route(path="/doc")
     */
    public function indexAction()
    {
        return $this->render('@App/doc.html.twig');
    }
}
