<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ManagerRepository")
 */
class Manager extends User
{  
    /** 
     * @ORM\Column
     * @Assert\NotBlank()
     * @Assert\Length(max = 255) 
     */
    private $address;
    /** 
     * @ORM\Column(length=40)
     * @Assert\NotBlank()
     * @Assert\Length(max = 40)
     */
    private $nif;  
    /** 
     * @Assert\NotBlank()
     * @Assert\Length(max = 255)
     * @ORM\Column 
     */
    private $location;
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min = 2, max = 10) 
     * @ORM\Column(length=10, name="postal_code")
     */
    private $postalCode;

    public function getRoles()
    {
    	return array('ROLE_MANAGER');	
    }
    
	public function getNif() {
		return $this->nif;
	}

	public function setNif($nif) {
		$this->nif = $nif;
	}

	public function getAddress() {
		return $this->address;
	}

	public function setAddress($address) {
		$this->address = $address;
	}

    public function getLocation() {
        return $this->location;
    }

    public function setLocation($location) {
        $this->location = $location;
    }
    
    public function getPostalCode() {
        return $this->postalCode;
    }
    
    public function setPostalCode($postalCode) {
        $this->postalCode = $postalCode;
    }    
}
