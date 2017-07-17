<?php

class Reports_Model extends Model {
    public function __construct() {
        parent::__construct();
    }


    public function summaryEachPackage($start, $end) {

        if( empty($start) || empty($end) ){

            $date = date('Y-m-d');

            $start = date('Y-m-d 00:00:00', strtotime($date));
            $end = date('Y-m-d 23:59:59', strtotime($date));
        }


        $arr = array();
        $sth = $this->db->prepare("SELECT SUM(order_room_price) AS amount FROM orders WHERE order_date BETWEEN :s AND :e");
        $sth->execute(array(':s'=>$start, ':e'=>$end));
        $fdata = $sth->fetch( PDO::FETCH_ASSOC );

        $arr[] = array(
            'name' => 'ค่าห้อง V.I.P.',
            'amount' => $fdata['amount'],
        );


        $package = $this->db->select("SELECT pack_id as id, pack_name as name FROM package ORDER BY pack_sequence ASC");
        foreach ($package as $key => $value) {

            $sth = $this->db->prepare("SELECT SUM(orders_items.item_balance) AS amount FROM orders_items LEFT JOIN orders ON orders.order_id=orders_items.item_order_id WHERE orders_items.item_pack_id=:id AND orders.order_date BETWEEN :s AND :e");
            $sth->execute(array(':id'=>$value['id'],':s'=>$start, ':e'=>$end));
            $fdata = $sth->fetch( PDO::FETCH_ASSOC );

            $arr[] = array(
                'name' => $value['name'],
                'amount' => $fdata['amount'],
            );
        }


        $sth = $this->db->prepare("SELECT SUM(order_drink) AS amount FROM orders WHERE order_date BETWEEN :first AND :last");
        $sth->execute(array(':first'=>$start, ':last'=>$end));
        $fdata = $sth->fetch( PDO::FETCH_ASSOC );
        $arr[] = array(
            'name' => 'DRINK',
            'amount' => $fdata['amount'],
        );

        return $arr;
    }

    public function income($start, $end){

    	$end .= ' 23:59:59';
    	//$data = $this->db->select("SELECT cus_id as id, cus_created as created FROM customers", array()); //':s'=>$start,':e'=>$end
        $data = $this->db->select("SELECT model_name ,count(book_id) AS count_finish FROM `booking` INNER JOIN products_models ON book_model_id = model_id "
                . "WHERE book_status ='finish' AND (book_date BETWEEN :s AND :e) GROUP By book_model_id" , array(':s'=>$start,':e'=>$end));

        $total = $this->db->count('`booking`', "book_status ='finish' AND (book_date BETWEEN :s AND :e)" , array(':s'=>$start,':e'=>$end));
        $subtotal = 0;

        $data2 = array();
        foreach ($data as $key => $value) {
            $subtotal += 1;
        }

    	return array(
    		'options' => array(
    			'start' => $start, 
    			'end' => $end
    		),
    		'data' => $data,
    		'chart' => $this->chart( $data, $start, $end ),

    		'subtotal' => number_format($subtotal),
            'total' => number_format($total),

            // 'table' => $arr['table']
    	);
    }
    public function booking($start, $end){
    	
    	$end .= ' 23:59:59';
    	//$data = $this->db->select("SELECT cus_id as id, cus_created as created FROM customers", array()); //':s'=>$start,':e'=>$end

        $data = $this->db->select("SELECT model_name ,count(book_id) AS count_finish FROM `booking` INNER JOIN products_models ON book_model_id = model_id "
                . "WHERE book_status='booking' AND (book_date BETWEEN :s AND :e) GROUP By book_model_id" , array(':s'=>$start,':e'=>$end));

        $total = $this->db->count('`booking`', "book_status ='booking' AND (book_date BETWEEN :s AND :e)" , array(':s'=>$start,':e'=>$end));
        $subtotal = 0;

        $data2 = array();
        foreach ($data as $key => $value) {
            $subtotal += 1;
        }

    	return array(
    		'options' => array(
    			'start' => $start, 
    			'end' => $end
    		),
    		'data' => $data,
    		'chart' => $this->chart( $data, $start, $end ),

    		'subtotal' => number_format($subtotal),
            'total' => number_format($total),

            // 'table' => $arr['table']
    	);
    }

    public function all($start, $end){
    	
    	$end .= ' 23:59:59';
    	//$data = $this->db->select("SELECT cus_id as id, cus_created as created FROM customers", array()); //':s'=>$start,':e'=>$end
        $data = $this->db->select("SELECT model_amount_balance,model_amount_sales,model_name ,count(book_id) AS count_finish  FROM `booking` INNER JOIN products_models ON book_model_id = model_id 
                  WHERE book_status ='finish' AND (book_date BETWEEN :s AND :e) GROUP By book_model_id" , array(':s'=>$start,':e'=>$end));

        $total = $this->db->count('`booking`', "book_status ='booking' AND (book_date BETWEEN :s AND :e)" , array(':s'=>$start,':e'=>$end));
        $subtotal = 0;

        $data2 = array();
        foreach ($data as $key => $value) {
            $subtotal += 1;
        }

    	return array(
    		'options' => array(
    			'start' => $start, 
    			'end' => $end
    		),
    		'data' => $data,
    		'chart' => $this->chartt( $data, $start, $end ),

    		'subtotal' => number_format($subtotal),
            'total' => number_format($total),

            // 'table' => $arr['table']
    	);
    }
    public function sales($start, $end){

    	$end .= ' 23:59:59';
    	//$data = $this->db->select("SELECT cus_id as id, cus_created as created FROM customers", array()); //':s'=>$start,':e'=>$end
        $data = $this->db->select("SELECT  emp_first_name ,count(emp_dep_id) AS employees FROM `employees` INNER JOIN booking ON emp_id = book_sale_id "
                . "WHERE emp_dep_id = 2 AND book_status = 'finish' AND (book_date BETWEEN :s AND :e) GROUP By emp_id" , array(':s'=>$start,':e'=>$end));
       

        $total = $this->db->count('`booking`', "book_status ='finish' AND (book_date BETWEEN :s AND :e)" , array(':s'=>$start,':e'=>$end));
        $subtotal = 0;

        $data2 = array();
        foreach ($data as $key => $value) {
            $subtotal += 1;
        }
      $txet = 'จำนวนยอดขาย Sales';
    	return array(
    		'options' => array(
    			'start' => $start, 
    			'end' => $end
    		),
    		'data' => $data,
    		'chart' => $this->charts( $data, $start, $end ,$txet ),

    		'subtotal' => number_format($subtotal),
            'total' => number_format($total),

            // 'table' => $arr['table']
    	);
    }
    
    public function book_sale($start, $end){
    	
    	$end .= ' 23:59:59';
    	//$data = $this->db->select("SELECT cus_id as id, cus_created as created FROM customers", array()); //':s'=>$start,':e'=>$end
        $data = $this->db->select("SELECT  emp_first_name ,count(emp_dep_id) AS employees FROM `employees` INNER JOIN booking ON emp_id = book_sale_id "
                . "WHERE emp_dep_id = 2 AND book_status = 'booking' AND (book_date BETWEEN :s AND :e) GROUP By emp_id" , array(':s'=>$start,':e'=>$end));
       

        $total = $this->db->count('`booking`', "book_status ='booking' AND (book_date BETWEEN :s AND :e)" , array(':s'=>$start,':e'=>$end));
        $subtotal = 0;

        $data2 = array();
        foreach ($data as $key => $value) {
            $subtotal += 1;
        }
            $txet = 'จำนวนยอดจองทั้งหมด';
    	return array(
    		'options' => array(
    			'start' => $start, 
    			'end' => $end
    		),
    		'data' => $data,
    		'chart' => $this->charts( $data, $start, $end,$txet ),

    		'subtotal' => number_format($subtotal),
            'total' => number_format($total),

            // 'table' => $arr['table']
    	);
    }

    public function total($data) {
    	
    	$total = 0;
		foreach ($data as $key => $value) {
			$total += $value['total'];
		}

		return '฿ '.number_format($total,0);
    }

    public function subtotal() {
    	
    	$sth = $this->db->prepare("SELECT SUM(inv_total) as total FROM invoices");
        $sth->execute();

        $data = $sth->fetch( PDO::FETCH_ASSOC );
        return  '฿ '.number_format($data['total'],0);
    }

    public function chart( $data, $start, $end ) {
        
    	$chart = array();

    	$t = strtotime($start);
    	$fdata = array();
    	$lists = array();
    	$categories = array();

    	/*$days = $this->getDays( $start, $end );

    	// monthly or yearly
    	if( $days>31 ){
    		
    		$now = 0;
    		$count = -1;
    		for ($i=0; $i < $days; $i++) { 
    			$time = $i>0 ? strtotime("+{$i} day", $t ) : $t;

    			$date = date('Y-m-d', $time);
	    		$eDate = $date.' 23:59:59';

	    		$n = ( $days>366 ) ? date('Y', $time): date('n', $time);

	    		if( $now != $n ){

	    			$now = $n;
	    			$count++;
	    			$lists[$count]=0;
	    			$categories[] = ( $days>366 ) 
	    				? $n
	    				: $this->fn->q('time')->month( $n, true );
	    		}

	    		foreach ($data as $key => $value) {
	    			
	    			$createDate = strtotime( $value['created'] );
	    			if( $createDate>=strtotime($date) AND $createDate<=strtotime($eDate) ){

	    				$lists[$count] += $value['total'];
	    			}
	    		}

    		}

    		// print_r($categories);
    	}
    	# dayliy
    	else{
    		
	    	for ($i=0; $i < $days; $i++) { 
	    		$time = $i>0 ? strtotime("+{$i} day", $t ) : $t;

	    		$date = date('Y-m-d', $time);
	    		$eDate = $date.' 23:59:59';

	    		$total = 0;
	    		foreach ($data as $key => $value) {
	    			
	    			$createDate = strtotime( $value['created'] );
	    			if( $createDate>=strtotime($date) AND $createDate<=strtotime($eDate) ){
	    				$total += $value['total'];
	    				$fdata[$date][] = $value['total'];
	    			}
	    		}

	    		$categories[] = date('j', $time);
	    		$lists[] = $total;
	    	}
	    	
        }*/

        

        $chart['tooltip'] = array(
            'enabled'=>false
        );
        
        // โชเลขหัวกราฟ
        $chart['plotOptions'] = array(
            'column' => array(
                // 'stacking' => 'normal', // กราฟ ซ้อน
        	'dataLabels' => array( 
                    'enabled'=> 'true' 
                ),
        	'enableMouseTracking' => false
            )
        );
        
        foreach ($data as $key => $value){
            $categories[] = $value['model_name'];
            $lists[] = intval($value['count_finish']);
           // proc_close($ff);die;
        }
        
        if( empty($categories) ){
            $categories[] = 'ไม่พบข้อมูล';
        }
        
        //ฐานล่าง
        $chart['xAxis'] = array(
        	'lineColor' => "#99ffbb",
        	'lineWidth' => 3,
        	'tickWidth' => 0,
        	'title' => array('text'=>null),
        	'categories' => $categories
        );

        $chart['series'][] = array(
            'borderWidth'=> 0,
            'borderColor'=> null,
            'data'=> $lists,
            'name' => 'จำนวนทั้งหมด'
        );
        
        
        $chart['legend'] = array(
            'enabled'=> 1,

            'align'=> 'right',
            'x'=> -30,
            'verticalAlign'=> 'top',
            'y'=> 10,
            'floating'=> true,
            'backgroundColor'=> 'white',
            'borderColor'=> '#99ffbb',
            'borderWidth'=> 1,
            'shadow'=> false,
        );

        return $chart;
    }
    
    public function charts( $data, $start, $end ,$txet ) {
      
           
        
        
        
    	$chart = array();

    	$t = strtotime($start);
    	$fdata = array();
    	$lists = array();
    	$categories = array();

    	/*$days = $this->getDays( $start, $end );

    	// monthly or yearly
    	if( $days>31 ){
    		
    		$now = 0;
    		$count = -1;
    		for ($i=0; $i < $days; $i++) { 
    			$time = $i>0 ? strtotime("+{$i} day", $t ) : $t;

    			$date = date('Y-m-d', $time);
	    		$eDate = $date.' 23:59:59';

	    		$n = ( $days>366 ) ? date('Y', $time): date('n', $time);

	    		if( $now != $n ){

	    			$now = $n;
	    			$count++;
	    			$lists[$count]=0;
	    			$categories[] = ( $days>366 ) 
	    				? $n
	    				: $this->fn->q('time')->month( $n, true );
	    		}

	    		foreach ($data as $key => $value) {
	    			
	    			$createDate = strtotime( $value['created'] );
	    			if( $createDate>=strtotime($date) AND $createDate<=strtotime($eDate) ){

	    				$lists[$count] += $value['total'];
	    			}
	    		}

    		}

    		// print_r($categories);
    	}
    	# dayliy
    	else{
    		
	    	for ($i=0; $i < $days; $i++) { 
	    		$time = $i>0 ? strtotime("+{$i} day", $t ) : $t;

	    		$date = date('Y-m-d', $time);
	    		$eDate = $date.' 23:59:59';

	    		$total = 0;
	    		foreach ($data as $key => $value) {
	    			
	    			$createDate = strtotime( $value['created'] );
	    			if( $createDate>=strtotime($date) AND $createDate<=strtotime($eDate) ){
	    				$total += $value['total'];
	    				$fdata[$date][] = $value['total'];
	    			}
	    		}

	    		$categories[] = date('j', $time);
	    		$lists[] = $total;
	    	}
	    	
        }*/

        

        $chart['tooltip'] = array(
            'enabled'=>false
        );
        
        // โชเลขหัวกราฟ
        $chart['plotOptions'] = array(
            'column' => array(
                // 'stacking' => 'normal', // กราฟ ซ้อน
        	'dataLabels' => array( 
                    'enabled'=> 'true' 
                ),
        	'enableMouseTracking' => false
            )
        );
        
        foreach ($data as $key => $value){
            $categories[] = $value['emp_first_name'];
            $lists[] = intval($value['employees']);
           // proc_close($ff);die;
        }
        
        if( empty($categories) ){
            $categories[] = 'ไม่พบข้อมูล';
        }
        
        //ฐานล่าง
        $chart['xAxis'] = array(
        	'lineColor' => "#c0c0c0",
        	'lineWidth' => 3,
        	'tickWidth' => 0,
        	'title' => array('text'=>null),
        	'categories' => $categories
        );

        $chart['series'][] = array(
            'borderWidth'=> 0,
            'borderColor'=> null,
            'data'=> $lists,
            'name' => $txet
        );
        
        
        $chart['legend'] = array(
            'enabled'=> 1,

            'align'=> 'right',
            'x'=> -30,
            'verticalAlign'=> 'top',
            'y'=> 10,
            'floating'=> true,
            'backgroundColor'=> 'white',
            'borderColor'=> '#CCC',
            'borderWidth'=> 1,
            'shadow'=> false,
        );

        return $chart;
    }
    
    
    public function chartt( $data, $start, $end ) {

    	$chart = array();

    	$t = strtotime($start);
    	$fdata = array();
    	$lists = array();
        $numder = array();
    	$categories = array();

        $chart['tooltip'] = array(
            'enabled'=>false
        );
        
        // โชเลขหัวกราฟ
        $chart['plotOptions'] = array(
            'column' => array(
                // 'stacking' => 'normal', // กราฟ ซ้อน
        	'dataLabels' => array( 
                    'enabled'=> 'true' 
                ),
        	'enableMouseTracking' => false
            )
        );
        
        foreach ($data as $key => $value){
            $categories[] = $value['model_name'];
            $lists[] = intval($value['count_finish']);
            $numder[] = intval($value['model_amount_balance'] + $value['model_amount_sales']);
           
        }
        
        if( empty($categories) ){
            $categories[] = 'ไม่พบข้อมูล';
        }
        
        //ฐานล่าง
        $chart['xAxis'] = array(
        	'lineColor' => "#99ffbb",
        	'lineWidth' => 3,
        	'tickWidth' => 0,
        	'title' => array('text'=>null),
        	'categories' => $categories
        );

        $chart['series'][] = array(
            'borderWidth'=> 0,
            'borderColor'=> null,
            'data'=> $lists,
            'name' => 'จำนวนยอดขาย'
        );
         $chart['series'][] = array(
            'borderWidth'=> 0,
            'borderColor'=> null,
            'data'=> $numder,
            'name' => 'จำนวนรถยนต์ทั้งหมด'
        );
        
        
        $chart['legend'] = array(
            'enabled'=> 1,

            'align'=> 'right',
            'x'=> -30,
            'verticalAlign'=> 'top',
            'y'=> 10,
            'floating'=> true,
            'backgroundColor'=> 'white',
            'borderColor'=> '#CCC',
            'borderWidth'=> 1,
            'shadow'=> false,
        );

        return $chart;
    }

    public function getDays($start, $end) {
    	
    	$start = strtotime($start);
    	$end = strtotime($end);
    	// $end = strtotime('+1 day', strtotime($end));

    	/*$sy = date('Y', $start);
    	$ey = date('Y', $end);

    	$y = array();
    	while ($sy >= $ey) {
    		$y[] = $sy;

    		for ($i=1; $i <= 12; $i++) { 
    		}
    		$sy--;
    	}*/

    	$few = $end - $start;
    	return  round( $few / 86400, 0, PHP_ROUND_HALF_DOWN );
    }

    public function last24hours($start, $end) {
        
        $data = $this->db->select("
            SELECT order_created as created, order_costs as costs, order_total_discounts as total_discounts, order_total_tax as total_tax, order_pay_type as pay_type
            FROM orders
            WHERE order_created BETWEEN :s AND :e AND order_status='finish'
            ORDER BY order_created ASC", 
        array(':s'=>$start,':e'=>$end));

        $payment_types = $this->db->select("SELECT pay_id as id, pay_name as name FROM payment_types ORDER BY pay_sequence ASC");
        // i LEFT JOIN payment_types t ON i.inv_pay_type=t.pay_id 

        /* set */
        $arr = array(
            'options' => array(
                'start' => $start, 
                'end' => $end
            ),
            'payment_types' => array(
                'credit' => 0,
                'cash' => 0,
                'total_discounts' => 0,
                'sales_tax' => 0,
                'net_sales' => 0,
            ),
            'data' => $data,
            'chart' => array()
        );

        $discounts = 0;
        $items = array();
        foreach ($data as $key => $value) {
            
            $hour = date('H', strtotime($value['created']));
            if( empty($items[$hour]) ){ $items[$hour] = 0; }

            foreach ($payment_types as $i => $types) {
                if( $types['id']==$value['pay_type'] ){

                    if( empty($arr['payment_types'][$types['name']]) ) $arr['payment_types'][$types['name']]=0;
                    $arr['payment_types'][$types['name']] += $value['costs'];
                }
            }

            $arr['payment_types']['total_discounts'] += $value['total_discounts'];
            $arr['payment_types']['sales_tax'] += $value['total_tax'];
            $arr['payment_types']['net_sales'] += $value['costs']-$value['total_tax']-$value['total_discounts'];

            $items[$hour] += $value['costs'];
        }

        // $arr['items'] = $items;

        $lists = array();
        for ($i=0; $i < 24; $i++) {             

            $h = $i < 10 ? "0$i": $i;
            $lists[] = !empty($items[$h]) ? $items[$h]: 0;
            $categories[] = $h;
        }


        $arr['chart']['series'][] = array(
            'borderWidth'=> 0,
            'borderColor'=> null,
            'data'=> $lists,
        );

        $arr['chart']['chart'] = array(
            'type' => 'line',
            'backgroundColor'=> null,
            'polar'=> true,
        );

        $arr['chart']['tooltip'] = array(
            'enabled'=>true,
            'formatter' => array(
                'name' => '',
                '_x' => '.00',
                'y_' => '฿'
            )
        );

        $arr['chart']['plotOptions'] = array(
            'column' => array(
                'dataLabels' => array( 'enabled'=> 'true' ),
                'enableMouseTracking' => false
            )
        );
  
        $arr['chart']['xAxis'] = array(
            'lineColor' => "#c0c0c0",
            'lineWidth' => 3,
            'tickWidth' => 0,
            'title' => array('text'=>null),
            'categories' => $categories
        );

        return $arr;
    }

    public function topmenu($start, $end){

        $arr = array(
            'options' => array(
                'start' => $start, 
                'end' => $end
            )
        );

        $arr['table']['head'][] = array('key'=>'name', 'label'=>'ชื่อ');
        $arr['table']['head'][] = array('key'=>'qty', 'label'=>'จำนวน');
        $data = $this->getTopmenu($start, $end);

        $total = 0;
        foreach ($data as $key => $value) {
            $total += $value['item_qty'];
            $arr['table']['body'][] = array(
                'name' => $value['food_name'],
                'qty' => $value['item_qty']
            );
        }

        $arr['total'] = $total;

        return $arr;
    }

    private function getTopmenu($start, $end, $_sort='DESC'){
        $end .= ' 23:59:59';
        $orders = $this->db->select("SELECT order_id as id FROM `orders` WHERE order_created BETWEEN :s AND :e ORDER BY order_qty DESC", array(':s'=>$start,':e'=>$end));

        $amenu = array();
        foreach ($orders as $i => $order) {
            $items = $this->db->select("SELECT 
                f.food_id, f.food_name, f.food_price,
                o.item_qty, o.item_price, o.item_created
                FROM orders_items o LEFT JOIN foods f ON f.food_id=o.item_food_id
                WHERE o.item_status=:status AND item_order_id=:oid 
                ORDER BY item_qty DESC",
            array(
                ':status' => 'done',
                ':oid' => $order['id']
            ));

            foreach ($items as $key => $item) {

                if( empty($amenu[ $item['food_id'] ]) ){
                    $amenu[ $item['food_id'] ] = $item;
                }
                else{
                    $amenu[ $item['food_id'] ]['item_qty'] += $item['item_qty'];
                }

            }
            
        }

        $sort = array();
        foreach ($amenu as $key => $value) {
            $sort[$key] = $value['item_qty'];
        }

        if( $_sort=='DESC' ){
            arsort($sort);
        }
        else{
            asort($sort);
        }

        $menu = array();
        foreach ($sort as $key => $value) {
            $menu[ $key ] = $amenu[$key];
        }

        return $menu;
    }

}