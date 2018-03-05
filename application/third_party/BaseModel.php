<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseModel extends CI_Model {
    protected $o_doctrine;
    
    function __construct() {
        parent::__construct();
        $this->o_doctrine = $this->doctrine->em;
    }
}
