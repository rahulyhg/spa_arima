<?php

class Model {

    function __construct() {
        $this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
        $this->fn = new _function();
        $this->lang = new Langs();;
    }

    // private query protected
    private $_query = array();

    // Public query
    public function query( $table=null ){

        $path = "models/{$table}_model.php";
        
        if(!array_key_exists($table, $this->_query) && file_exists($path)){

            require_once $path;
            $modelName = $table . '_Model';
            $this->_query[$table] = new $modelName;
        }

        return $this->_query[$table];
        
    }
    protected function limited($limit=0, $pager=1, $del=0){
        return "LIMIT ".((($pager*$limit)-$limit)-$del) .",". $limit;
    }

    protected function orderby($sort, $dir='DESC'){
        return "ORDER BY ".( $dir=='rand'  ? "rand()": "{$sort} {$dir}" );
    }
    protected function cut($search, $results)  {
        $data = array();
        foreach ($results as $key => $value) {
            $data[ str_replace($search, '', $key) ] = $value;
        }
        return $data;
    }
    public function permitOnPages() {
        return array(
            'settings' => array(
                'shop' => true,
                'admin' => false,
                'department' => false
            ),
            
        );
    }

    public function _convert($_data, $options=array()) {

        $options = array_merge( array('color','status','refer','sale', 'cus', 'product', 'model', 'car', 'brand', 'dealer', 'pro', 'emp', 'tec', 'type'), $options );

        $data = array();
        foreach ($_data as $key => $value) {
            $ex = explode('_', $key, 2);

            if( in_array($ex[0], $options ) && count($ex)==2 ){
                $data[ $ex[0] ][ $ex[1] ] = $value;
            }
            else{
                $data[ $key ] = $value;
            }
        }

        if( !empty($data['cus']) ){
            $data['cus'] = $this->query('customers')->convert( $data['cus'] );
        }

        if( !empty($data['emp']) ){
            $data['emp'] = $this->query('employees')->convert( $data['emp'] );
        }

        if( !empty($data['tec']) ){
            $data['tec'] = $this->query('employees')->convert( $data['tec'] );
        }

        if( !empty($data['sale']) ){
            $data['sale'] = $this->query('employees')->convert( $data['sale'] );
        }
        
        $data['is_convert'] = true;

        return $data;
    }

    public function _setFieldFirstName($_first, $data){
        $_data = array();
        foreach ($$data as $key => $value) {
            $_data[] = $_first.$value;
        }

        return $_data;
    }


    public function permit($id=0) {

        if( $id==0 ){
            $permit = array('view'=>0,'edit'=>0, 'del'=>0, 'add'=>0);
        }
        else{
            $permit = array('view'=>1,'edit'=>1, 'del'=>1, 'add'=>1);
        }

        // Settings
        $arr = array( 
            'dashboard' => array('view'=>0),

            'events' => array('view'=>0,'edit'=>0, 'del'=>0, 'add'=>1),

            'company' => $permit,
            'dealer' => $permit,
            'my' => $permit,
            'paytype' => $permit,

            'room' => $permit,
            'bed' => $permit,
            
            'department' => $permit,
            'position' => $permit,
            'employees' => $permit,
            'skill' => $permit,

            'level' => $permit,

            'customers' => $permit,
            'booking' => $permit,
            'stocks' => $permit,
            'sales' => $permit,
            'services' => $permit,
            'reports' => array('view'=>0),

        );

        // 

        if( $id==1 ){ // is admin
            $arr['dashboard'] = array('view'=>1);
            $arr['events'] = array('view'=>1,'edit'=>1, 'del'=>1, 'add'=>1);
            $arr['reports'] = array('view'=>1);

        }
        else if( $id!=1 ){ // not admin
            $arr['company'] = array('view'=>0,'edit'=>0, 'del'=>0, 'add'=>0);
            $arr['dealer'] = array('view'=>0,'edit'=>0, 'del'=>0, 'add'=>0);

            $arr['department'] = array('view'=>0,'edit'=>0, 'del'=>0, 'add'=>0);
            $arr['position'] = array('view'=>0,'edit'=>0, 'del'=>0, 'add'=>0);
            $arr['employees'] = array('view'=>0,'edit'=>0, 'del'=>0, 'add'=>0);

            $arr['brands'] = array('view'=>0,'edit'=>0, 'del'=>0, 'add'=>0);
            $arr['models'] = array('view'=>0,'edit'=>0, 'del'=>0, 'add'=>0);

            $arr['accessory'] = array('view'=>1,'edit'=>0, 'del'=>0, 'add'=>0);
            $arr['stores'] = array('view'=>1,'edit'=>0, 'del'=>0, 'add'=>0);

            // $arr['book_status'] = array('view'=>0,'edit'=>0, 'del'=>0, 'add'=>0);
            $arr['services'] = array('view'=>0,'edit'=>0, 'del'=>0, 'add'=>0);

            $arr['stocks'] = array('view'=>1,'edit'=>0, 'del'=>0, 'add'=>0);
        }

        /* sale */
        if( $id==2 ){
            $arr['services'] = array('view'=>0,'edit'=>0, 'del'=>0, 'add'=>0);
            $arr['employees'] = array('view'=>0,'edit'=>0, 'del'=>0, 'add'=>0);
            $arr['sales'] = array('view'=>1,'edit'=>0, 'del'=>0, 'add'=>0);
        }

        /* service */
        if($id==3){
            $arr['booking'] = array('view'=>0,'edit'=>0, 'del'=>0, 'add'=>0);
            $arr['employees'] = array('view'=>0,'edit'=>0, 'del'=>0, 'add'=>0);
            $arr['sales'] = array('view'=>0,'edit'=>0, 'del'=>0, 'add'=>0);
        }

        /* tec */
        if($id==4){
            $arr['services'] = array('view'=>0,'edit'=>0, 'del'=>0);
            $arr['sales'] = array('view'=>0,'edit'=>0, 'del'=>0);
        }

        return $arr;
    }

    public function getPermit($page, $action, $id, $tap=null) {

        $permit = $this->_pagePermit($id);

        if(  $tap!=null  ){
            return !empty($permit[$page][$action]);
        }
        else{
            return !empty($permit[$page][$tap][$action]);
        }

    }
}