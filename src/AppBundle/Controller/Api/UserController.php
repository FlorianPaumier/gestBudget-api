<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\User;
use AppBundle\Form\UserRegistrationType;
use AppBundle\Model\Representation\PaginatedRepresentation;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends FOSRestController
{
    /**
     * @Rest\Get("/user")
     * @Rest\View(serializerGroups={"pagination", "user"}, statusCode=Response::HTTP_OK)
     * @OA\Get(
     *     path="/user",
     *     tags={"User"},
     *     @OA\Response(response="200", description="Successful operation",
     *          @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/User"))
     *     )
     * )
     */
    public function getUsersAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->createQueryBuilder('u');
        $paginatedUsers = $this->get('knp_paginator')->paginate($users);

        return PaginatedRepresentation::createFromPaginationInterface($paginatedUsers);
    }

    /**
     * @Rest\Get("/user/{userId}", requirements={"userId"="\d+"})
     * @Rest\View(serializerGroups={"user"}, statusCode=Response::HTTP_OK)
     * @ParamConverter("user", options={"id"="userId"})
     * @OA\Get(
     *     path="/user/{userId}",
     *     tags={"User"},
     *     @OA\Parameter(in="path", name="userId", description="Id of the user", required=true, @OA\Schema()),
     *     @OA\Response(response="200", description="Successful operation", @OA\JsonContent(ref="#/components/schemas/User")),
     *     @OA\Response(response="404", description="Resourne not found")
     * )
     */
    public function getUserAction(User $user = null)
    {
        if (null === $user) {
            return $this->errorUserNotFound();
        }

        return $user;
    }

    /**
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @Rest\Get("/user/current")
     * @Rest\View(serializerGroups={"user"}, statusCode=Response::HTTP_OK)
     * @OA\Get(
     *     path="/user/current",
     *     tags={"User"},
     *     @OA\Response(response="200", description="Successful operation", @OA\JsonContent(ref="#/components/schemas/User"))
     * )
     */
    public function getCurrentUserAction()
    {
        return $this->getUser();
    }

    /**
     * @Rest\Post(path="/register")
     * @Rest\View(serializerGroups={"user", "profile"}, statusCode=Response::HTTP_CREATED)
     * @OA\Post(
     *     path="/register",
     *     tags={"User"},
     *     description="Register a new user",
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/User")),
     *     @OA\Response(response="201", description="Resource created"),
     *     @OA\Response(response="400", description="Bad request")
     * )
     */
    public function postUserAction(Request $request)
    {
        //TODO: fix RequestBody documentation
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $eventDispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);
        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $this->createForm(UserRegistrationType::class, $user);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $event = new FormEvent($form, $request);
            $eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

            if ($event->getResponse()) {
                return $event->getResponse();
            }

            $userManager->updateUser($user);
            $message = $this->get('translator')->trans('registration.flash.user_created', [], 'FOSUserBundle');
            $token = $this->get('lexik_jwt_authentication.jwt_manager')->create($user);
            $response = new JsonResponse(['message' => $message, 'token' => $token], Response::HTTP_CREATED);

            $eventDispatcher->dispatch(
                FOSUserEvents::REGISTRATION_COMPLETED,
                new FilterUserResponseEvent($user, $request, $response)
            );

            return $response;
        }

        $event = new FormEvent($form, $request);
        $eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);

        return $form;
    }

    /**
     * @Rest\Delete("/user/{userId}", requirements={"id"="\d+"})
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @ParamConverter("user", options={"id"="userId"})
     * @OA\Delete(
     *     path="/user/{userId}",
     *     tags={"User"},
     *     @OA\Parameter(name="userId", in="path", description="Id of the user", required=true, @OA\Schema()),
     *     @OA\Response(response="204", description="Resource deleted"),
     *     @OA\Response(response="404", description="Resourne not found")
     * )
     */
    public function deleteUserAction(User $user = null)
    {
        if (null === $user) {
            return $this->errorUserNotFound();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return Response::HTTP_NO_CONTENT;
    }

    private function errorUserNotFound()
    {
        $code = Response::HTTP_NOT_FOUND;

        return JsonResponse::create(['code' => $code, 'message' => 'Not found'], $code);
    }
}
