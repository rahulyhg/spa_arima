<?php

class System_Model extends Model{

    public function __construct() {
        parent::__construct();
    }

    /**/
    /* permit */
    /**/
    public function permit( $access=array() ) {

        $permit = array('view'=>0,'edit'=>0, 'del'=>0, 'add'=>0);

        // Settings
        $arr = array( 
            'notifications' => array('view'=>1),
            'calendar' => array('view'=>1),

            'my' => array('view'=>1,'edit'=>1),

            'customers' => array('view'=>1, 'add'=>1),
            'masseuse' => array('view'=>1, 'add'=>1),

            'package' => array('view'=>1),
            'promotions' => array('view'=>1),
            'coupon'=>array('view'=>1),

            'tasks' => array('view'=>1, 'add'=>1), 
        );

        // is admin 
        if( in_array(1, $access) ){ 

            // set settings
            $arr['company'] = array('view'=>1,'edit'=>1, 'del'=>1, 'add'=>1);  
            $arr['dealer'] = array('view'=>1,'edit'=>1, 'del'=>1, 'add'=>1);
            $arr['rooms'] = array('view'=>1,'edit'=>1, 'del'=>1, 'add'=>1);

            $arr['department'] = array('view'=>1,'edit'=>1, 'del'=>1, 'add'=>1);
            $arr['position'] = array('view'=>1,'edit'=>1, 'del'=>1, 'add'=>1);
            $arr['skill'] = array('view'=>1,'edit'=>1, 'del'=>1, 'add'=>1);
            $arr['employees'] = array('view'=>1,'edit'=>1, 'del'=>1, 'add'=>1);

            // customers
            $arr['level'] = array('view'=>1,'edit'=>1, 'del'=>1, 'add'=>1);
            $arr['paytype'] = array('view'=>1,'edit'=>1, 'del'=>1, 'add'=>1);

            // set menu
            $arr['dashboard'] = array('view'=>1);
            // $arr['events'] = array('view'=>1,'edit'=>1, 'del'=>1, 'add'=>0);

            $arr['package'] = array('view'=>1,'edit'=>1,'del'=>1, 'add'=>1);
            $arr['promotions'] = array('view'=>1,'edit'=>1,'del'=>1, 'add'=>1);
            $arr['coupon'] = array('view'=>1,'edit'=>1,'del'=>1, 'add'=>1);

            $arr['tasks'] = array('view'=>1,'edit'=>1, 'del'=>1, 'add'=>1);    
            $arr['reports'] = array('view'=>1);
        }

        /* Manage */
        if( in_array(2, $access) ){

            $arr['dashboard'] = array('view'=>1);
            $arr['employees'] = array('view'=>1,'edit'=>1, 'del'=>1, 'add'=>1);
      
            $arr['orders'] = array('view'=>1);
            $arr['booking'] = array('view'=>1);

            $arr['package'] = array('view'=>1,'edit'=>1,'del'=>1, 'add'=>1);
            $arr['promotions'] = array('view'=>1,'edit'=>1,'del'=>1, 'add'=>1);

            $arr['tasks'] = array('view'=>1,'edit'=>1, 'del'=>1, 'add'=>1);
            $arr['reports'] = array('view'=>1);
        }


        if( in_array(4, $access) ){
            $arr['pos'] = array('view'=>1,'edit'=>1,'del'=>1,'add'=>1);
        }


        return $arr;
    }


    public function set($name, $value) {
        $sth = $this->db->prepare("SELECT option_name as name FROM system_info WHERE option_name=:name LIMIT 1");
        $sth->execute( array(
            ':name' => $name
        ) );

        if( $sth->rowCount()==1 ){
            $fdata = $sth->fetch( PDO::FETCH_ASSOC );

            if( !empty($value) ){
                $this->db->update('system_info', array(
                    'option_name' => $name,
                    'option_value' => $value
                ), "`option_name`='{$fdata['name']}'");
            }
            else{
                $this->db->delete('system_info', "`option_name`='{$fdata['name']}'");
            }
        }
        else{

            if( !empty($value) ){
                $this->db->insert('system_info', array(
                    'option_name' => $name,
                    'option_value' => $value
                ));
            }
            
        }
    }

    public function get() {
        $data = $this->db->select( "SELECT * FROM system_info" );

        $object = array();
        foreach ($data as $key => $value) {
            $object[$value['option_name']] = $value['option_value'];
        }

        $contacts = $this->db->select( "SELECT contact_type as type, contact_name as name, contact_value as value FROM system_contacts" );


        $_contacts = array();
        foreach ($contacts as $key => $value) {
            $_contacts[ $value['type'] ][] = $value; 
        }

        $object['contacts'] = $_contacts;
        $object['navigation'] = $this->navigation();


        if( !empty($object['location_city']) ){
            
            $city_name = $this->getCityName( $object['location_city'] );
        }


        if( !empty($object['working_time_desc']) ){
            $object['working_time_desc'] = json_decode($object['working_time_desc'], true);
        }

        return $object;
    }

    public function setContacts($data) {
        
        $this->db->select("TRUNCATE TABLE system_contacts");

        foreach ($data as $key => $value) {

            $this->db->insert('system_contacts', array(
                'contact_type' => $value['type'],
                'contact_name' => $value['name'],
                'contact_value' => $value['value'],
            ));
        }
    }
    public function getCityName($id) {
        $sth = $this->db->prepare("SELECT city_name as name FROM city WHERE city_id=:id LIMIT 1");
        $sth->execute( array(
            ':id' => $id
        ) );

        
        $fdata = $sth->fetch( PDO::FETCH_ASSOC );
        return $fdata['name'];
    }

    public function navigation() {
        
        $a = array();
        $a[] = array('key'=>'index', 'url'=>URL, 'text'=>'Home');
        $a[] = array('key'=>'about-us', 'url'=>URL.'about-us', 'text'=>'About Us');
        $a[] = array('key'=>'services', 'url'=>URL.'services', 'text'=>'Services');
        $a[] = array('key'=>'contact-us', 'url'=>URL.'contact-us', 'text'=>'Contact Us');

        return $a;
    }
    
    public function pageMenu() {
        $a = array();

        $a[] = array('key'=>'dashboard', 'name'=>'Dashboard');
        // $a[] = array('key'=>'calendar', 'name'=>'นัดหมาย');
        $a[] = array('key'=>'customers', 'name'=>'ประวัติลูกค้า');
        $a[] = array('key'=>'booking', 'name'=>'รายการจองรถยนต์');
        $a[] = array('key'=>'stocks', 'name'=>'สต็อกรถยนต์');
        $a[] = array('key'=>'sales', 'name'=>'Sales');
        $a[] = array('key'=>'services', 'name'=>'งานบริการ');
        $a[] = array('key'=>'reports', 'name'=>'รายงาน');
        
        return $a;
    }

    public function city() {
        return $this->db->select("SELECT city_id as id, city_name as name FROM city ORDER BY city_name ASC");
    }
    public function city_name($id) {
        $sth = $this->db->prepare("SELECT city_name as name FROM city WHERE city_id=:id LIMIT 1");
        $sth->execute( array( ':id' => $id ) );

        $text = '';
        if( $sth->rowCount()==1 ){
            $fdata = $sth->fetch( PDO::FETCH_ASSOC );
            $text = $fdata['name'];
        }

        return $text;
    }

    /**/
    /* GET PAGE PERMISSION */
    /**/
    public function getPage($id) {

        $id = '';
        foreach ($this->pageMenu as $key => $value) {
            if( $id==$value['id'] ){
                 $id = $value['id'];
                break;
            }
        }

        return $id;
    }

    /**/
    /* Prefix Name */
    /**/
    public function _prefixName($options=array()){

        //$a['-'] = array('id'=>'', 'name'=> '-');
        $a['Mr.'] = array('id'=>'Mr.', 'name'=> $this->lang->translate('Mr.') );
        $a['Mrs.'] = array('id'=>'Mrs.', 'name'=> $this->lang->translate('Mrs.') );
        $a['Ms.'] = array('id'=>'Ms.', 'name'=> $this->lang->translate('Ms.') );

        return array_merge($a, $options);
    }

    public function _prefixNameCustomer($options=array()){

        //$a['-'] = array('id'=>'', 'name'=> '-');
        $a['Mr.'] = array('id'=>'Mr.', 'name'=> $this->lang->translate('Mr.') );
        $a['Mrs.'] = array('id'=>'Mrs.', 'name'=> $this->lang->translate('Mrs.') );
        $a['Ms.'] = array('id'=>'Ms.', 'name'=> $this->lang->translate('Ms.') );
        $a['Co'] = array('id'=>'Co.', 'name'=> $this->lang->translate('Co.') );
        //$a['Part'] = array('id'=>'Part', 'name'=>'หจก.');

        return array_merge($a, $options);
    }


    /* ยอมรับการชำระเงินแล้ว */
    public function paymentsAccepted( $options=array() ) {

        $a['cash'] = array('id'=>'cash', 'name'=> 'Cash');
        $a['cc'] = array('id'=>'cc', 'name'=> 'Credit Card');
        $a['dc'] = array('id'=>'dc', 'name'=> 'Debit Card');
        $a['check'] = array('id'=>'check', 'name'=> 'Check');
        $a['balance'] = array('id'=>'balance', 'name'=> 'Balance');
        $a['other'] = array('id'=>'other', 'name'=>'Other');

        return array_merge($a, $options);
    }


    public function status() {

        $a[] = array('id'=>'new', 'name'=> 'New', 'color'=>'#FF9801');
        $a[] = array('id'=>'online', 'name'=> 'Online', 'color'=>'#FF9801');
        $a[] = array('id'=>'canceled', 'name'=> 'Canceled', 'color'=>'#F00000');
        $a[] = array('id'=>'confirmed', 'name'=> 'Confirmed', 'color'=>'#3D8B40');
        $a[] = array('id'=>'arrived', 'name'=> 'Arrived', 'color'=>'#3D8B40'); // เข้ามาแล้ว
        $a[] = array('id'=>'payed', 'name'=> 'Payed', 'color'=>'#8CCB8E'); // จ่ายแล้ว
        $a[] = array('id'=>'completed', 'name'=> 'Completed', 'color'=>'#8CCB8E'); // เสร็จแล้ว
        $a[] = array('id'=>'no-show', 'name'=>'no-show', 'color'=>'#F00000'); // 
    
        // pending        
        return $a;
    }

    public function currency() {

        $a[] = array('id'=>"AUD", 'name'=>'Australian Dollar');
        $a[] = array('id'=>"ARS", 'name'=>'Argentina Peso');
        $a[] = array('id'=>"BRL", 'name'=>'Brazilian Real ');
        $a[] = array('id'=>"CAD", 'name'=>'Canadian Dollar');
        $a[] = array('id'=>"CZK", 'name'=>'Czech Koruna');
        $a[] = array('id'=>"DKK", 'name'=>'Danish Krone');
        $a[] = array('id'=>"EGP", 'name'=>'Egyptian Pound');
        $a[] = array('id'=>"EUR", 'name'=>'Euro');
        $a[] = array('id'=>"HKD", 'name'=>'Hong Kong Dollar');
        $a[] = array('id'=>"HUF", 'name'=>'Hungarian Forint ');
        $a[] = array('id'=>"ILS", 'name'=>'Israeli New Sheqel');
        $a[] = array('id'=>"JPY", 'name'=>'Japanese Yen');
        $a[] = array('id'=>"MYR", 'name'=>'Malaysian Ringgit');
        $a[] = array('id'=>"MXN", 'name'=>'Mexican Peso');
        $a[] = array('id'=>"NOK", 'name'=>'Norwegian Krone');
        $a[] = array('id'=>"NZD", 'name'=>'New Zealand Dollar');
        $a[] = array('id'=>"PHP", 'name'=>'Philippine Peso');
        $a[] = array('id'=>"PLN", 'name'=>'Polish Zloty');
        $a[] = array('id'=>"GBP", 'name'=>'Pound Sterling');
        $a[] = array('id'=>"SAR", 'name'=>'Saudi Riyal');
        $a[] = array('id'=>"SGD", 'name'=>'Singapore Dollar');
        $a[] = array('id'=>"SEK", 'name'=>'Swedish Krona');
        $a[] = array('id'=>"CHF", 'name'=>'Swiss Franc');
        $a[] = array('id'=>"TWD", 'name'=>'Taiwan New Dollar');
        $a[] = array('id'=>"THB", 'name'=>'Thai Baht');
        $a[] = array('id'=>"TRY", 'name'=>'Turkish Lira');
        $a[] = array('id'=>"VEF", 'name'=>'Venezuelan Bolívar');
        $a[] = array('id'=>"VND", 'name'=>'Vietnamese Dong');
        $a[] = array('id'=>"UAE", 'name'=>'Emirati Dirham');
        $a[] = array('id'=>"USD", 'name'=>'U.S. Dollar');

        return $a;
    }

    public function roles(){

        $a = array();
        $a[] = array('id'=>'1', 'name'=>'Admin');
        $a[] = array('id'=>'2', 'name'=>'ผู้จัดการ');
        $a[] = array('id'=>'3', 'name'=>'บุคคล');
        $a[] = array('id'=>'4', 'name'=>'Package');
        $a[] = array('id'=>'5', 'name'=>'แคชเชียร์');
        $a[] = array('id'=>'6', 'name'=>'พนง.บริการ');

        return $a;
    }


    public function working_time( $date ){

        if( empty($date) ) $date = date('c');

        $start = date('Y-m-d 05:00:00', strtotime($date));

        $end = new DateTime( $start );
        $end->modify('+1 day');
        $end = $end->format('Y-m-d 04:00:00');

        return array($start, $end);
    }

    public function skill_type(){

        $arr = array();
        $arr[] = array('id'=>1, 'name'=>'เสื้อชมพู');
        $arr[] = array('id'=>2, 'name'=>'เสื้อขาว');

        return $arr;
    }

}