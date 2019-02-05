<?php

namespace AppBundle\Model;

use AppBundle\Entity\Profile;
use FOS\UserBundle\Model\User as BaseUser;
use JMS\Serializer\Annotation as JMS;
use OpenApi\Annotations as OA;

/**
 * User
 *
 * @JMS\ExclusionPolicy("all")
 *
 * @OA\Schema()
 */
abstract class User extends BaseUser
{
    /**
     * @OA\Property(type="integer")
     * @JMS\Expose()
     * @JMS\Groups({"user", "user_light", "user_public"})
     *
     * {@inheritdoc}
     */
    protected $id;

    /**
     * @OA\Property(type="string")
     * @JMS\Expose()
     * @JMS\Groups({"user", "user_light", "user_public"})
     *
     * {@inheritdoc}
     */
    protected $username;

    /**
     * @OA\Property(type="string")
     * @JMS\Expose()
     * @JMS\Groups({"user", "user_light"})
     *
     * {@inheritdoc}
     */
    protected $email;

    /**
     * @OA\Property(type="boolean")
     * @JMS\Expose()
     * @JMS\Groups({"user"})
     *
     * {@inheritdoc}
     */
    protected $enabled;

    /**
     * @OA\Property(type="object")
     * @JMS\Expose()
     * @JMS\Groups({"user"})
     *
     * {@inheritdoc}
     */
    protected $lastLogin;

    /**
     * @OA\Property(type="array", @OA\Items())
     * @JMS\Expose()
     * @JMS\Groups({"user"})
     *
     * {@inheritdoc}
     */
    protected $groups;

    /**
     * @OA\Property(type="array", @OA\Items())
     * @JMS\Expose()
     * @JMS\Groups({"user"})
     *
     * {@inheritdoc}
     */
    protected $roles;

    /**
     * @var Profile
     * @JMS\Expose()
     * @JMS\Groups({"user"})
     * @OA\Property()
     */
    protected $profile;
}