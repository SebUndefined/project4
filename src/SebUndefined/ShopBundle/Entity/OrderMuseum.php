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
     * @ORM\Column(name="id", type="string")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="SebUndefined\ShopBundle\Doctrine\RandomIdGenerator")
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
     * @return bool
     */
    public function isComplete()
    {
        return $this->complete;
    }


    /**
     * @var boolean
     *
     * @ORM\Column(name="complete", type="boolean")
     */
    private $complete;
    /**
     * @ORM\OneToMany(targetEntity="SebUndefined\ShopBundle\Entity\Ticket", mappedBy="orderMuseum", cascade="all")
     */
    private $tickets;

    public function __construct()
    {
        $this->complete = false;
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
     * @return bool
     */
    public function getComplete() {
        return $this->complete;
    }
    /**
     * @param bool $complete
     */
    public function setComplete($complete)
    {
        $this->complete = $complete;
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
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        $price=0;
        foreach ($this->getTickets() as $ticket) {
            $price += $ticket->getPrice();
        }
        return $price;
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

