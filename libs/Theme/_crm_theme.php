<?php 

class Crm_Theme extends Theme {
	
	public function __construct()
	{
		parent::__construct();
	}

	public function setHeader() {        

        switch ($this->me['mode']) {
            case 'dark':
                $mode = 'drak';
                break;
            
            default:
                $mode = 'light';
                break;
        }
		$this->elem('body')->addClass( $mode );

        $hasPushedLeft = 1;
        if( !empty($this->elem('body')->attr('class')) ){
            if( in_array('is-overlay-left', explode(' ', $this->elem('body')->attr('class'))) ) {
                $hasPushedLeft = 0;
            }
        }

        if( $hasPushedLeft==1 ){

    		Session::init();
            $isPushedLeft = Session::get('isPushedLeft');

            if( isset($isPushedLeft) ){
                if( $isPushedLeft==1 ) {
                    $this->elem('body')->addClass('is-pushed-left');
                }
            }
            else{
                $this->elem('body')->addClass('is-pushed-left');
            }
        }

		$this   ->css( VIEW .'Themes/crm/assets/css/crm.css', true)
				->css('bootstrap')

                ->js( VIEW .'Themes/crm/assets/js/crm.js', true)
                ->js('custom')
                ->js('plugins/dialog')
                ->js('plugins/default')
                ->js('jquery/jquery');

	}
    
    public function setPage( $data ) {

        if( !empty($data['head']['css']) ){

            foreach ($data['head']['css'] as $value) {
                $this   ->css($value['name'], $value['host']);
            }
        }

        if( !empty($data['head']['js']) ){

            foreach ($data['head']['js'] as $value) {
                $this   ->js($value['name'], $value['host']);
            }
        }

        $this->setHeader();
    }

	public function render($name, $data) {

        $this->setPage( !empty($data['page'])? $data['page']: array() );

		# head
        require 'views/Themes/crm/Layouts/head.php';

        # start: doc
        echo '<div id="doc">';

		# topbar
        // require "views/Layouts/topbar/manage.php";

        require 'views/Themes/crm/Layouts/navigation-main.php';

        # content
        echo '<div id="container">';
            require 'views/Themes/crm/pages/' . $name . '.php';
        echo '</div>';

        # end: doc
        echo '</div>';

        # footer
        require 'views/Themes/crm/Layouts/footer.php';
	}
}