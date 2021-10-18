<?php
class Qrcodeci {

    private $qrcodeci;

    public function __construct() {
        require_once APPPATH . 'third_party/phpqrcode/qrlib.php';
        
    }
	
    public function generate($data) 
	{
        return  QRcode::png($data, realpath(FCPATH).'/export/'.$data.".PNG"); 
        //return  QRcode::png($data, (base_url() . "export/".$data.".PNG"));
    }

}
