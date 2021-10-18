<?php

defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Pelanggan extends REST_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    public function index_get()
    {
        // Users from a data store e.g. database

        $id = $this->get('id_pelanggan');

        // If the id parameter doesn't exist return all the users

        if ($id === NULL) {

            $users = $this->db->get("pelanggan")->result_array();

            // Check if the users data store contains users (in case the database result returns NULL)
            if ($users) {
                // Set the response and exit
                $this->response($users, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No users were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }

        // Find and return a single record for a particular user.
        else {


            // Validate the id.
            if ($id <= 0) {
                // Invalid id, set the response and exit.
                $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            // Get the user from the array, using the id as key for retrieval.
            // Usually a model is to be used for this.
            $this->db->where(array("id_pelanggan" => $id));
            $users = $this->db->get("pelanggan")->row_array();

            $this->response($users, REST_Controller::HTTP_OK);
        }
    }

    public function index_post()
    {
        // $this->some_model->update_user( ... );
        $data = [

            'id_pelanggan' => $this->post('id_pelanggan'),
            'nama' => $this->post('nama'),
            'telepon' => $this->post('telepon'),
            'alamat' => $this->post('alamat'),
            'province_id' => $this->post('province_id'),
            'city_id' => $this->post('city_id'),
            'district_id' => $this->post('district_id'),
            'village_id' => $this->post('village_id')
        ];

        $this->db->insert("pelanggan", $data);

        $this->set_response($data, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function index_delete()
    {
        $id = $this->delete('id_pelanggan');

        // $this->some_model->delete_something($id);
        $where = [
            'id_pelanggan' => $id,
        ];

        $this->db->delete("pelanggan", $where);

        $message = array("status" => "Data Berhasil Dihapus");

        $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    }

    public function index_put()
    {
        $where = array(
            "id_pelanggan" => $this->put("id_pelanggan")
        );

        $data = array(
            'nama' => $this->put('nama'),
            'telepon' => $this->put('telepon'),
            'alamat' => $this->put('alamat'),
            'province_id' => $this->put('province_id'),
            'city_id' => $this->put('city_id'),
            'district_id' => $this->put('district_id'),
            'village_id' => $this->put('village_id')
        );

        $this->db->update("pelanggan", $data, $where);

        $this->set_response($data, REST_Controller::HTTP_CREATED);
    }
}
