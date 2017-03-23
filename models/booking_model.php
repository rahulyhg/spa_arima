<?php

class Booking_Model extends Model
{
    public function __construct() {
        parent::__construct();
    }

    private $_objName = "booking";
    private $_table = "booking b

    LEFT JOIN (employees sale 
        LEFT JOIN emp_department dep ON sale.emp_dep_id=dep.dep_id 
        LEFT JOIN emp_position position ON sale.emp_pos_id=position.pos_id
        LEFT JOIN city ON sale.emp_city_id=city.city_id )
    ON b.book_sale_id=sale.emp_id

    LEFT JOIN book_cus_refer refer ON refer.refer_id=b.book_cus_refer
    LEFT JOIN products_models_colors color ON color.color_id=b.book_color

    LEFT JOIN (
        customers c 
            LEFT JOIN city c1ty ON c.cus_city_id=c1ty.city_id
        )
    ON b.book_cus_id=c.cus_id

    LEFT JOIN (
        products p 
            LEFT JOIN (
            products_models model 
                LEFT JOIN products_brands brand ON model.model_brand_id=brand.brand_id
                LEFT JOIN dealer ON model.model_dealer_id=dealer.dealer_id
            )
        ON p.pro_model_id=model.model_id) 
    ON b.book_pro_id=p.pro_id
    ";
    private $_field = "
          b.book_id
        , b.book_created
        , b.book_cus_refer
        , b.book_number
        , b.book_page
        , b.book_date
        , b.book_status
        , b.book_updated
        , b.book_pro_price

        , b.book_sale_id AS sale_id
        , sale.emp_prefix_name AS sale_prefix_name
        , sale.emp_first_name AS sale_first_name
        , sale.emp_last_name AS sale_last_name
        , sale.emp_nickname AS sale_nickname
        , sale.emp_phone_number AS sale_phone_number
        , sale.emp_email AS sale_email
        , sale.emp_line_id AS sale_line_id
        , dep.dep_is_sale AS sale_dep_is_sale
        , city.city_name as sale_city_name

        , c.cus_id
        , c.cus_prefix_name
        , c.cus_first_name
        , c.cus_last_name
        , c.cus_nickname
        , c.cus_email
        , c.cus_phone
        , c.cus_lineID
        , c.cus_address
        , c1ty.city_name as cus_city_name

        , p.pro_name as product_name
        , p.pro_mfy as product_mfy
        , p.pro_cc as product_cc

        , model_id, model_name
        , brand_id, brand_name
        , dealer_id, dealer_name
        , pro_id, pro_name

        , refer_id, refer_name
        , color.color_id, color.color_name, color.color_primary
    ";
    private $_cutNamefield = "book_";

    public function lists( $options=array() ) {

        $options = array_merge(array(
            'pager' => isset($_REQUEST['pager'])? $_REQUEST['pager']:1,
            'limit' => isset($_REQUEST['limit'])? $_REQUEST['limit']:50,

            'sort' => isset($_REQUEST['sort'])? $_REQUEST['sort']: 'date',
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
                $wq .= "cus_first_name LIKE :q{$key} OR cus_first_name=:f{$key} OR cus_last_name LIKE :q{$key} OR cus_last_name=:f{$key} OR cus_phone LIKE :s{$key} OR cus_phone=:f{$key} OR cus_email LIKE :s{$key} OR cus_email=:f{$key} OR cus_card_id=:f{$key} OR book_page=:f{$key} OR book_number=:f{$key} OR emp_first_name=:f{$key} OR emp_last_name=:f{$key}";
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
            $where_str .= "book_status=:status";
            $where_arr[':status'] = $options['status'];
        }

        if( !empty($_REQUEST['period_start']) && !empty($_REQUEST['period_end']) ){

            $options['period_start'] = date("Y-m-d 00:00:00", strtotime($_REQUEST['period_start']));
            $options['period_end'] = date("Y-m-d 23:59:59", strtotime($_REQUEST['period_end']));

            $where_str .= !empty( $where_str ) ? " AND ":'';
            $where_str .= "book_date BETWEEN :startDate AND :endDate";
            $where_arr[':startDate'] = $options['period_start'];
            $where_arr[':endDate'] = $options['period_end'];
        }

        if( !empty($_REQUEST['sale']) ){
            $options['sale'] = $_REQUEST['sale'];

            $where_str .= !empty( $where_str ) ? " AND ":'';
            $where_str .= "book_sale_id=:sale";
            $where_arr[':sale'] = $options['sale'];
        }

        $arr['total'] = $this->db->count($this->_table, $where_str, $where_arr);

        $where_str = !empty($where_str) ? "WHERE {$where_str}":'';
        $orderby = $this->orderby( $this->_cutNamefield.$options['sort'], $options['dir'] );
        $limit = $this->limited( $options['limit'], $options['pager'] );
        $arr['lists'] = $this->buildFrag( $this->db->select("SELECT {$this->_field} FROM {$this->_table} {$where_str} {$orderby} {$limit}", $where_arr ), $options );


        if( ($options['pager']*$options['limit']) >= $arr['total'] ) $options['more'] = false;
        $arr['options'] = $options;

        return $arr;
    }
    public function get($id, $options=array()){
        $select = $this->_field;

        $select.="
            , b.book_pay_type, b.book_pay_type_options
            , b.book_deposit, b.book_deposit_type, b.book_deposit_type_options

            , b.book_net_price
            , b.book_pro_price AS product_price

            , b.book_accessory_price
        ";  

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
        foreach ($this->query('customers')->prefixName() as $key => $value) {
            if( $value['id']==$data['cus_prefix_name'] ){
                $prefix = $value['name'];
                break;
            }
        }

        $text = "{$prefix}{$data['cus_first_name']} {$data['cus_last_name']}";

        $status = array(
            'id' => $data['status_id'],
            'name' => $data['status_label'],
            'color' => $data['status_color'],
        );

        $category = $data['product_name'];

        $subtext = '';
        $a = array('cus_phone', 'cus_email', 'cus_lineID');
        foreach ($a as $key) {
            if( !empty($data[$key]) ) {
                $subtext .= !empty($subtext) ?', ':'';
                $subtext .= $data[$key];
            }
        }

        return array(
            'id'=> $data['book_id'],
            'created' => $data['book_created'],
            'options' => array(
                'time' => 'disabled'
                ),
            'text'=> $text,
            "category"=>isset($category)?$category:"",
            "subtext"=>isset($subtext)?$subtext:"",
            "image_url"=>isset($image_url)?$image_url:"",
            'status' => $status,
            // 'data' => $data,
         );
    }
    public function convert($data, $options=array()){

        $data =$this->cut($this->_cutNamefield, $data);
        if( empty($data['is_convert']) ){
            $data = $this->_convert( $data );
        }

        $data['status'] = $this->getStatus( $data['status'] );

        if( !empty($data['pay_type']) ){
            $data['pay_type'] = $this->get_pay_type( $data['pay_type'] );

            if( !empty($data['pay_type_options']) ){
                $data['pay_type']['options'] = json_decode($data['pay_type_options'], true);
            }

            unset($data['pay_type_options']);
        }

        if( !empty($data['deposit_type']) ){
            $data['deposit_type'] = $this->get_pay_type( $data['deposit_type'] );

            if( !empty($data['deposit_type_options']) ){

                $data['deposit_options'] = json_decode($data['deposit_type_options'], true);
            }

            unset($data['deposit_type_options']);
        }

        if( !empty($options['accessory']) ){

            // print_r($this->accessory( $data['id'] )); die;
            $data['accessory'] = $this->listsAccessory( $data['id'] );
        }

        if( !empty($options['conditions'])  ){
            $data['conditions'] = $this->listsConditions( $data['id'] );

            $data['conditions'][] = array(
                // 'name' => 'ค่ารถยนต์/Car price',
                'value' => $data['product']['price'],
                'keyword' => 'carprice',
                'type' => 'income'
            );
            
            // print_r($data['conditions']); die;
        }

        $data['insurance'] = $this->get_insurance( $data['id'] );
        
        $data['permit']['del'] = true;
        return $data;
    }

    private function _setDate($data){
        $data['book_created'] = date('c');
        if( !isset($data['book_updated']) ){
            $data['book_updated'] = date('c');
        }

        return $data;
    }
    public function insert(&$data) {

        $models = $this->query('models')->get($data['book_model_id']);
        $products = $this->query('products')->get($data['book_pro_id']);
        //$pro['pro_balance'] = $products['balance'] - 1;
        $pro['pro_booking'] = $products['booking'] + 1;
        $model['model_amount_reservation'] = $models['amount_reservation'] + 1;

        if( !empty($products['balance']) && $pro['pro_booking'] <= $products['balance'] ){
            $pro['pro_subtotal'] = $products['balance'] + $pro['pro_booking'];
            $model['model_amount_total'] = $models['amount_total'] + 1;
        }
        else{
            $pro['pro_order_total'] = $products['order_total'] + 1;
            $model['model_amount_order'] = $models['amount_order'] + 1;
        }

        /* UPDATE BALANCE MODEL & PRODUCTS */
        $this->db->update('products', $pro, "`pro_id`={$data['book_pro_id']}");
        $this->db->update('products_models', $model, "`model_id`={$data['book_model_id']}");

        $this->db->insert( $this->_objName, $this->_setDate($data) );
        $data['book_id'] = $this->db->lastInsertId();
    }

    public function update($id, $data){
        $this->db->update( $this->_objName, $this->_setDate($data), "`book_id`={$id}" );
    }
    public function delete($id) {
        $this->db->delete( $this->_objName, "`book_id`={$id}" );
        $this->db->delete( 'booking_insurance', "`ins_book_id`={$id}" );
        $this->del_accessory( $id );
        $this->del_condition( $id );
    }

    /**/
    /* Booking Check */
    /**/
    public function has_page($page, $number) {
        return $this->db->count($this->_objName, "{$this->_cutNamefield}page='{$page}' AND {$this->_cutNamefield}number='{$number}'");
    }
    

    /**/
    /*  Booking Status  */
    /**/
    // public function status(){
    //     // , , status_color as color
    //     return $this->db->select("SELECT status_id as id, status_label as name, status_lock as is_lock, status_enable as enable, status_color as color FROM book_status ORDER BY status_order ASC");
    // }
    public function get_status($id){
        $sth = $this->db->prepare("
            SELECT status_id as id, status_label as name, status_lock as is_lock, status_enable as enable, status_color as color
            FROM book_status 
            WHERE `status_id`=:id 
            LIMIT 1");
        $sth->execute( array( ':id' => $id ) );

        return $sth->rowCount()==1 ? $sth->fetch( PDO::FETCH_ASSOC ) : array();
    }
    public function insert_status(&$data) {
        $this->db->insert( 'book_status', $data );
        $data['status_id'] = $this->db->lastInsertId();
    }
    public function update_status($id, $data){
        $this->db->update( 'book_status', $data, "`status_id`={$id}" );
    }
    public function delete_status($id){
        $this->db->delete( 'book_status', "`status_id`={$id}" );
    }

    /**/
    /*  Booking Conditions  */
    /**/
    private $select_conditions = "
          con.con_value AS value
        , CASE con.con_has_etc
            WHEN 0 THEN parent.condition_name
            ELSE con.con_name
        END AS name

        , CASE con.con_has_etc
            WHEN 0 THEN parent.condition_id
            ELSE 0
        END AS condition_id

        , con_type AS type
        , con_has_etc AS has_etc
    ";
    public function listsConditions($id) {
        
        return $this->db->select("
            SELECT {$this->select_conditions}
            FROM booking_condition con
                LEFT JOIN book_conditions parent ON parent.condition_id=con.con_name
            WHERE con_book_id=:id ORDER BY con_has_etc ASC", array(':id'=>$id));
    }

    private $select_book_conditions = "
        condition_id as id,
        condition_name as name,
        condition_income as income,
        condition_lock as has_lock,
        condition_keyword as keyword
    ";
    public function conditions(){
        return $this->db->select("SELECT {$this->select_book_conditions} FROM book_conditions ORDER BY condition_order ASC"); 
    }
    public function get_condition($id){
        $sth = $this->db->prepare("SELECT {$this->select_book_conditions} FROM book_conditions WHERE `condition_id`=:id LIMIT 1");
        $sth->execute( array( ':id' => $id ) );

        return $sth->rowCount()==1 ? $sth->fetch( PDO::FETCH_ASSOC ) : array();
    }
    public function insert_condition(&$data){
        $this->db->insert('book_conditions', $data);
        $data['condition_id'] = $this->db->lastInsertId();
    }
    public function update_condition($id, $data) {
        $this->db->update('book_conditions', $data, "`condition_id`={$id}");
    }

    /**/
    /*  dealer  */
    /**/
    public function dealer() {
        return $this->db->select("SELECT dealer_id as id, dealer_name as name FROM dealer");
    }

    /**/
    /*  models  */
    /**/
    public function models() {
        return $this->db->select("SELECT model_id as id, model_name as name FROM products_models");
    }

    /**/
    /*  products  */
    /**/
    public function get_product() {

        $where_str = '';
        $where_arr = array();

        if( isset($_REQUEST['model']) ){
            $where_str .= !empty($where_str) ? " AND ":'';
            $where_str .= "`pro_model_id`=:model";
            $where_arr[':model'] = trim($_REQUEST['model']);
        }

        $where_str = !empty($where_str) ? " WHERE {$where_str}": '';
        $data = $this->db->select("SELECT pro_id as id, pro_name as name, pro_price as price FROM products{$where_str}", $where_arr);

        return $data;
    }

    public function get_color() {

        $where_str = '';
        $where_arr = array();

        if( isset($_REQUEST['model']) ){
            $where_str .= !empty($where_str) ? " AND ":'';
            $where_str .= "`color_model_id`=:model";
            $where_arr[':model'] = trim($_REQUEST['model']);
        }

        $where_str = !empty($where_str) ? " WHERE {$where_str}": '';
        $data = $this->db->select("SELECT color_id as id, color_name as name, color_primary as code FROM products_models_colors{$where_str}", $where_arr);

        return $data;
    }

    public function lists_vin( $pro_id , $color_id ){

        return $this->db->select("SELECT item_pro_id AS pro_id , item_id AS id , item_color AS color , item_vin AS vin , item_engine AS engine FROM products_items WHERE item_pro_id={$pro_id} AND item_color={$color_id} AND item_status='standby' ORDER By item_id ASC");
    }

    /**/
    /* Accessory */
    /**/
    private $select_accessory = "
          book.option_value AS value
        , CASE book.option_has_etc
            WHEN 0 THEN acc.acc_name
            ELSE book.option_name
        END AS name

        , CASE book.option_has_etc
            WHEN 0 THEN acc.acc_id
            ELSE 0
        END AS id

        , option_cost AS cost
        , option_rate AS rate
        , option_FOC AS FOC
        , option_has_etc AS has_etc
    ";
    public function listsAccessory($id) {
        
        $data = $this->db->select("
            SELECT {$this->select_accessory}
            FROM booking_accessory book
                LEFT JOIN accessory acc ON acc.acc_id=book.option_name AND book.option_has_etc=0
            WHERE option_book_id=:id ORDER BY book.option_has_etc ASC", array(':id'=>$id));

        return $data;
        // print_r($data);    
    }
    public function get_accessory() {
        $where_str = '';
        $where_arr = array();

        if( isset($_REQUEST['model']) ){
            $where_str .= !empty($where_str) ? " AND ":'';
            $where_str .= "`acc_model_id`=:model";
            $where_arr[':model'] = trim($_REQUEST['model']);
        }

        $where_str = !empty($where_str) ? " WHERE {$where_str}": '';
        $data = $this->db->select("SELECT acc_id as id, acc_name as name, acc_price as price, acc_cost as cost FROM accessory{$where_str}", $where_arr);

        return $data;
    }

    /**/
    /* Customer */
    /**/
    public function search_customer($first_name, $last_name){

        $data = $this->db->select("SELECT * FROM customers WHERE cus_first_name='{$first_name}' AND cus_last_name='{$last_name}'");

        return $data;
    }

    /**/
    /* pay_type */
    /**/
    public function get_pay_type($key) {
        $name = '';
        switch ($key) {
            case 'cash':
                $name = 'เงินสด';
                break;
            
            case 'hier':
                $name = 'เช่าซื้อ';
                break;

            case 'check':
                $name = 'เช็ค';
                break;
        }

        return array(
            'id' => $key,
            'name' => $name
        );
    }
    public function get_deposit_type($key) {
        $name = '';
        switch ($key) {
            case 'cash':
                $name = 'เงินสด';
                break;
            
            case 'credit':
                $name = 'บัตเครดิต';
                break;

            case 'check':
                $name = 'เช็คธนาคาร';
                break;
        }

        return array(
            'id' => $key,
            'name' => $name
        );
    }

    /**/
    /* Insurace */
    /**/
    public function get_insurance($id){

        $select_insurance = 'ins_id AS id , ins_book_id AS book_id , ins_name AS name , ins_party AS party , ins_pledge AS pledge , ins_sure AS sure , ins_premium AS premium';

        $data  = $this->db->select("SELECT {$select_insurance} FROM booking_insurance WHERE ins_book_id={$id}");

        return $data[0];
    }

    public function set_insurance($data, $id){
        $data['ins_book_id'] = $id;
        $this->db->insert('booking_insurance', $data);
    }

    public function update_insurance($data, $id){

        $this->db->update('booking_insurance', $data, "`ins_book_id`={$id}");
    }

    /**/
    /* Accessory */
    /**/
    public function set_accessory($data, $id){

        $post = array(
            'option_book_id'=>$id,
            'option_name'=>$data['name'],
            'option_value'=>$data['value'],
            'option_cost'=>$data['cost'],
            'option_rate'=>$data['rate'],
            'option_FOC'=>$data['FOC'],
            'option_has_etc'=>$data['has_etc']
            );

        $this->db->insert('booking_accessory', $post);
    }

    public function del_accessory($id){

        $this->db->delete( 'booking_accessory', "`option_book_id`={$id}", $this->db->count('booking_accessory', '`option_book_id`={$id}') );
    }

    /*public function getAccessory($id=null) {
        $data = $this->db->select("SELECT acc_id as id, acc_name as name, acc_price as price FROM accessory WHERE acc_id={$id} LIMIT 1");
        return $data;
    }*/

    /**/
    /* Condition */
    /**/
    public function set_condition($data, $id){
        $post = array(
            'con_book_id'=>$id,
            'con_name'=>$data['name'],
            'con_value'=>$data['value'],
            'con_type'=>$data['type'],
            'con_has_etc'=>$data['has_etc']
            );

        $this->db->insert('booking_condition', $post);
    }

    public function del_condition($id){

        $this->db->delete( 'booking_condition', "`con_book_id`={$id}", $this->db->count('booking_condition', '`con_book_id`={$id}') );
    }

    /**/
    /*  Booking Refer  */
    /**/
    private $select_book_cus_refer = "
        refer_id as id,
        refer_name as name,
        refer_note as note
    ";

    public function cus_refer(){
        return $this->db->select("SELECT {$this->select_book_cus_refer} FROM book_cus_refer ORDER BY refer_id ASC"); 
    }
    public function get_cus_refer($id){
        $sth = $this->db->prepare("SELECT {$this->select_book_cus_refer} FROM book_cus_refer WHERE `refer_id`=:id LIMIT 1");
        $sth->execute( array( ':id' => $id ) );

        return $sth->rowCount()==1 ? $sth->fetch( PDO::FETCH_ASSOC ) : array();
    }
    public function update_cus_refer($id, $data) {
        $this->db->update('book_cus_refer', $data, "`refer_id`={$id}");
    }
    public function insert_cus_refer(&$data){

        $data['refer_created'] = date('c');
        $data['refer_updated'] = date('c');

        $this->db->insert('book_cus_refer',$data);
        $data['refer_id'] = $this->db->lastInsertId();
    }
    public function delete_cus_refer($id){
        $this->db->delete('book_cus_refer', "`refer_id`={$id}");
    }
    /**/
    /*  Booking Status  */
    /**/
    public function status(){
        $a[] = array('id'=>'booking','name'=>'จอง', 'color'=>'#ea8006');
        $a[] = array('id'=>'cancel','name'=>'ถอนจอง', 'color'=>'#cccccc');
        $a[] = array('id'=>'finish','name'=>'ส่งมอบ', 'color'=>'#bb2244');

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
    /* CHECK & INSERT BOOKING */ 
    /**/
    public function check_form(&$data){
        
        $data = $data['post'];

        // if( !empty($data['id']) ){

        // }

        // if( !empty($item) ){
        //     if( $booking['book_page']==$item['page'] && $booking['book_number'] == $item['number'] ) $has_page = false;
        // }

        $has_page = true;

        if( $this->has_page($data['book']['page'], $data['book']['number']) && $has_page == true ) {
            $arr['error']['book_page'] = 'มีเล่มที่: '.$data['book']['page'].' เลขที่: '.$data['book']['number'].' ในระบบแล้ว';
        }

        if( $data['type_form'] == 'sales' ){
            if( empty($data['book']['sale_id']) ){
                $data['error']['book_sale_id'] = 'กรุณาเลือกพนักงานขาย';
                $data['message'] = 'กรุณาเลือกพนักงานขาย'; 
            }
        }

        if( $data['type_form'] == 'customers' ){
            if( empty($data['cus']['id']) ){
                /**/
                /* Check Profile Customer */ 
                foreach ($data['cus'] as $key => $value) {

                    if( $key == 'address' || $key == 'options' ) continue;

                    if( empty($value) && $key != 'nickname' && $key != 'last_name' && $key != 'prefix_name' && $key != 'card_id' ){

                        $data['error']['cus_name'] = 'กรุณากรอก ชื่อ ให้ถูกต้อง';
                            
                        /*if( strlen($data['cus']['card_id']) != '13' ){
                            $arr['error']['cus_card_id'] = 'กรุณากรอกรหัสบัตรประชาชนให้ถูกต้อง';
                        }*/
                    }
                }
                /**/
                /* Check BirthDay Customer */
                if( !empty($_POST['birthday']) ){
                    $futureDate = date('Y-m-d',strtotime(date("Y-m-d", mktime()) . " -6 year")); 
                    $birthday = date("{$_POST['birthday']['year']}-{$_POST['birthday']['month']}-{$_POST['birthday']['date']}");
                    if( strtotime($birthday) > strtotime($futureDate) ){
                        $arr['error']['birthday'] = 'วันเกิดไม่ถูกต้อง';
                    }
                }

                /**/
                /* Check Address Customer */
                
                /*foreach ($data['cus']['address'] as $key => $value) {

                    if( empty($value) && $key != 'mu' && $key != 'village' && $key !='street' && $key != 'alley'){
                        $data['error']['cus_address'] = 'กรอกข้อมูลที่อยู่ให้ครบถ้วน';
                    }

                    if( $key == 'zip' ){
                        if( strlen($value) != '5' ){
                            $data['error']['cus_address'] = 'กรุณากรอกรหัสไปรษณีย์ให้ครบ 5 หลัก';
                        }
                    }
                }*/

                /**/
                /* Check Options Customer */
                /*$options = $data['cus']['options'];
                foreach ($options as $type => $values) {
                    if( $type == 'phone'){
                        if( empty($values['value'][0]) ){
                            $data['error']['cus_options_phone'] = 'กรุณากรอกข้อมูลให้ครบถ้วน';
                        }
                    }
                }*/
            }
        }

        if( $data['type_form'] == 'details' ){
            foreach ($data['book'] as $key => $value) {
                if( $key=='model_id' || $key=='pro_id' || $key=='color' || $key=='deposit' || $key=='due' || $key=='net_price' ) {
                    if( empty($value) ) $data['error']['book_'.$key] = 'กรุณากรอกข้อมูล';
                }
            }
        }

        if( $data['type_form'] == 'deposit' ){

            if( $data['book']['deposit_type'] != 'cash' ){
                $deposit_option = $data['book']['deposit_type_options'];
            }

            if( $data['book']['deposit_type'] == 'credit' ){
                if( empty($deposit_option['number']) || empty($deposit_option['exp']) ){
                    $data['error']['book_type'] = 'กรุณากรอกข้อมูลบัตรเครดิตให้ครบถ้วน';
                    $data['message'] = 'กรุณากรอกข้อมูลบัตรเครดิตให้ครบถ้วน';
                }
            }

            if( $data['book']['deposit_type'] == 'check' ){
                if( empty($deposit_option['bank']) || empty($deposit_option['branch']) || empty($deposit_option['number']) || empty($deposit_option['create']) ){
                    $data['error']['book_type'] = 'กรุณากรอกข้อมูลเช็คธนาคารให้ครบถ้วน';
                    $data['message'] = 'กรุณากรอกข้อมูลเช็คธนาคารให้ครบถ้วน';
                }
            }
        }

        if( $data['type_form'] == 'payment' ){
            if( $data['book']['pay_type'] != 'cash' ){
                $pay_option = $data['book']['pay_type_options'];
            }
        }

        if( $data['type_form'] == 'save' ){

            /* SET DATA BOOK */
            $book = array();
            foreach ($data['book'] as $key => $value) {
                $book['book_'.$key] = $value;
            }
            if( !empty($data['book']['deposit_type_options']) ){
                $book['book_deposit_type_options'] = json_encode($data['book']['deposit_type_options']);
            }
            if( !empty($data['book']['pay_type_options']) ){
                $book['book_pay_type_options'] = json_encode($data['book']['pay_type_options']);
            }
            $book['book_note'] = '';

            /* SET DATA Customer */
            if( empty($data['cus']['id']) ){
                $customer = array();
                foreach ($data['cus'] as $key => $value) {

                    if( $key == 'options' || $key =='address' ) continue;

                    $customer['cus_'.$key] = $value;
                }

                if( !empty($_POST['birthday']) ){

                    $futureDate = date('Y-m-d',strtotime(date("Y-m-d", mktime()) . " -6 year")); 
                    $birthday = date("{$_POST['birthday']['year']}-{$_POST['birthday']['month']}-{$_POST['birthday']['date']}");
                    if( strtotime($birthday) > strtotime($futureDate) ){
                        $arr['error']['birthday'] = 'วันเกิดไม่ถูกต้อง';
                    }

                    $customer['cus_birthday'] = $birthday;
                }

                $customer['cus_address'] = json_encode($data['cus']['address']);
                $customer['cus_zip'] = $data['cus']['address']['zip'];
                $customer['cus_city_id'] = $data['cus']['address']['city'];

                /**/
                /* SET OPTIONS */
                /**/
                $options = $data['cus']['options'];

                if( !empty($options) ){

                    $cus_options = array();
                    foreach ($options as $type => $values) {

                        foreach ($values['name'] as $key => $val) {

                        //if( empty($values['value'][$key]) ) continue;

                            if( $type == 'phone'){
                                $customer['cus_phone'] = trim($values['value'][$key]);
                            }

                            if( $type == 'social'){
                                $customer['cus_lineID'] = trim($values['value'][$key]);
                            }

                            if( $type == 'email' ){
                                $customer['cus_email'] = trim($values['value'][$key]);
                            }

                            $cus_options[$type][] = array(
                                'type' => $type,
                                'label' => trim($val), 
                                'value' => trim($values['value'][$key])
                                );
                        }
                    }

                }

                $customer['cus_emp_id'] = $data['me'];
                $this->query('customers')->insert( $customer );
                $book['book_cus_id'] = $customer['cus_id'];

                foreach ($cus_options as $key => $values) {
                    foreach ($values as $options) {

                        $options['cus_id'] = $customer['cus_id'];
                        $this->query('customers')->set_option( $options );  
                    }
                }
            }
            else{
                $book['book_cus_id'] = $data['cus']['id'];
            }

            /* INSERT BOOKING */
            $book['book_sale_id'] = $data['book']['sale_id'];
            $book['book_status'] = 'booking';
            $this->insert($book);
            $id = $book['book_id'];

            if( !empty($id) ){

                /* SET DATA INSURENCE */
                foreach ($data['insurence'] as $key => $value) {

                // if( empty($value) && $key != 'sure'){
                //      $arr['error']['book_insurence'] = 'กรุณากรอกข้อมูลประกันภัยให้ครบถ้วน';
                // }
                    if( empty($value) ) continue;
                    $ins['ins_'.$key] = $value;
                }

                if( !empty($ins) ){
                    $this->set_insurance($ins, $id);
                }

                $accessory_price = 0;
                foreach ($data['accessory'] as $key => $value) {
                    if( empty($value['name']) ) continue;

                    $acc = array(
                        'name'=>$value['name'],
                        'value'=>$value['value'],
                        'cost'=>$value['cost'],
                        'rate'=>$value['rate'],
                        'has_etc'=>$value['has_etc'],
                        'FOC'=>(!empty($value['FOC'])? '1':'0'),
                        );

                    if( empty($value['FOC']) ){
                        $accessory_price = $accessory_price + $value['value'];
                    }
                    $this->set_accessory($acc, $id);
                }

                /* SET Payment Income (Booking Conditions) */
                $price_income = 0;
                foreach ($data['payment']['income'] as $key => $value) {

                    if( $key=='name' || $key=='value' ) continue;

                    if( empty($value) ) continue;

                    $income = array(
                        'name'=>$key,
                        'value'=>$value,
                        'type'=>'income',
                        'has_etc'=>0,
                        );
                    $price_income = $price_income+$value;
                    $this->set_condition($income, $id);
                }
                /* SET Payment Income ETC */
                for($i=0;$i<count($data['payment']['income']['name']);$i++){
                    if( empty($data['payment']['income']['value'][$i]) ) continue;

                    $income_etc = array(
                        'name'=>$data['payment']['income']['name'][$i],
                        'value'=>$data['payment']['income']['value'][$i],
                        'type'=>'income',
                        'has_etc'=>1,
                        );
                    $price_income = $price_income+$data['payment']['income']['value'][$i];
                    $this->set_condition($income_etc, $id);
                }

                /*SET Payment LESS */
                $price_lass = 0;
                foreach ($data['payment']['less'] as $key => $value) {
                    if( $key=='name' || $key=='value' ) continue;

                    if( empty($value) ) continue;

                    $lass = array(
                        'name'=>$key,
                        'value'=>$value,
                        'type'=>'less',
                        'has_etc'=>0,
                        );

                    $price_lass = $price_lass + $value;
                    $this->set_condition($lass, $id);
                }
                /* SET Payment LESS ETC */
                for($i=0;$i<count($data['payment']['less']['name']);$i++){
                    if( empty($data['payment']['less']['value'][$i]) ) continue;

                    $less_etc = array(
                        'name'=>$data['payment']['less']['name'][$i],
                        'value'=>$data['payment']['less']['value'][$i],
                        'type'=>'less',
                        'has_etc'=>1,
                        );

                    $price_lass = $price_lass + $data['payment']['less']['value'][$i];
                    $this->set_condition($less_etc, $id);
                }

                /* UPDATE Accessory Price Booking */

                $net_price = $price_income - $price_lass;

                $book['book_pro_price'] = $book['book_net_price'];
                $book['book_net_price'] = $book['book_net_price'] + $accessory_price + $net_price;
                $book['book_accessory_price'] = $accessory_price;

                $this->update( $id, $book );

                $data['message'] = 'บันทึกข้อมูลใบจองเรียบร้อยแล้ว';
                $data['url'] = URL.'booking';
            }
        }
    }
}