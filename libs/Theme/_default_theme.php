<?php 

class Default_Theme extends Theme {
	
	public function __construct()
	{
		parent::__construct();
	}

	public function setHeader() {
		$this   ->css( VIEW .'Themes/default/assets/css/default.css', true )
				->css('bootstrap')

                ->js('custom')
                ->js('plugins/dialog')
                ->js('plugins/default')
                ->js('jquery/jquery');
	}

	public function render($name) {
		$this->setHeader();

		# head
        require 'views/Layouts/default/head.php';
		# start: doc
        echo '<div id="doc">';

	        # topbar
        	echo '<header id="header-primary">';
	        require "views/Themes/default/Layouts/topbar.php";
	        echo '</header>';

	        # content
	        echo '<div id="main">';
	        require 'views/Themes/default/pages/' . $name . '.php';
	        echo '</div>';

	        #footer
	        echo '<footer id="footer-primary">';
       		require "views/Themes/default/Layouts/footer.php";
       		echo '</footer>';
       		
		# end: doc
        echo '</div>';

        # footer
        require 'views/Layouts/default/footer.php';
	}
}