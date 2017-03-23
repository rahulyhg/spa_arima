<?php 

class Login_Theme extends Theme {
	
	public function __construct()
	{
		parent::__construct();
	}

	public function setHeader() {

		$this->elem('body')->addClass('balance');

		if( isset($this->captcha) ){
			$this->js('https://www.google.com/recaptcha/api.js', true);
		}

		$this   ->css('login')
				->css('bootstrap')

                ->js('custom')
                ->js('plugins/default')
                ->js('jquery/jquery');
	}

	public function render($name) {
		$this->setHeader();

		# head
        require 'views/Layouts/default/head.php';


        # content
        require 'views/' . $name . '.php';

        # footer
        require 'views/Layouts/default/footer.php';
	}

}