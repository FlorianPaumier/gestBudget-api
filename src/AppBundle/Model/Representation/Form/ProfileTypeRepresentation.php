<?php

namespace AppBundle\Model\Representation\Form;


use OpenApi\Annotations as OA;

/**
 * Class ProfileTypeRepresentation
 * @package AppBundle\Model\Representation\Form
 *
 * @OA\Schema(
 *     required={
 *         "firstName",
 *         "lastName",
 *         "birthDate",
 *         "phoneNumber",
 *         "address",
 *     }
 * )
 */
abstract class ProfileTypeRepresentation
{
    /**
     * @var string
     * @OA\Property(example="Guillaume")
     */
    private $firstName;

    /**
     * @var string
     * @OA\Property(example="Adam")
     */
    private $lastName;

    /**
     * @var DateTypeRepresentation
     * @OA\Property()
     */
    private $birthDate;

    /**
     * @var string
     * @OA\Property(example="01 23 45 67 89")
     */
    private $phoneNumber;

    /**
     * @var AddressTypeRepresentation
     * @OA\Property()
     */
    private $address;

    /**
     * @var TutorTypeRepresentation
     * @OA\Property()
     */
    private $tutor;
}