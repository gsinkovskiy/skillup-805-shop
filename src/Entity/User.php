<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="users")
 * @UniqueEntity("email")
 * @UniqueEntity("username")
 */
class User implements AdvancedUserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, options={"default": ""})
     * @Assert\NotBlank()
     * @Assert\Length(min="3", max="255")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, options={"default": ""})
     * @Assert\NotBlank()
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, options={"default": ""})
     * @Assert\NotBlank()
     * @Assert\Email(checkHost=true, checkMX=true)
     */
    private $email;

    /**
     * @ORM\Column(type="boolean", options={"default": true})
     */
    private $isActive;

    /**
     * @ORM\Column(type="simple_array")
     */
    private $roles;

    /**
     * @var bool
     * @Assert\NotBlank()
     */
    private $acceptRules;

    public function __construct()
    {
        $this->username = '';
        $this->password = '';
        $this->email = '';
        $this->isActive = true;
        $this->roles = ['ROLE_USER'];
        $this->acceptRules = false;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * String representation of object
     *
     * @link  http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize([
            $this->id, $this->username, $this->password, $this->email, $this->isActive, $this->roles
        ]);
    }

    /**
     * Constructs the object
     *
     * @link  http://php.net/manual/en/serializable.unserialize.php
     *
     * @param string $serialized <p>
     *                           The string representation of the object.
     *                           </p>
     *
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        list($this->id, $this->username, $this->password, $this->email, $this->isActive, $this->roles) = $data;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Removes sensitive data from the user.
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {

    }

    /**
     * Checks whether the user's account has expired.
     * Internally, if this method returns false, the authentication system
     * will throw an AccountExpiredException and prevent login.
     *
     * @return bool true if the user's account is non expired, false otherwise
     * @see AccountExpiredException
     */
    public function isAccountNonExpired()
    {
        return $this->isActive;
    }

    /**
     * Checks whether the user is locked.
     * Internally, if this method returns false, the authentication system
     * will throw a LockedException and prevent login.
     *
     * @return bool true if the user is not locked, false otherwise
     * @see LockedException
     */
    public function isAccountNonLocked()
    {
        return $this->isActive;
    }

    /**
     * Checks whether the user's credentials (password) has expired.
     * Internally, if this method returns false, the authentication system
     * will throw a CredentialsExpiredException and prevent login.
     *
     * @return bool true if the user's credentials are non expired, false otherwise
     * @see CredentialsExpiredException
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is enabled.
     * Internally, if this method returns false, the authentication system
     * will throw a DisabledException and prevent login.
     *
     * @return bool true if the user is enabled, false otherwise
     * @see DisabledException
     */
    public function isEnabled()
    {
        return $this->isActive;
    }

    /**
     * @return bool
     */
    public function isAcceptRules(): bool
    {
        return $this->acceptRules;
    }

    /**
     * @param bool $acceptRules
     */
    public function setAcceptRules(bool $acceptRules): void
    {
        $this->acceptRules = $acceptRules;
    }

}
