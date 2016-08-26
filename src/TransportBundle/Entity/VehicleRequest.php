<?php

namespace TransportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VehicleRequest
 *
 * @ORM\Table(name="vehicle_request")
 * @ORM\Entity(repositoryClass="TransportBundle\Repository\VehicleRequestRepository")
 */
class VehicleRequest
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
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="requests")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="numberOfVehicles", type="smallint")
     */
    private $numberOfVehicles;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;
    

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
     * Set category
     *
     * @param \stdClass $category
     *
     * @return VehicleRequest
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \stdClass
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return VehicleRequest
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
     * Set numberOfVehicles
     *
     * @param integer $numberOfVehicles
     *
     * @return VehicleRequest
     */
    public function setNumberOfVehicles($numberOfVehicles)
    {
        $this->numberOfVehicles = $numberOfVehicles;

        return $this;
    }

    /**
     * Get numberOfVehicles
     *
     * @return int
     */
    public function getNumberOfVehicles()
    {
        return $this->numberOfVehicles;
    }
    
    
    /**
     * Set price
     *
     * @param flaot $price
     *
     * @return VehicleRequest
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
}

