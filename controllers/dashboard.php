<?php

class Dashboard extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index(  ){

		if( empty($this->permit['dashboard']['view']) ){
			if( $this->me['dep_is_sale'] == 1 ){
				header('location:'.URL.'sales');
			}
			else{
				header('location:'.URL.'calendar');
			}
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
				$start = date('Y-m-01');
				$end = date('Y-m-t');
			}
		}
		/* ยอดรับเงินจอง + เงินดาวน์*/
		$price_options = array(
			'period_start'=>$start,
			'period_end'=>$end,
			'dashboard'=>true,
		);
		$total_price = $this->model->query('booking')->lists( $price_options );
		$this->view->setData('total_price', $total_price);

		/* ยอดซื้อเงินสด */
		$cash_options = array(
			'period_start'=>$start,
			'period_end'=>$end,
			'dashboard'=>true,
			'pay_type'=>'cash',
		);
		$total_cash = $this->model->query('booking')->lists( $cash_options );
		$this->view->setData('total_cash', $total_cash);

		$wait_options = array(
			'status'=>'booking',
			'pay_type'=>'cash',
			'period_start'=>$start,
			'period_end'=>$end,
			'dashboard'=>true,
		);
		$total_wait = $this->model->query('booking')->lists( $wait_options );
		$this->view->setData('total_wait', $total_wait);

		/* ยอดส่งมอบ (ยอดขาย) */
		$finish_options = array(
			'status'=>'finish',
			'period_start'=>$start,
			'period_end'=>$end,
			'finish'=>true,
			'dashboard'=>true,
		);
		$total_finish = $this->model->query('booking')->lists( $finish_options );
		$this->view->setData('total_finish', $total_finish);

		/* ยอดจอง */
		$booking_options = array(
			'status'=>'booking',
			'period_start'=>$start,
			'period_end'=>$end,
			'dashboard'=>true,
		);
		$total_booking = $this->model->query('booking')->lists( $booking_options );
		$this->view->setData('total_booking', $total_booking);

		/* ยอดยกเลิก */
		$cancel_options = array(
			'status'=>'cancel',
			'period_start'=>$start,
			'period_end'=>$end,
			'dashboard'=>true,
		);
		$total_cancel = $this->model->query('booking')->lists( $cancel_options );
		$this->view->setData('total_cancel', $total_cancel);

		/* ยอดขายของเซลล์ */
		$sale_options = array(
			'dep'=>'Sales',
			'period_start'=>$start,
			'period_end'=>$end
		);
		$total_sale = $this->model->query('employees')->lists( $sale_options );		
		$this->view->setData('total_sale', $total_sale);

		/* จำนวนลูกค้า */
		$customers_options = array(
			'period_start'=>$start,
			'period_end'=>$end
		);
		$total_customers = $this->model->query('customers')->lists( $customers_options );
		$this->view->setData('total_customers', $total_customers);

		/* จำนวนเข้าใช้บริการ */
		$services_options = array(
			'period_start'=>$start,
			'period_end'=>$end
		);
		//$total_services = $this->model->query('services')->lists( $services_options );
		$total_services = array();
		$this->view->setData('total_services', $total_services);

		/* Package List */
		$package_options = array(
			'period_start'=>$start,
			'period_end'=>$end,
			'dashboard'=>true
		);
		// print_r($this->model->query('package')->lists( $package_options ));die;
		$this->view->setData('package', $this->model->query('package')->lists( $package_options ));

		/* ยอดสินค้า */
		$total_products = $this->model->query('products')->lists( array('sum'=>true) );
		$this->view->setData('total_products', $total_products);

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