<?php

namespace Pilote\UserBundle\Model;

use Symfony\Component\Security\Core\SecurityContext;

class RolesHelper {
    
    private $rolesHierarchy;
    private $roles;
    
    /**
     * @var SecurityContext
     */
    protected $context;

    /**
     * @param SecurityContext $context
     */
    public function __construct($rolesHierarchy, $context) {
        $this->context = $context;
        $this->rolesHierarchy = $rolesHierarchy;
    }

    public function getRoles() {
        if($this->roles) {
            return $this->roles;
        }

        $roles = array();
        array_walk_recursive($this->rolesHierarchy, function($val) use (&$roles) {
            
            if($this->context->isGranted($val)) {
                $roles[] = $val;
            }
        });

        return $this->roles = array_unique($roles);
    }
}