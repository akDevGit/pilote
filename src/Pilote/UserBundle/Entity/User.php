<?php

namespace Pilote\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
//use Symfony\Component\Security\Core\User\UserInterface as UserInterface;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Pilote\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    protected $password;

    /**
     * @var array
     *
     * @ORM\Column(name="salt", type="array", nullable=true)
     */
    protected $salt;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="array")
     */
    protected $roles;
    
    /**
    * @ORM\OneToOne(targetEntity="Pilote\UserBundle\Entity\UserInfos",cascade={"persist"})
    */
    protected $infos;
    
    /**
    * @ORM\OneToOne(targetEntity="Pilote\UserBundle\Entity\UserContact",cascade={"persist"})
    */
    protected $contact;
    
    /**
    * @ORM\OneToOne(targetEntity="Pilote\UserBundle\Entity\UserTeam",cascade={"persist"})
    */
    protected $team;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param array $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return array 
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set roles
     *
     * @param array $roles
     * @return User
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array 
     */
    public function getRoles()
    {
        return $this->roles;
    }
    
    /**
     * Set infos
     *
     * @param array $infos
     * @return User
     */
    public function setInfos(UserInfos $infos = null) {
        $this->infos = $infos;

        return $this;
    }

    /**
     * Get infos
     *
     * @return array 
     */
    public function getInfos() {
        return $this->infos;
    }
    
    /**
     * Set contact
     *
     * @param array $contact
     * @return User
     */
    public function setContact(UserContact $contact = null) {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return array 
     */
    public function getContact() {
        return $this->contact;
    }
    
    /**
     * Set team
     *
     * @param array $team
     * @return User
     */
    public function setTeam(UserTeam $team = null) {
        $this->team = $team;

        return $this;
    }

    /**
     * Get team
     *
     * @return array 
     */
    public function getTeam() {
        return $this->team;
    }
    
    public function eraseCredentials() {
    }
    
    
}
