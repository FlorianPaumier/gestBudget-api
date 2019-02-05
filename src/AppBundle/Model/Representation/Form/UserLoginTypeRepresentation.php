<?php

namespace AppBundle\Model\Representation\Form;

use OpenApi\Annotations as OA;

/**
 * Class UserLoginTypeRepresentation
 * @package AppBundle\Model\Representation\Form
 *
 * @OA\Schema(
 *     required={
 *         "username",
 *         "password",
 *     }
 * )
 */
abstract class UserLoginTypeRepresentation
{
    /**
     * @var string
     * @OA\Property()
     */
    private $username;

    /**
     * @var string
     * @OA\Property()
     */
    private $password;
}