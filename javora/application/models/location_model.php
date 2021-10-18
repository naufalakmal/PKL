<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Location_Model extends CI_Model
{
    public function get_province()
    {
        $this->db->from('province');
        $query = $this->db->get();

        return $query;
    }
}
