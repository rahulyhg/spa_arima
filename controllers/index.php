<?php

class Index extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        $customer = $this->model->query('customers')->lists();
        foreach ($customer['lists'] as $key => $value) {

            //UPDATE STATUS REALTIME //
            $dateNow = date("Y-m-d");
            $arrDate1 = explode("-",$value['expired'][0]['end_date']);
            $arrDate2 = explode("-",$dateNow);
            $timStmp1 = mktime(0,0,0,$arrDate1[1],$arrDate1[2],$arrDate1[0]);
            $timStmp2 = mktime(0,0,0,$arrDate2[1],$arrDate2[2],$arrDate2[0]);

            if( $timStmp1 < $timStmp2 ){

                $this->model->query('customers')->update( $value['id'], array('cus_status'=>'expired') );

                $this->model->query('customers')->setExpired( array(
                    'ex_id'=>$value['expired'][0]['id'],
                    'ex_status'=>'expired'
                ) );
            }
            // End Update //
        }

        header('Location: '. URL.'dashboard' );
    }

    public function search($_url) {

        $this->pathName = $_url[0];
        $this->_modify();
        
        $this->error();
    }
}
