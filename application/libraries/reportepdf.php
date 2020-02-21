<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class reportepdf extends DOMPDF{
    
    protected function ci()
    {
        return get_instance();
    }


    public function load_view($view, $data = array())
    {
        $html = $this->ci()->load->view($view, $data, TRUE);

        $this->load_html($html);
    }
}