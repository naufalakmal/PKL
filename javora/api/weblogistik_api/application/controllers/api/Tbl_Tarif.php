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
class Tbl_Tarif extends REST_Controller
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

        $id = $this->get('id_tarif');

        // If the id parameter doesn't exist return all the users

        if ($id === NULL) {

            $users = $this->db->get("tbl_tarif")->result_array();

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
            $this->db->where(array("id_tarif" => $id));
            $users = $this->db->get("tbl_tarif")->row_array();

            $this->response($users, REST_Controller::HTTP_OK);
        }
    }

    public function index_post()
    {
        // $this->some_model->update_user( ... );
        $data = [

            'id_tarif' => $this->post('id_tarif'),
            'jenis_tarif' => $this->post('jenis_tarif'),
            'asal' => $this->post('asal'),
            'tujuan' => $this->post('tujuan'),
            'berat_tarif' => $this->post('berat_tarif'),
            'harga_tarif' => $this->post('harga_tarif')
        ];

        $this->db->insert("tbl_tarif", $data);

        $this->set_response($data, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function index_delete()
    {
        $id = $this->delete('id_tarif');

        // $this->some_model->delete_something($id);
        $where = [
            'id_tarif' => $id,
        ];

        $this->db->delete("tbl_tarif", $where);

        $message = array("status" => "Data Berhasil Dihapus");

        $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    }

    public function index_put()
    {
        $where = array(
            "id_tarif" => $this->put("id_tarif")
        );

        $data = array(
            'jenis_tarif' => $this->put('jenis_tarif'),
            'asal' => $this->put('asal'),
            'tujuan' => $this->put('tujuan'),
            'berat_tarif' => $this->put('berat_tarif'),
            'harga_tarif' => $this->put('harga_tarif')
        );

        $this->db->update("tbl_tarif", $data, $where);

        $this->set_response($data, REST_Controller::HTTP_CREATED);
    }
}
