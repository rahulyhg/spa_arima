<?php

date_default_timezone_set("Asia/Bangkok");

// Always provide a TRAILING SLASH (/) AFTER A PATH

define('URL', 'http://localhost/spa_arima/');

define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'spa_arima');
define('DB_USER', 'root');
define('DB_PASS', '');

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
define('WWW_LIBS', ROOT . DS . "libs" . DS);
define('WWW_APPS', ROOT . DS . "apps" . DS);
define('WWW_DOCS', ROOT . DS . "public". DS. 'docs'. DS);
define('WWW_VIEW', ROOT . DS . 'views' . DS);
define('WWW_IMAGES', ROOT . DS . 'public' . DS. 'images'. DS );
define('WWW_UPLOADS', ROOT . DS . "public". DS. 'uploads'. DS);

define('LIBS', 'libs/');
define('DOCS', URL . 'public/docs/');
define('VIEW', URL . 'views/');
define('CSS', URL . 'public/css/');
define('JS', URL . 'public/js/');
define('IMAGES', URL . 'public/images/');
define('UPLOADS', URL . "public/uploads/");

define('COOKIE_KEY_EMP', 'emp_id');

// The sitewide hashkey, do not change this because its used for passwords!
// This is for other hash keys... Not sure yet
define('HASH_GENERAL_KEY', 'MixitUp200');

// This is for database passwords only
define('HASH_PASSWORD_KEY', 'catsFLYhigh2000miles');

define('RECAPTCHA_SITE_KEY', '6LfPBxMTAAAAALX9MpBvvR2sjCKZidyhU-YXYHCY');
define('RECAPTCHA_SECRET_KEY', '6LfPBxMTAAAAACav7aO-axpuFK6r_fDphq6gAs4i');