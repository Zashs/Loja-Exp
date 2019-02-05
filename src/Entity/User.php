<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @UniqueEntity(fields="email", message="Email already taken")
 * @UniqueEntity(fields="username", message="Username already taken")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="role", type="string")
 * @ORM\DiscriminatorMap({"driver" = "Driver", "manager" = "Manager", "admin" = "Admin"})

 */
abstract class User implements UserInterface , \Serializable
{

    const ROLE_DRIVER = 'driver';
    const ROLE_MANAGER = 'manager';
    const ROLE_ADMIN = 'admin';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Assert\NotBlank(message="email")
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Assert\NotBlank(message="username")
     */
    private $username;

    /**
     * @Assert\NotBlank(message="password")
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * The below length depends on the "algorithm" you use for encoding
     * the password, but this works well with bcrypt.
     *
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /** @ORM\Column(type="boolean", name="status", options={"default":0}) */
    private $status = 0;

    /** @ORM\Column(name="created_at", type="datetime") */
    private $createdAt;

    public function __construct($username = '', $password = '', $salt = '', $status = '') {

        $this->username = $username;
        $this->password = $password;
        $this->status = $status;
    }

    // other properties and methods

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getSalt()
    {
        // The bcrypt and argon2i algorithms don't require a separate salt.
        // You *may* need a real salt if you choose a different encoder.
        return null;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role) 
    {
        if (!in_array($role, array(self::ROLE_ADMIN, self::ROLE_MANAGER, self::ROLE_DRIVER))) {
            throw new \InvalidArgumentException('Invalid Role');
        }       
        $this->role = $role;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    public function eraseCredentials()
    {
    }

    public function serialize()
    {
        return serialize(array(
                $this->id,
                $this->username,
                $this->password
        ));
    }
    
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->password
            ) = unserialize($serialized);
    }

}