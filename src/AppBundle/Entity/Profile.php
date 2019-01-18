<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Profile
 *
 * @JMS\ExclusionPolicy("all")
 * @OA\Schema()
 * @ORM\Table(name="profile")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProfileRepository")
 */
class Profile
{
    /**
     * @var int
     * @OA\Property()
     * @JMS\Expose()
     * @JMS\Groups({"profile"})
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * The first name of the user
     *
     * @var string
     * @OA\Property()
     * @JMS\Expose()
     * @JMS\Groups({"profile"})
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     */
    private $firstName;

    /**
     * The last name of the user
     *
     * @var string
     * @OA\Property()
     * @JMS\Expose()
     * @JMS\Groups({"profile"})
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     */
    private $lastName;

    /**
     * The date of birth of the user
     *
     * @var \DateTime
     * @OA\Property(type="object")
     * @JMS\Expose()
     * @JMS\Groups({"profile"})
     * @Assert\NotBlank()
     * @ORM\Column(type="date")
     */
    private $birthDate;

    /**
     * The phone number of the user
     *
     * @var string
     * @OA\Property()
     * @JMS\Expose()
     * @JMS\Groups({"profile"})
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     */
    private $phoneNumber;

    /**
     * @var User
     * @OA\Property(type="object", ref="#/components/schemas/User")
     * @JMS\Expose()
     * @JMS\Groups({"profile"})
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User", inversedBy="profile")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

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
     * Set firstName.
     *
     * @param string $firstName
     *
     * @return Profile
     */
    public function setFirstName($firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName.
     *
     * @return string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * Set lastName.
     *
     * @param string $lastName
     *
     * @return Profile
     */
    public function setLastName($lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName.
     *
     * @return string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * Set birthDate.
     *
     * @param \DateTime $birthDate
     *
     * @return Profile
     */
    public function setBirthDate($birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate.
     *
     * @return \DateTime
     */
    public function getBirthDate(): ?\DateTime
    {
        return $this->birthDate;
    }

    /**
     * Set phoneNumber.
     *
     * @param string $phoneNumber
     *
     * @return Profile
     */
    public function setPhoneNumber($phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber.
     *
     * @return string
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * Set user.
     *
     * @param User|null $user
     *
     * @return Profile
     */
    public function setUser(User $user = null): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @return Address
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    /**
     * @param Address $address
     * @return Profile
     */
    public function setAddress(Address $address): self
    {
        $this->address = $address;

        return $this;
    }
}
