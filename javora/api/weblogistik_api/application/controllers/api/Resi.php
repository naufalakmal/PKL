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
class Resi extends REST_Controller
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

        $id = $this->get('id_resi');

        // If the id parameter doesn't exist return all the users

        if ($id === NULL) {

            $users = $this->db->get("resi")->result_array();

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
            $this->db->where(array("id_resi" => $id));
            $users = $this->db->get("resi")->row_array();

            $this->response($users, REST_Controller::HTTP_OK);
        }
    }

    public function index_post()
    {
        // $this->some_model->update_user( ... );
        $data = [

            'id_resi' => $this->post('id_resi'),
            'tanggal' => $this->post('tanggal'),
            'id_pelanggan' => $this->post('id_pelanggan'),
            'id_penerima' => $this->post('id_penerima'),
            'berat_kirim' => $this->post('berat_kirim'),
            'jenis_kirim' => $this->post('jenis_kirim'),
            'jenis_bayar' => $this->post('jenis_bayar'),
            'id_tarif' => $this->post('id_tarif'),
            'ongkos_kirim' => $this->post('ongkos_kirim'),
            'ongkos_bongkar' => $this->post('ongkos_bongkar'),
            'diskon' => $this->post('diskon'),
            'ongkos_bersih' => $this->post('ongkos_bersih'),
            'bayar_amplop' => $this->post('bayar_amplop'),
            'kembalian_amplop' => $this->post('kembalian_amplop'),
            'keterangan' => $this->post('keterangan'),
            'photo' => $this->post('photo'),
            'status' => $this->post('status')
        ];

        $this->db->insert("resi", $data);

        $this->set_response($data, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function index_delete()
    {
        $id = $this->delete('id_resi');

        // $this->some_model->delete_something($id);
        $where = [
            'id_resi' => $id,
        ];

        $this->db->delete("resi", $where);

        $message = array("status" => "Data Berhasil Dihapus");

        $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    }

    public function index_put()
    {
        $where = array(
            "id_resi" => $this->put("id_resi")
        );

        $data = array(
            'tanggal' => $this->put('tanggal'),
            'id_pelanggan' => $this->put('id_pelanggan'),
            'id_penerima' => $this->put('id_penerima'),
            'berat_kirim' => $this->put('berat_kirim'),
            'jenis_kirim' => $this->put('jenis_kirim'),
            'jenis_bayar' => $this->put('jenis_bayar'),
            'id_tarif' => $this->put('id_tarif'),
            'ongkos_kirim' => $this->put('ongkos_kirim'),
            'ongkos_bongkar' => $this->put('ongkos_bongkar'),
            'diskon' => $this->put('diskon'),
            'ongkos_bersih' => $this->put('ongkos_bersih'),
            'bayar_amplop' => $this->put('bayar_amplop'),
            'kembalian_amplop' => $this->put('kembalian_amplop'),
            'keterangan' => $this->put('keterangan'),
            'photo' => $this->put('photo'),
            'status' => $this->put('status')
        );

        $this->db->update("resi", $data, $where);

        $this->set_response($data, REST_Controller::HTTP_CREATED);
    }
}
