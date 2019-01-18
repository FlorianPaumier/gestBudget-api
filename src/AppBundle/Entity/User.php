<?php

namespace AppBundle\Entity;

use AppBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="person")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @UniqueEntity("username")
 * @UniqueEntity("email")
 */
class User extends BaseUser
{
    /**
     * @var int
     * @JMS\Expose()
     * @JMS\Groups({"user", "user_light", "user_public"})
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Profile
     * @JMS\Expose()
     * @JMS\Groups({"user"})
     * @Assert\Valid()
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Profile", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $profile;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get profile.
     *
     * @return \AppBundle\Entity\Profile
     */
    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    /**
     * Set profile.
     *
     * @param \AppBundle\Entity\Profile $profile
     *
     * @return User
     */
    public function setProfile(Profile $profile): self
    {
        $this->profile = $profile;
        $profile->setUser($this);

        return $this;
    }
}
