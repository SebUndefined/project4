<?php

namespace SebUndefined\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Constraint;

/**
 * Ticket
 *
 * @ORM\Table(name="seb_ticket")
 * @ORM\Entity(repositoryClass="SebUndefined\ShopBundle\Repository\TicketRepository")
 */
class Ticket
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     * @Constraint\Length(min=2,
     *     minMessage="Le prénom doit comporter au moins deux caractères",
     *     max=255,
     *     maxMessage="Le prénom ne peux pas excéder 255 caractères")
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     * @Constraint\Length(min=2,
     *     minMessage="Le nom doit comporter au moins deux caractères",
     *     max=255,
     *     maxMessage="Le nom ne peux pas excéder 255 caractères")
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     * @Constraint\Country()
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=100)
     * @Constraint\Choice(
     *     choices = { "full", "half" },
     *     message = "Choisissez un type valide"
     * )
     */
    private $type;

    /**
     * @var \DateTime
     * @ORM\Column(name="day", type="date")
     * @Constraint\DateTime()
     */
    private $day;

    /**
     * @var bool
     *
     * @ORM\Column(name="discountTicket", type="boolean")
     */
    private $discountTicket;

    /**
     * @var float
     * @ORM\Column(name="price", type="float")
     * @Constraint\GreaterThan(0)
     */
    private $price;

    /**
     * @var \DateTime
     * @ORM\Column(name="birthDate", type="date")
     */
    private $birthDate;

    /**
     * @ORM\ManyToOne(targetEntity="SebUndefined\ShopBundle\Entity\OrderMuseum", inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderMuseum;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Ticket
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Ticket
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Ticket
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Ticket
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set day
     *
     * @param \DateTime $day
     *
     * @return Ticket
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return \DateTime
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set discountTicket
     *
     * @param boolean $discountTicket
     *
     * @return Ticket
     */
    public function setDiscountTicket($discountTicket)
    {
        $this->discountTicket = $discountTicket;

        return $this;
    }

    /**
     * Get discountTicket
     *
     * @return bool
     */
    public function getDiscountTicket()
    {
        return $this->discountTicket;
    }


    /**
     * Set price
     *
     * @param float $price
     *
     * @return Ticket
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return Ticket
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param OrderMuseum $orderMuseum
     * @return $this
     */
    public function setOrderMuseum(OrderMuseum $orderMuseum) {
        $this->orderMuseum = $orderMuseum;
        return $this;
    }

    /**
     * @return OrderMuseum
     */
    public function getOrderMuseum() {
        return $this->orderMuseum;
    }
}

