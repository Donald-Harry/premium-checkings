<?php
# Root paths for development (absolute paths, for localhost)
define('ROOT', '/home/u840384314/domains/usgsaauctions.com/public_html/premiumcheckings/');    												# use this for localhost
define('WEB_ROOT', $_SERVER['PROJECT_ROOT'].'/');    							# for backend includes
define('ROOT_URL', 'https://premiumcheckings.usgsaauctions.com/');  								# use this for frontend paths and assets, also backend headers 

// define('ROOT', 'C:\\wamp64\\www\\premium-checkings');    												# use this for localhost
// define('WEB_ROOT', $_SERVER['PROJECT_ROOT'].'/');    							# for backend includes
// define('ROOT_URL', 'http://localhost/premium-checkings/');  								# use this for frontend paths and assets, also backend headers 
 
#  Root paths for production (absolute paths, for live server)
// define('ROOT', '/storage/ssd4/878/21009878/public_html/');    		# use this when live on server
// define('WEB_ROOT', $_SERVER['PROJECT_ROOT'].'/');    						# for backend includes
// define('ROOT_URL', 'https://conquermarkets.000webhostapp.com/');    	        				# use this for frontend paths and assets, also backend headers

$echo_is_allowed = (isset($isajax) AND $isajax === true)? false:true;



If(ROOT === '' OR ROOT_URL ===''){
	echo '<p style="color:red;"> Please open your crib app file and provide the required values</p>';
	return;
}
