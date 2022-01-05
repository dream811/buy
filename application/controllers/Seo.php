<?php 

Class Seo extends CI_Controller {

    function sitemap()
    {

        $data["data"] = array( 	'delivery',
        				'shopping',
        				'offten_question',
        				'deposit',
        				'coupon',
        				'totalfee',
        				'multiupload',
        				'mybasket',
        				'taoshopping',
        				'wish_list'
        				);
        header("Content-Type: text/xml;charset=iso-8859-1");
        $this->load->view("sitemap",$data);
    }
}


?>