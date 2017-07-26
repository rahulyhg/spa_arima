<?php

class Dashboard extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index(  ){

		if( empty($this->permit['dashboard']['view']) ){

			if( count($this->me['access']) == 1 ){

				if( $this->me['access'][0]==5 ){
					header('location:'.URL.'pos');
					die;
				}
				
				// header('location:'.URL.'customers');
			}
			
			header('location:'.URL.'package');
		}

		$start = date('Y-m-d 00:00:00');
		$end = date('Y-m-d 23:59:59');

		if( isset($_GET['period_start']) && isset($_GET['period_end']) ){
			$start = date('Y-m-d 00:00:00', strtotime($_GET['period_start']));
			$end = date('Y-m-d 23:59:59', strtotime($_GET['period_end']));
		}

		/* สรุปยอดรายรับ */
		$revenue_options = array(
			'period_start'=>$start,
			'period_end'=>$end,
			'type'=>'revenue',
		);
		$this->view->setData('revenue', $this->model->query('orders')->summary( $revenue_options ));

		/* สรุปยอดจอง */
		$booking_options = array(
			'period_start'=>$start,
			'period_end'=>$end,
			'status'=>'booking',
		);
		$this->view->setData('booking', $this->model->query('orders')->lists( $booking_options ));

		/* สรุปยอดเข้าใช้บริการ */
		$service_options = array(
			'period_start'=>$start,
			'period_end'=>$end,
			'type'=>'service',
		);
		$this->view->setData('service', $this->model->query('orders')->summary( $service_options ));

		/* Customer RUN & EXPIRED */
		$this->view->setData('customers', $this->model->query('customers')->summary());

		/* ยอด VIP */
		// $room_options = array(
		// 	'period_start'=>$start,
		// 	'period_end'=>$end,
		// 	'type'=>'room',
		// );
		// $this->view->setData('room', $this->model->query('orders')->summary( $room_options ));

		/* Package List */
		$package_options = array(
			'period_start'=>$start,
			'period_end'=>$end,
			'dashboard'=>true
		);
		// print_r($this->model->query('package')->lists( $package_options ));die;
		$this->view->setData('package', $this->model->query('package')->lists( $package_options ));

		/* แปลงวันที่ */
		$this->view->setData('date_str', $this->fn->q('time')->str_event_date($start, $end) );

        if( isset($_GET['main']) ){
			$this->view->render('dashboard/sections/main');
		}
		else{
			$this->view->render("dashboard/display");
		}
		
		// print_r($this->model->query('reports')->summaryEachPackage( $start, $end )); die;
		$this->view->setData('summaryEachPackage', $this->model->query('reports')->summaryEachPackage( $start, $end ) );
	}

	public function demo(){
		
		$this->view->render("dashboard/demo");
	}
}