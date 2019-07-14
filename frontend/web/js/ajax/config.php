<?php

// Database ///////////////////////////////////////
if ($_SERVER['SERVER_NAME']=='beta.leoikea.loc') {
	define('DB_DRIVER','mysql');
	define('DB_HOST','localhost');
	define('DB_NAME','leoikea_crm');
	define('DB_USER','user');
	define('DB_PASS','pass');
} else {
	define('DB_DRIVER','mysql');
	define('DB_HOST','localhost');
	define('DB_NAME','k49223_crm');
	define('DB_USER','k49223_crm_user');
	define('DB_PASS','Uk{iGi!i_60c');
}


define('BONUS_PERCENT', 3);


// MERCHANT /////////////////////////////////////

define('MERCHANT_ID', 12);
define('MERCHANT_SECRET_KEY', 12);