<?php

class Pages_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    private $_objName = "pages";
    private $_table = "pages";
    private $_field = "*";
    private $_cutNamefield = "page_";

    public function getHomepageID()
    {
        $sth = $this->db->prepare("SELECT page_id as id FROM {$this->_table} WHERE make_homepage=:id LIMIT 1");
        $sth->execute( array( ':id' => 1 ) );

        $id = '';
        if( $sth->rowCount()==1 ){
            $fdata = $sth->fetch( PDO::FETCH_ASSOC );
             $id = $fdata['id'];
        }

        return $id;
    }
    public function getPageID($name)
    {
        $sth = $this->db->prepare("SELECT page_id as id FROM {$this->_table} WHERE page_primarylink=:name LIMIT 1");
        $sth->execute( array( ':name' => $name ) );

        $id = '';
        if( $sth->rowCount()==1 ){
            $fdata = $sth->fetch( PDO::FETCH_ASSOC );
             $id = $fdata['id'];
        }

        return $id;
    }

    public function lists( $options=array() ) {

        return $this->db->select("SELECT * FROM pages ORDER BY page_sequence ASC");
    }
    public function popular($options=array()) {

    	return $this->lists($options);
    }

    public function buildFrag($results) {
        $data = array();
        foreach ($results as $key => $value) {
            if( empty($value) ) continue;
            $data[] = $this->convert( $value );
        }
        return $data;
    }
    public function get($id){
        
        $sth = $this->db->prepare("SELECT {$this->_field} FROM {$this->_table} WHERE {$this->_cutNamefield}id=:id LIMIT 1");
        $sth->execute( array(
            ':id' => $id
        ) );

        return $sth->rowCount()==1
            ? $this->convert( $sth->fetch( PDO::FETCH_ASSOC ) )
            : array();
    }
    public function convert($data){
        return $this->cut($this->_cutNamefield, $data);
    }


    public function hasName($text)
    {
        return $this->db->count('pages', "page_primarylink=:text", array(':text'=>$text));
    }
    

    
    /* active */
    public function insert(&$data) {

        if( !isset($data['page_sequence']) ){
            $sth = $this->db->prepare("SELECT page_sequence FROM pages ORDER BY page_sequence DESC LIMIT 1");
            $sth->execute();

            if( $sth->rowCount()==0 ){
                $data['page_sequence'] = 1;
                
            }
            else{
                $fdata = $sth->fetch( PDO::FETCH_ASSOC );

                $data['page_sequence'] = $fdata['page_sequence'] + 1;
            }
        }
        // $data["{$this->_cutNamefield}created"] = date('c');
        $this->db->insert( 'pages', $data );
        $data["page_id"] = $this->db->lastInsertId();
    }
    public function del($id) {
        $this->db->delete($this->_objName, "`{$this->_cutNamefield}id`={$id}" );
    }
    public function update($id, $data) {
        $this->db->update('pages', $data, "`page_id`={$id}" );
    }
    


    public function fonts()
    {
        return $this->db->select("SELECT * FROM pages_fonts");
    }


    /**/
    /* Section */
    /**/
    
    // insert
    public function insertSection( $id, $category )
    {
        $this->db->insert('pages_sections', array('section_super_category'=> $category, 'section_category'=>'default'));
        $section_id = $this->db->lastInsertId();


        $sth = $this->db->prepare("SELECT sequence FROM pages_sections_permit WHERE page_id=:id ORDER BY sequence DESC LIMIT 1");
        $sth->execute( array(
            ':id' => $id
        ) );
        
        $seq = 1;
        if( $sth->rowCount()==1 ){
            $fdata = $sth->fetch( PDO::FETCH_ASSOC );
            $seq = $fdata['sequence'] + 1;
        }

        $data = array(
            'page_id'=> $id, 
            'section_id'=> $section_id,
            'sequence'=> $seq,
        );

        $this->db->insert('pages_sections_permit', $data);

        return $data;
    }

    // get for page
    public function sections( $id ) 
    {
        return $this->buildFragSections( $this->db->select( "SELECT s.* FROM pages_sections_permit p LEFT JOIN pages_sections s ON p.section_id=s.section_id WHERE p.page_id=:id ORDER BY p.sequence ASC", array(':id'=>$id) ) );
    }
    public function buildFragSections($results) {
        $data = array();
        foreach ($results as $key => $value) {
            if( empty($value) ) continue;
            $data[] = $this->convertSection( $value );
        }
        return $data;
    }

    // get for id
    public function getSection($id)
    {
        $sth = $this->db->prepare("SELECT * FROM pages_sections WHERE section_id=:id LIMIT 1");
        $sth->execute( array(
            ':id' => $id
        ) );

        return $sth->rowCount()==1
            ? $this->convertSection( $sth->fetch( PDO::FETCH_ASSOC ) )
            : array();
    }
    public function convertSection( $data )
    {
        $dOptions =  $this->db->select("SELECT option_name as name, option_value as value FROM pages_sections_values WHERE section_id=:id", array(':id'=>$data['section_id']));

        $data['options'] = array();
        foreach ($dOptions as $value) {
            $data['options'][$value['name']] = $value['value'];
        }

        $data['items'] = $this->options( $data['section_id'] );
        
        // print_r($data); die;
        return $data;
    }
    public function setSectionsValue($data)
    {
        $sth = $this->db->prepare("SELECT * FROM pages_sections_values WHERE section_id=:id AND option_name=:name LIMIT 1");
        $sth->execute( array(
            ':id' => $data['section_id'],
            ':name' => $data['option_name'],
        ) );

        if( $sth->rowCount()==1 ){

            $w = "section_id={$data['section_id']} AND option_name='{$data['option_name']}'";
            if( !empty($data['option_value']) ){
                $this->db->update('pages_sections_values', $data, $w);
            }
            else{
                $this->db->delete('pages_sections_values', $w);
            }
        }
        else{

            if( !empty($data['option_name']) && !empty($data['option_value']) ){
                $this->db->insert('pages_sections_values', $data);
            }
        }
    }


    /**/
    /* Option */
    /**/
    public function insertOption($id, $name, $value)
    {
        $this->db->insert('pages_sections_options', array(
            'option_section_id' => $id,
            'option_name' => $name,
            'option_value' => $value
        ));
        return $this->db->lastInsertId();
    }

    // get for section
    public function options($id)
    {
        return $this->buildFragOptions( $this->db->select( "SELECT * FROM pages_sections_options WHERE option_section_id=:id ORDER BY option_id ASC", array(':id'=>$id) ) );
    }

    public function buildFragOptions($results) {
        $data = array();
        foreach ($results as $key => $value) {
            if( empty($value) ) continue;
            $data[] = $this->convertOption( $value );
        }
        return $data;
    }

    public function getOption($id)
    {
        $sth = $this->db->prepare("SELECT * FROM pages_sections_options WHERE option_id=:id LIMIT 1");
        $sth->execute( array(
            ':id' => $id
        ) );

        return $sth->rowCount()==1
            ? $this->convertOption( $sth->fetch( PDO::FETCH_ASSOC ) )
            : array();
    }

    public function convertOption($data)
    {
        $dOptions =  $this->db->select("SELECT option_name as name, option_value as value FROM pages_sections_options_values WHERE option_id=:id", array(':id'=>$data['option_id']));

        $data['options'] = array();
        foreach ($dOptions as $value) {
            $data['options'][$value['name']] = $value['value'];
        }


        if( $data['option_name']=='media' ){

            $data['media'] = $this->query('albums')->get_media( $data['option_value'] );


            if( !empty($data['media']['url']) ){
                $data['image_url'] = $data['media']['url'];
            }
        }

        return $data;
    }

    public function delOption($id)
    {
        $this->db->delete('pages_sections_options', "`option_id`={$id}");
    }


    public function insertOptionValue($data)
    {
        $this->db->insert('pages_sections_options_values', $data);
    }
    public function setOptionValue($data)
    {
        $sth = $this->db->prepare("SELECT * FROM pages_sections_options_values WHERE option_id=:id AND option_name=:name LIMIT 1");
        $sth->execute( array(
            ':id' => $data['option_id'],
            ':name' => $data['option_name'],
        ) );

        if( $sth->rowCount()==1 ){

            $w = "option_id={$data['option_id']} AND option_name='{$data['option_name']}'";
            if( !empty($data['option_value']) ){
                $this->db->update('pages_sections_options_values', $data ,$w);
            }
            else{
                $this->db->delete('pages_sections_options_values', $w);
            }
        }
        else{
            if( !empty($data['option_name']) && !empty($data['option_value']) ){
                $this->insertOptionValue($data);
            }
        }
        
    }
    public function delOptionValue($id, $name)
    {
        $this->db->delete('pages_sections_options_values', "`option_id`={$id} AND `option_name`='{$name}'");
    }

    
}