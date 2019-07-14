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


// BONUS /////////////////////////////////////

define('BONUS_PERCENT', 3);


// MERCHANT /////////////////////////////////////

define('MERCHANT_ID', 1425859);
define('MERCHANT_SECRET_KEY', '7dBnaZeX5dKJ5hgGnHjejaUHbQEEyHey');
define('MERCHANT_CREDIT_SECRET_KEY', 'Si57oC4GSYPLK3fq2F3SmvhLelg75s5E');

