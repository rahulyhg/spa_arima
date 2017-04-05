<?php

class Services_Model extends Model
{
    public function __construct() {
        parent::__construct();
    }

    private $_objName = "services";
    private $_table = "
    
    services s INNER JOIN (cars car
        LEFT JOIN (customers cus 
                LEFT JOIN city ON cus.cus_city_id=city.city_id) 
            ON car.car_cus_id=cus.cus_id
            
        LEFT JOIN (products p
            LEFT JOIN (
                products_models model 
                    LEFT JOIN dealer ON model_dealer_id=dealer_id
                    LEFT JOIN products_brands ON model_brand_id=brand_id)
            ON p.pro_model_id=model_id )
        ON car.car_pro_id=p.pro_id )
         
    ON car.car_id=s.service_car_id 
    
    LEFT JOIN employees emp ON emp.emp_id=s.service_emp_id
    LEFT JOIN employees tec ON tec.emp_id=s.service_tec_id";
    
    
    private $_field = "
          s.service_id
        , s.service_total_price
        , s.service_total_list
        , s.service_created
        , s.service_status
        , s.service_date_repair
        , s.service_is_owner

        , model_id, model_name
        , brand_id, brand_name
        , dealer_id, dealer_name
        , pro_id, pro_name
        , car.*
       
        , tec.emp_id            AS tec_id
        , tec.emp_prefix_name   AS tec_prefix_name 
        , tec.emp_first_name    AS tec_first_name
        , tec.emp_last_name     AS tec_last_name
        , tec.emp_nickname      AS tec_nickname
        , tec.emp_username      AS tec_username 
        , tec.emp_phone_number  AS tec_phone_number
        , tec.emp_display       AS tec_display
        , tec.emp_updated       AS tec_updated
        , tec.emp_email         AS tec_email
        , tec.emp_line_id       AS tec_line_id
        , tec.emp_mode          AS tec_mode 
        , tec.emp_address       AS tec_address
        , tec.emp_zip           AS tec_zip
        , tec.emp_city_id       AS tec_city_id
        , tec.emp_image_id      AS tec_image_id
               
        , emp.emp_id
        , emp.emp_prefix_name
        , emp.emp_first_name
        , emp.emp_last_name
        , emp.emp_nickname
        , emp.emp_username
        , emp.emp_phone_number
        , emp.emp_display
        , emp.emp_updated
        , emp.emp_email
        , emp.emp_line_id
        , emp.emp_mode
        , emp.emp_address
        , emp.emp_zip
        , emp.emp_city_id           
        , emp.emp_image_id

        , cus_id
        , cus_prefix_name
        , cus_first_name
        , cus_last_name
        , cus_nickname
        , cus_created
        , cus_updated
        , cus_birthday
        , cus_card_id
        , cus_phone
        , cus_email
        , cus_lineID
        , cus_bookmark
        , cus_address
        , cus_zip
        , cus_city_id
        , city_name as cus_city_name";

    private $_cutNamefield = "service_";

    public function lists( $options=array() ) {

        $options = array_merge(array(
            'pager' => isset($_REQUEST['pager'])? $_REQUEST['pager']:1,
            'limit' => isset($_REQUEST['limit'])? $_REQUEST['limit']:50,

            'sort' => isset($_REQUEST['sort'])? $_REQUEST['sort']: 'created',
            'dir' => isset($_REQUEST['dir'])? $_REQUEST['dir']: 'DESC',

            'time'=> isset($_REQUEST['time'])? $_REQUEST['time']:time(),
            'q' => isset($_REQUEST['q'])? $_REQUEST['q']:'',

            'more' => true
            ), $options);

        if( isset($_REQUEST['view_stype']) ){
            $options['view_stype'] = $_REQUEST['view_stype'];
        }

        $date = date('Y-m-d H:i:s', $options['time']);

        $where_str = "";
        $where_arr = array();

        if( isset($options['not']) ){
            $where_str .= !empty( $where_str ) ? " AND ":'';
            $where_str = "{$this->_cutNamefield}id!=:not";
            $where_arr[':not'] = $options['not'];
        }

        if( !empty($options['q']) ){

            $arrQ = explode(' ', $options['q']);
            $wq = '';
            foreach ($arrQ as $key => $value) {
                $wq .= !empty( $wq ) ? " OR ":'';
                $wq .= "cus_first_name LIKE :q{$key} OR cus_first_name=:f{$key} OR cus_last_name LIKE :q{$key} OR cus_last_name=:f{$key} OR cus_phone LIKE :s{$key} OR cus_phone=:f{$key} OR cus_email LIKE :s{$key} OR cus_email=:f{$key} OR cus_card_id=:f{$key}";
                $where_arr[":q{$key}"] = "%{$value}%";
                $where_arr[":s{$key}"] = "{$value}%";
                $where_arr[":f{$key}"] = $value;
            }

            if( !empty($wq) ){
                $where_str .= !empty( $where_str ) ? " AND ":'';
                $where_str .= "($wq)";
            }
        }

        if( !empty($_REQUEST['status']) ){
            $options['status'] = $_REQUEST['status'];

            $where_str .= !empty( $where_str ) ? " AND ":'';
            $where_str .= "service_status=:status";
            $where_arr[':status'] = $options['status'];
        }
         if( !empty($_REQUEST['services']) or !empty($options['services']) ){  
            $options['services'] = !empty($_REQUEST['services'])?$_REQUEST['services']:$options['services'];     
            $where_str .= !empty( $where_str ) ? " AND ":'';
            $where_str .= "service_cus_id=:services";
            $where_arr[':services'] = $options['services'];
         
        }

        if( ( !empty($_REQUEST['period_start']) && !empty($_REQUEST['period_end']) ) || ( !empty($options['period_start']) && !empty($options['period_end']) ) ){

            $period_start = !empty($options['period_start']) ? $options['period_start'] : $_REQUEST['period_start'];
            $period_end = !empty($options['period_end']) ? $options['period_end'] : $_REQUEST['period_end'];

            $where_str .= !empty( $where_str ) ? " AND ":'';
            $where_str .= "service_date_repair BETWEEN :startDate AND :endDate";
            $where_arr[':startDate'] = $period_start;
            $where_arr[':endDate'] = $period_end;
        }

        $arr['total'] = $this->db->count($this->_table, $where_str, $where_arr);

        $where_str = !empty($where_str) ? "WHERE {$where_str}":'';
        $orderby = $this->orderby( $this->_cutNamefield.$options['sort'], $options['dir'] );
        $limit = $this->limited( $options['limit'], $options['pager'] );
     //echo "SELECT {$this->_field} FROM {$this->_table} {$where_str} {$orderby} {$limit}"; die;
        $arr['lists'] = $this->buildFrag( $this->db->select("SELECT {$this->_field} FROM {$this->_table} {$where_str} {$orderby} {$limit}", $where_arr ), $options );

        if( ($options['pager']*$options['limit']) >= $arr['total'] ) $options['more'] = false;
        $arr['options'] = $options;

        return $arr;
    }
    public function get($id, $options=array()){
        $select = $this->_field;

        $sth = $this->db->prepare("SELECT {$select} FROM {$this->_table} WHERE {$this->_cutNamefield}id=:id LIMIT 1");
        $sth->execute( array(
            ':id' => $id
            ) );

        return $sth->rowCount()==1
        ? $this->convert( $sth->fetch( PDO::FETCH_ASSOC ), $options )
        : array();
    }
    public function buildFrag($results, $options=array()) {
        $data = array();

        $view_stype = !empty($options['view_stype']) ? $options['view_stype']:'convert';
        if( !in_array($view_stype, array('bucketed', 'convert')) ) $view_stype = 'convert';

        foreach ($results as $key => $value) {
            if( empty($value) ) continue;
            $data[] = $this->{$view_stype}($value);
        }
        return $data;
    }

    public function bucketed($data){

        $prefix = '';

        $data = $this->convert( $data );

        $text = $data['pro']['name'];
        $subtext = 'ทะเบียน: '.$data['car']['license_plate'];
        $category = $data['cus']['fullname'];
        //pro

        return array(
            'id'=> $data['id'],
            'created' => $data['created'],
            'text'=> isset($text)?$text:"",
            "category"=>isset($category)?$category:"",
            "subtext"=>isset($subtext)?$subtext:"",
            "image_url"=>isset($image_url)?$image_url:"",
            'status' => isset($status)?$status:"",
            'data' => $data,
        );
    }

    public function convert($data, $options=array()){

        $_data = $this->cut($this->_cutNamefield, $data);

        $data = array();
        foreach ($_data as $key => $value) {
            $ex = explode('_', $key, 2);

            if( in_array($ex[0], array('sale', 'cus', 'product', 'model', 'car', 'brand','dealer', 'pro', 'emp', 'tec') ) && count($ex)==2 ){
                $data[ $ex[0] ][ $ex[1] ] = $value;
            }
            else{
                $data[ $key ] = $value;
            }
        }

        $data['cus'] = $this->query('customers')->convert( $data['cus'] );
        $data['emp'] = $this->query('employees')->convert( $data['emp'] );
        $data['tec'] = $this->query('employees')->convert( $data['tec'] );

        $data['status'] = $this->getStatus( $data['status'] );
        $data['sender'] = $this->getSender( $data['id'] );

        if( empty($data['is_owner']) ){
            $data['sender'] = $this->getSender( $data['id'] );
        }

        $data['options'] = $this->getOptions( $data['id'] );

        // print_r($data); die;
        // $data['sale'] = $this->query('employees')->convert( $data['sale'] );

        $data['permit']['del'] = true;
        return $data;
    }
    public function getSender($id) {
        $sth = $this->db->prepare("SELECT sender.*, p.sender_note FROM services_sender_premit p INNER JOIN services_sender sender ON p.sender_id=sender.sender_id WHERE p.service_id=:id LIMIT 1");
        $sth->execute( array( ':id' => $id ) );

        return $sth->rowCount()==1 ? $sth->fetch( PDO::FETCH_ASSOC ): array();
    }


    private function _setDate($data){

        $data['service_created'] = date('c');
        return $data;
    }

    private function _setEvent($data){

        $data['event_created'] = date('c');
        $data['event_updated'] = date('c');
        return $data;
    }

    public function insert(&$data) {

        $this->db->insert( $this->_objName, $this->_setDate($data) );
        $data['service_id'] = $this->db->lastInsertId();

        $data = $this->cut($this->_cutNamefield, $data);
    }
    public function update($id, $data) {
        $this->db->update( $this->_objName, $data, "`{$this->_cutNamefield}id`={$id}" );
    }
    public function delete($id) {
        $this->db->delete( $this->_objName, "`{$this->_cutNamefield}id`={$id}" );
    }

    /**/
    /* Sender */
    /**/
    public function insertSender($data) {

        $this->db->insert('services_sender', $data);
    }

    /**/
    /* CAR COLOR */
    /**/
    public function get_color($id){

        $data = $this->db->select("SELECT color_id AS id, color_name AS name, color_primary AS code FROM products_models_colors WHERE color_id={$id}");

        return $data[0];
    }

    /**/
    /* CAR */
    /**/
    public function insertCar(&$data){

        $data['car_created'] = date('c');
        $data['car_updated'] = date('c');


        $this->db->insert('cars', $data);
        $data['car_id'] = $this->db->lastInsertId();
    }

    public function updateCar($id, $data){

        $data['car_updated'] = date('c');
        $this->db->update('cars', $data, "`car_id`={$id}");
    }

    /**/
    /* SET OPTION */
    /**/
    public function set_option($data){
        $this->db->insert('services_options', $data);
    }

    /**/
    /*  Services Status  */
    /**/
    public function status(){
        $a[] = array('id'=>'due','name'=>'นัดหมาย', 'color'=>'#ea8006');
        $a[] = array('id'=>'run','name'=>'กำลังซ่อม', 'color'=>'#1a8aca');
        $a[] = array('id'=>'finish','name'=>'ส่งมอบ', 'color'=>'#bb2244');
        $a[] = array('id'=>'cancel','name'=>'ยกเลิก', 'color'=>'#cccccc');

        return $a;
    }
    public function getStatus($id) {
        $data = array();
        foreach ($this->status() as $key => $value) {
            if( $value['id'] == $id ){
                $data = $value; break;
            }
        }

        return $data;
        
    }

    /**/
    /* Services Options */
    /**/
    public function getOptions($id){

        return $this->db->select("SELECT sop_name AS name , sop_value AS value FROM services_options WHERE sop_ser_id={$id}");
    }

    /**/
    /* Check type form */
    /**/
    public function check_form(&$data){

        $data = $data['post'];

        if( $data['type_form'] == 'owner' ){

            if( empty($data['cus']['id']) ){

                foreach ($data['cus'] as $key => $value) {

                    if( empty($value) && $key != 'lineID' && $key != 'nickname' ){

                        if( $key == 'first_name' ){
                            $data['error']['cus_name'] = 'กรอกข้อมูลให้ครบ';
                        }
                        // else{
                        //     $data['error']['cus_'.$key] = 'กรุณากรอกข้อมูล';
                        // }
                    }
                }

                // $options = $data['cus']['options'];
                // foreach ($options as $type => $values) {
                //     foreach ($values['name'] as $key => $val) {
                //         if( $type == 'phone'){
                //             if( empty($values['value'][$key]) ){
                //                 $data['error']['cus_options_phone'] = 'กรุณากรอกเบอร์โทรศัพท์';
                //             }
                //         }
                //     }
                // }

                // if( !empty($data['cus']['address']) ){

                //     foreach ($data['cus']['address'] as $key => $value) {

                //         if( empty($value) && $key != 'village' && $key !='street' && $key != 'alley'){
                //             $data['error']['cus_address'] = 'กรอกข้อมูลที่อยู่ให้ครบถ้วน';
                //         }

                //         if( $key == 'zip' ){
                //             if( strlen($value) != '5' ){
                //                 $data['error']['cus_address'] = 'กรุณากรอกรหัสไปรษณีย์ให้ครบ 5 หลัก';
                //             }
                //         }
                //     }
                // }


                // $futureDate = date('Y-m-d',strtotime(date("Y-m-d", mktime()) . " -6 year"));
                // $birthday = date("{$data['birthday']['year']}-{$data['birthday']['month']}-{$data['birthday']['date']}");
                // if( strtotime($birthday) > strtotime($futureDate) ){
                //     $arr['error']['birthday'] = 'วันเกิดไม่ถูกต้อง';
                // }

                // if( strlen($data['cus']['card_id']) != '13' ){
                //     $arr['error']['cus_card_id'] = 'กรุณากรอกรหัสบัตรประชาชนให้ถูกต้อง';
                // }
            }
        }

        if( $data['type_form'] == 'sender' ){

            if( $data['sender']['is_owner'] == 0 ){
                foreach ($data['sender'] as $key => $value) {
                    if( $key == 'is_owner' ) continue;

                    if( empty($value) && $key !='tel' && $key !='line_id' && $key != 'note' ){
                        $data['error']['sender_name'] = 'กรุณากรอกข้อมูลให้ครบถ้วน (โทรศัพท์บ้าน/ทำงาน , Line ID และ หมายเหตุ สามารถเว้นว่างได้)';
                    }
                }
            }
        }

        if( $data['type_form'] == 'car' ){

            foreach ($data['car'] as $key => $value) {
                if( empty($value) ){
                    if( $key == 'red_plate' || $key == 'plate' ) continue;
                    $data['error']['car_'.$key] = 'กรุณากรอกข้อมูล';
                }
            }

        }

        if( $data['type_form'] == 'items' ){

            $list = 0;

            for($i=0;$i<count($data['items']);$i++){
                if( empty($data['items']['name'][$i]) || empty($data['items']['value'][$i]) ) continue;
                $list++;
            }

            if( empty($list) ){
                $data['error']['items'] = 'กรุณาระบุรายการอย่างน้อย 1 รายการ';
            }

            if( empty($data['service']['tec_id']) ){
                $data['error']['service_tec_id'] = 'กรุณาเลือกช่างซ่อม';
            }
        }

        if($data['type_form'] == 'save'){

            /**/
            /* SET OWNER */
            /**/
            $cus = array();
            if( empty($data['cus']['id']) ){

                foreach ($data['cus'] as $key => $value) {
                    if( $key == 'address' || $key == 'options' ) continue;
                    $cus['cus_'.$key] = $value;
                }
                $futureDate = date('Y-m-d',strtotime(date("Y-m-d", mktime()) . " -6 year")); // 2554 // 2011
                $birthday = date("{$data['birthday']['year']}-{$data['birthday']['month']}-{$data['birthday']['date']}");

                $cus['cus_address'] = json_encode($data['cus']['address']);
                $cus['cus_zip'] = $data['cus']['address']['zip'];
                $cus['cus_city_id'] = $data['cus']['address']['city'];
                $cus['cus_birthday'] = $birthday;
                $cus['cus_created'] = date('c');
                $this->db->insert( 'customers', $cus );
                $cus_id = $this->db->lastInsertId();

                /**/
                /* SET OPTIONS */
                /**/
                $options = $data['cus']['options'];
                $cus_options = array();
                foreach ($options as $type => $values) {

                    foreach ($values['name'] as $key => $val) {

                        //if( empty($values['value'][$key]) ) continue;

                        if( $type == 'phone'){
                            $cus['cus_phone'] = trim($values['value'][$key]);
                        }

                        if( $type == 'social'){
                            $cus['cus_lineID'] = trim($values['value'][$key]);
                        }

                        if( $type == 'email' ){
                            $cus['cus_email'] = trim($values['value'][$key]);
                        }

                        $cus_options[$type][] = array(
                            'type' => $type,
                            'label' => trim($val), 
                            'value' => trim($values['value'][$key])
                            );
                    }
                }

                if( !empty($data['address']) ){

                    $cus['cus_address'] = json_encode($data['address']);
                    $cus['cus_zip'] = $data['address']['zip'];
                    $cus['cus_city_id'] = $data['address']['city'];
                }

                if( empty($data['cus']['id']) ){
                    $this->db->update('customers', $cus, "`cus_id`={$cus_id}");
                }

                foreach ($cus_options as $key => $values) {
                    foreach ($values as $lists) {
                        $lists['cus_id'] = $cus_id;
                        $this->query('customers')->set_option( $lists );  
                    }
                }
            }
            else{
                $cus_id = $data['cus']['id'];
            }

            /**/
            /* SET Service */
            /**/
            $service = array( 
                'service_emp_id'=>$data['me'], 
                'service_cus_id'=>$cus_id
            );
            $this->insert($service);
            $ser_id = $service['id'];

            /**/
            /* SET Sender */
            /**/
            $sender = array();
            if( $data['sender']['is_owner'] == '0' ){

                foreach ($data['sender'] as $key => $value) {

                    if( $key == 'is_owner' ) continue;
                    $sender['sender_'.$key] = $value;
                }

                $sender['sender_service_id'] = $ser_id;
                $this->insertSender( $sender );
            }

            /**/
            /* SET car */
            /**/
            if( empty($data['car']['id']) ){
                $car = array();
                foreach ($data['car'] as $key => $value) {
                    if( $key == 'model_id' || $key == 'color_id') continue;

                    $car['car_'.$key] = $value;
                }

                $color = $this->get_color($data['car']['color_id']);

                $car['car_color_code'] = $color['code'];
                $car['car_color_text'] = $color['name'];
                $car['car_emp_id'] = $data['me'];
                $car['car_cus_id'] = $cus_id;

                $this->insertCar($car);
                $car_id = $car['car_id'];
            }
            else{

                $car['car_plate'] = !empty($data['car']['plate']) ? $data['car']['plate']:'';
                $car['car_red_plate'] = !empty($data['car']['red_plate']) ? $data['car']['red_plate']:'';
                $car['car_mile'] = $data['car']['mile'];
                $this->updateCar($data['car']['id'], $car);
                $car_id = $data['car']['id'];
            }

            /**/
            /* SET item  */
            /**/
            $amount = 0;
            $total_list = 0;
            for($i=0;$i<count($data['items']);$i++){

                if( empty($data['items']['name'][$i]) || empty($data['items']['value'][$i]) ) continue;

                $option = array(
                    'sop_ser_id'=>$ser_id,
                    'sop_name'=>$data['items']['name'][$i],
                    'sop_value'=>$data['items']['value'][$i],
                    );

                $amount = $amount + $data['items']['value'][$i];
                $total_list++;

                $this->set_option($option);
            }

            /**/
            /* SET Event */
            /**/

            if( !empty($data['event']['title']) && !empty($data['event']['detail']) && !empty($data['event']['when']) ){

                $event = array();
                foreach ($data['event'] as $key => $value) {

                    $event['event_'.$key] = $value;
                }

                //$event['event_cus_id'] = $cus_id;
                $event['event_emp_id'] = $data['me'];
                $this->query('events')->insert($event);

                $join[] = array(
                    'event_id'=>$event['event_id'],
                    'obj_id'=>$ser_id,
                    'obj_type'=>'services',
                    );

                $join[] = array(
                    'event_id'=>$event['event_id'],
                    'obj_id'=>$cus_id,
                    'obj_type'=>'customers',
                    );

                foreach ($join as $key => $value) {
                    $this->query('events')->insertJoinEvent($value);
                }
            }

            $status = 'run';

            $datenow = date('Y-m-d');
            if( $data['service']['date'] > $datenow){
                $status = 'due';
            }

            $update_ser = array(
                'service_tec_id'=>$data['service']['tec_id'],
                'service_date_repair'=>$data['service']['date'],
                'service_is_owner'=>$data['sender']['is_owner'],
                'service_car_id'=>$car_id,
                'service_total_price'=>$amount,
                'service_total_list'=>$total_list,
                'service_status'=>$status,
                );

            $this->update($ser_id ,$update_ser);

            $data['message'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
            $data['url'] = URL.'services/'.$ser_id;
        }

        return $data;
    }

}