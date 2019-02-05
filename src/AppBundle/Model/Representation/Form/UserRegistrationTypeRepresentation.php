<?php

namespace AppBundle\Model\Representation\Form;

use OpenApi\Annotations as OA;

/**
 * Class UserRegistrationTypeRepresentation
 * @package AppBundle\Model\Representation\Form
 *
 * @OA\Schema(
 *     required={
 *         "username",
 *         "email",
 *         "plainPassword",
 *         "profile"
 *     }
 * )
 */
abstract class UserRegistrationTypeRepresentation
{
    /**
     * @var string
     * @OA\Property(example="usts")
     */
    private $username;

    /**
     * @var string
     * @OA\Property(format="email", example="contact@mail.fr")
     */
    private $email;

    /**
     * @var PasswordTypeRepresentation
     * @OA\Property()
     */
    private $plainPassword;

    /**
     * @var ProfileTypeRepresentation
     * @OA\Property()
     */
    private $profile;
}