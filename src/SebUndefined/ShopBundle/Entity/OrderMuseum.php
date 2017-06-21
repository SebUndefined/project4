<?php

namespace SebUndefined\ShopBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * OrderMuseum
 *
 * @ORM\Table(name="seb_order_museum")
 * @ORM\Entity(repositoryClass="SebUndefined\ShopBundle\Repository\OrderMuseumRepository")
 */
class OrderMuseum
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity="SebUndefined\ShopBundle\Entity\Ticket", mappedBy="orderMuseum", cascade="all")
     */
    private $tickets;

    public function __construct()
    {
        $this->date = new  \DateTime();
        $this->tickets = new ArrayCollection();
    }

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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return OrderMuseum
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return OrderMuseum
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

    public function addTicket(Ticket $ticket) {
        $this->tickets[] = $ticket;
    }
    public function removeTicket(Ticket $ticket) {
        $this->tickets->removeElement($ticket);
    }
    public function getTickets() {
        return $this->tickets;
    }
}

