<?php

class System_Model extends Model{

    public function __construct() {
        parent::__construct();
    }

    /* Tax ID, Tax Rate */


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
    
    public function pageMenu()
    {
        $a = array();
        
        $a[] = array('id'=>'1','key'=>'dashboard','name'=>'Dashboard');
        $a[] = array('id'=>'2','key'=>'calendar','name'=>'นัดหมาย');
        $a[] = array('id'=>'3','key'=>'customers','name'=>'ประวัติลูกค้า');
        $a[] = array('id'=>'4','key'=>'booking','name'=>'รายการจองรถยนต์');
        $a[] = array('id'=>'5','key'=>'products','name'=>'สต็อกรถยนต์');
        $a[] = array('id'=>'6','key'=>'sales','name'=>'Sales');
        $a[] = array('id'=>'7','key'=>'services','name'=>'งานบริการ');
        $a[] = array('id'=>'8','key'=>'reports','name'=>'รายงาน');
        $a[] = array('id'=>'9','key'=>'settings','sub'=>'company','name'=>'รายละเอียดของบริษัท');
        $a[] = array('id'=>'10','key'=>'settings','sub'=>'dealer','name'=>'Dealer');
        $a[] = array('id'=>'11','key'=>'settings','sub'=>'my','name'=>'โปรไฟล์');
        $a[] = array('id'=>'12','key'=>'settings','sub'=>'accounts','page'=>'department','name'=>'แผนก');
        $a[] = array('id'=>'13','key'=>'settings','sub'=>'accounts','page'=>'position','name'=>'ตำแหน่ง');
        $a[] = array('id'=>'14','key'=>'settings','sub'=>'accounts','page'=>'employees','name'=>'พนักงาน');
        $a[] = array('id'=>'15','key'=>'settings','sub'=>'brands','name'=>'Brands');
        $a[] = array('id'=>'16','key'=>'settings','sub'=>'models','name'=>'Models');
        $a[] = array('id'=>'17','key'=>'settings','sub'=>'accessory','name'=>'ชุดแต่ง');
        $a[] = array('id'=>'18','key'=>'settings','sub'=>'accessory','page'=>'stores','name'=>'ตัวแทนจำหน่ายชุดแต่ง');
        $a[] = array('id'=>'19','key'=>'settings','sub'=>'booking','page'=>'status','name'=>'สถานะ');
        $a[] = array('id'=>'20','key'=>'settings','sub'=>'booking','page'=>'conditions','name'=>'เงื่อนไข');
        $a[] = array('id'=>'21','key'=>'settings','sub'=>'booking','page'=>'cus_refer','name'=>'แหล่งที่มาของลูกค้า');

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

    public function country(){
        return $this->db->select("SELECT country_id AS id, country_name AS name FROM countries ORDER By country_name ASC");
    }
    public function country_name($id){
        $sth = $this->db->prepare("SELECT country_name AS name FROM countries WHERE country_id=:id LIMIT 1");
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

        $a['-'] = array('id'=>'', 'name'=> '-');
        $a['Mr.'] = array('id'=>'Mr.', 'name'=> 'นาย');
        $a['Mrs.'] = array('id'=>'Mrs.', 'name'=> 'นาง');
        $a['Ms.'] = array('id'=>'Ms.', 'name'=> 'น.ส.');

        return array_merge($a, $options);
    }

    public function _prefixNameCustomer($options=array()){

        $a['-'] = array('id'=>'', 'name'=> '-');
        $a['Mr.'] = array('id'=>'Mr.', 'name'=> 'นาย');
        $a['Mrs.'] = array('id'=>'Mrs.', 'name'=> 'นาง');
        $a['Ms.'] = array('id'=>'Ms.', 'name'=> 'น.ส.');
        $a['Co'] = array('id'=>'Co', 'name'=> 'บจก.');
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

}