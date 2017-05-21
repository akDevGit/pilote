<?php

namespace Pilote\UserBundle\Model;

class RolesHelper {
    
    private $rolesHierarchy;
    private $roles;

    public function __construct($rolesHierarchy) {
        $this->rolesHierarchy = $rolesHierarchy;
    }

    public function getRoles() {
        if($this->roles) {
            return $this->roles;
        }

        $roles = array();
        array_walk_recursive($this->rolesHierarchy, function($val) use (&$roles) {
            $roles[] = $val;
        });

        return $this->roles = array_unique($roles);
    }
}