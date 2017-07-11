<?php

class reports extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index(){
        header("location:".URL.'/reports/lists/masseuse');
    }

    public function lists($section='masseuse'){

        $month = isset($_REQUEST["month"]) ? $_REQUEST["month"] : date('m');
        $period = isset($_REQUEST["period"]) ? $_REQUEST["period"] : 1;

        if( $period == 1 ){
            $start_date = date("Y-{$month}-01");
            $end_date = date("Y-{$month}-10");
        }
        elseif( $period == 2 ){
            $start_date = date("Y-{$month}-11");
            $end_date = date("Y-{$month}-20");
        }
        elseif( $period == 3 ){
            $start_date = date("Y-{$month}-21");
            $end_date = date("Y-{$month}-t");
        }

        // $start_date = date("Y-05-29");
        // $end_date = date("Y-05-31");

        $options = array();

        if( $section == "masseuse" ){

            $options['reports'] = true;
            $options["period_start"] = $start_date;
            $options["period_end"] = $end_date;

            $results = $this->model->query('package')->lists( $options );
        }

        if( $section == "daily" ){
            $results = array();
        }

        if( $section == "clocking" ){
            $results = array();
        }

        $this->view->setData('month', $month);
        $this->view->setData('period', $period);
        $this->view->setData('start_date', $start_date);
        $this->view->setData('end_date', $end_date);
        $this->view->setData('periodStr', $this->fn->q('time')->str_event_date($start_date, $end_date));

        $this->view->setData('results', $results);
        $this->view->setPage('title', 'รายงาน');
        $this->view->setData( 'section', $section );
        $this->view->render("reports/display");
    }

    public function masseuse($id=null){
        if( empty($id) || empty($this->me) ) $this->error();

        $section = "masseuse";

        $month = isset($_REQUEST["month"]) ? $_REQUEST["month"] : date('m');
        $period = isset($_REQUEST["period"]) ? $_REQUEST["period"] : 1;

        if( $period == 1 ){
            $start_date = date("Y-{$month}-01");
            $end_date = date("Y-{$month}-10");
        }
        elseif( $period == 2 ){
            $start_date = date("Y-{$month}-11");
            $end_date = date("Y-{$month}-20");
        }
        elseif( $period == 3 ){
            $start_date = date("Y-{$month}-21");
            $end_date = date("Y-{$month}-t");
        }

        // $start_date = date("Y-05-29");
        // $end_date = date("Y-05-31");

        $item = $this->model->query('package')->get($id);
        if( empty($item) ) $this->error();

        $options = array(
            'orders'=>true,
            'start_date'=> date("Y-m-d", strtotime($start_date)),
            'end_date'=> date("Y-m-d", strtotime($end_date)),
            'unlimit'=>true,
            'package'=>$id,
        );
        $masseuse = $this->model->query('masseuse')->lists( $options );

        $data = array();
        foreach ($masseuse['lists'] as $key => $value) {

            $time = $this->model->query('orders')->get_times_masseuse($value['id'], $options);
            if( !empty($time) ){
                $qty = 0;
                foreach ($time as $key => $val) {
                    $qty += $val['item_qty'];
                    $day = date("d", strtotime($val['date']));

                    $data[$value['id']][$day] = $qty;
                }
            }
        }
        $null = $this->model->query('orders')->get_times_masseuse(null,$options);
        $data['null'] = $null[0]['qty'];

        $this->view->setData('periodStr', $this->fn->q('time')->str_event_date($start_date, $end_date));
        $this->view->setData('period', $period);
        $this->view->setData('month', $month);
        $this->view->setData('data', $data);
        $this->view->setData('results', $masseuse);
        $this->view->setData('start_date', $start_date);
        $this->view->setData('end_date', $end_date);
        $this->view->setData('id', $id);
        $this->view->setData('item', $item);
        $this->view->setData( 'section', $section );
        $this->view->render("reports/display");
    }
}