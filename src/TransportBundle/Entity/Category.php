<?php

namespace TransportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="TransportBundle\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="numberOfVehicles", type="smallint")
     */
    private $numberOfVehicles;


    /**
     * @ORM\OneToMany(targetEntity="VehicleRequest", mappedBy="category")
     */
    private $requests;
    
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
     * Set name
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set numberOfVehicles
     *
     * @param integer $numberOfVehicles
     *
     * @return Category
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
    
    public function setRequests($requests)
    {
    	$this->requests = $requests;
    
    	return $this;
    }
    
    public function getRequests()
    {
    	return $this->requests;
    }
    
}

