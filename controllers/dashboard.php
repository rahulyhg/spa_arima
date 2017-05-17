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
				}
				
				// header('location:'.URL.'customers');
			}
			
			header('location:'.URL.'package');
		}

		$start = date('Y-m-d 00:00:00');
		$end = date('Y-m-d 23:59:59');

		if( isset($_GET['period']) ){
			if( $_GET['period'] == 'daily' ){
				$start = date('Y-m-d 00:00:00');
				$end = date('Y-m-d 23:59:59');
			}
			elseif( $_GET['period'] == 'weekly' ){
				$date = $this->fn->q('time')->theWeeks( date('c'), 'monday' );
				$start = $date['start'];
				$end = $date['end'];
			}
			elseif( $_GET['period'] == 'monthly' ){
				$start = date('Y-m-01 00:00:00');
				$end = date('Y-m-t 23:59:59');
			}
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
		$room_options = array(
			'period_start'=>$start,
			'period_end'=>$end,
			'type'=>'room',
		);
		$this->view->setData('room', $this->model->query('orders')->summary( $room_options ));

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

        $this->view->render("dashboard/display");
	}

	public function demo(){
		
		$this->view->render("dashboard/demo");
	}

	/*public function booking() {
		

		$this->view->setData('tab', "booking");
		$this->view->render("dashboard/display");
	}

	public function services(){

		$this->view->setData('tab', "services");
		$this->view->render("dashboard/display");
	}

	public function stocks(){
		
		$this->view->setData('tab', "stocks");
		$this->view->render("dashboard/display");
	}

	public function sales() {
		$this->view->setData('tab', "sales");
		$this->view->render("dashboard/display");
	}*/
}