<?php

/**
 * @author Fejiro Eni
 * @author Muhammed Madugu 
 * USING UNICUS CRIB Version 0.0.1
 */



//
//ini_set('session.gc_maxlifetime', 86400*2);               # set how long (in secs, 86400=1day) you want you session to last, 
 															#comment this off if you want to use default from server (optional)
//
//session_set_cookie_params(2,592,000);                     # set how long (in secs, 86400=1day) you want you cookies to last, 
															#comment this off if you want to use PHP default or not using cookies at all (optional)	
ob_start();




/**
 * COOKIE PERMISSION DOCUMENTATION 
 *
 * set $cookie_permission [BOOLEAN] to determine whether user would be asked to grant permission for cookies; Default = true
 * set $force_cookie_permission [BOOLEAN] to determine if user would be forced to accept cookie before continue; Default = true
 * set $cookie_permission_style to determine how permission would be displayed; values 
 * 		"inpage", "offpage" [only when $force_cookie_permission = true ]; default = offpage
 *		"buttom", "buttom-left", "buttom-right", "top", "top-right", "top-left", "modal" [only when $force_cookie_permission = false ]; default = "bottom-right"
 */
function get_cookie_consent(){

	if(count($_COOKIE) > 0) {

		// if (session_status() == PHP_SESSION_NONE) 
		session_start();

	}else{

		if( !isset($GLOBALS['cookie_permission']) ) $GLOBALS['cookie_permission'] = true;
		if ($GLOBALS['cookie_permission'] ){

			if( !isset($GLOBALS['force_cookie_permission']) ) $GLOBALS['force_cookie_permission'] = true;
			if($GLOBALS['force_cookie_permission']){

				if( !isset($GLOBALS['cookie_permission_style']) ) $GLOBALS['cookie_permission_style'] = "offpage";
				if( $GLOBALS['cookie_permission_style'] == "inpage" ){
					#iframe


				}else{
					#redirect
					$ending = explode("?", $_SERVER['REQUEST_URI']);
					$ending = (count($ending) > 1)? '/?'.end($ending):'';
					$location = full_url_self().$ending;
					header('location:'.ROOT_URL.'cookie_settings.php?location='.$location);
					exit;

				}

			}else{

				if( !isset($GLOBALS['cookie_permission_style']) ) $GLOBALS['cookie_permission_style'] = "bottom-right";
				#do not forced permissions

			}
		}else{ 
			#don't ask for permission,session not started, you have to start it manually in your script.
		}


	}


}




setcookie(session_name(),session_id(),time()+2,592,000);                      # set how long (in secs, 86400=1day) you want you cookies to last, 


date_default_timezone_set("Africa/Lagos");                  # set your time zone (optional)



# REQUIRED VALUES
######################################################################
#########     Please provide values for these varables     ###########
######################################################################
# replace the values below with your values
# comment or uncomment lines of codes below depending on what enviroment you are runing the project; development (on localhost/localserver) or production (on live server)

# db connections for development (on localhost)
// $db = mysqli_connect( "localhost", "root", "", "dbname" );

# db connections for production (live server)
// $db = mysqli_connect( "localhost", "db", "dbuser", "dbname" );

# Root paths for development (absolute paths, for localhost)
define('ROOT', '/home/u787607796/domains/premiumarts.online/public_html/');    												# use this for localhost
define('WEB_ROOT', $_SERVER['PROJECT_ROOT'].'/');    							# for backend includes
define('ROOT_URL', 'https://premiumarts.online/');  								# use this for frontend paths and assets, also backend headers 
 
#  Root paths for production (absolute paths, for live server)
// define('ROOT', 'define this part eg: /home/dfsdgdfgf/public_html/');    		# use this when live on server
// define('WEB_ROOT', $_SERVER['PROJECT_ROOT'].'/');    						# for backend includes
// define('ROOT_URL', 'https://www.wenjibra.com/');    	        				# use this for frontend paths and assets, also backend headers 


$echo_is_allowed = (isset($isajax) AND $isajax === true)? false:true;



If(ROOT === '' OR ROOT_URL ===''){
	echo '<p style="color:red;"> Please open your crib app file and provide the required values</p>';
	return;
}

######################################################################
#########             DONE! ENJOY YOUR CRIB                ###########
######################################################################





#loading House/crib
######################################################################
###       INITIALIZATION (Don't Edit unless you are sure)      #######
######################################################################

#Functions 

#calls are more optimal than class, objects and methods hence DB is in function call 

#get classes only when needed, for root dir make compartment == ""
// function from( &$compartment='', &$item){

// 	$new=( strpos($item, "new_") )?true:false;
// 	$item=str_replace("new_", "", trim($item));
	

// 	if (!class_exists($item)){
// 		include ROOT.$compartment.$item;
// 	}

// 	if ($new) return new $item;

// }

#force www
// if ((strpos($_SERVER['HTTP_HOST'], 'www.') === false))
// {
//     header('Location: http://www.'.$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
//     exit();
// }



function cleanInput($input) { // fot single line strings
 
  $search = array(
    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
    '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
  );
 
    $output = preg_replace($search, '', $input);
    $output=addslashes( str_replace(";", "&zwnj;;", $output));   
    $output=addslashes( str_replace("$", "$&zwnj;", $output));
    return htmlentities(strip_tags($output));
}


function xcleanInput($input) { // for multiline strings
 
  $search = array(
    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
    '@<style[^>]*?>.*?</style>@siU'    // Strip style tags properly
  );
 
    $output = preg_replace($search, '', $input);   
    $output=addslashes( str_replace(";", "&zwnj;;", $output));   
    $output=addslashes( str_replace("$", "$&zwnj;", $output));
    return htmlentities(strip_tags($output));
}




#general single-line sanitize heavy
function sanitize(&$input) { 
    if (is_array($input)) {
        foreach($input as $var=>$val) {
            $input[$var] = sanitize($val);
        }
    }
    else {
        if (get_magic_quotes_gpc()) {
            $input = stripslashes($input);
        }
        $input  = cleanInput($input);
        $input = $GLOBALS['uxlink']->real_escape_string($input);
    }

    return $input;
}




#general multi-line sanitize heavy
function xsanitize(&$input) {
    if (is_array($input)) {
        foreach($input as $var=>$val) {
            $input[$var] = xsanitize($val);
        }
    }
    else {
        if (get_magic_quotes_gpc()) {
            $input = stripslashes($input);
        }
        $input  = xcleanInput($input);

        $input = $GLOBALS['uxlink']->real_escape_string($input);
    }

    return $input;
}




#allow code display but not run
function neutalize(&$input){

    if (get_magic_quotes_gpc()) {
            $input = stripslashes($input);
    }  
    $input=str_replace("< ", "<", $input);
    $input=addslashes( str_replace("<", "<&zwnj;", $input));
    $input=addslashes( str_replace("script", "s&zwnj;cript", $input));   
    $input=addslashes( str_replace(";", "&zwnj;;", $input));   
    $input=addslashes( str_replace("$", "$&zwnj;", $input));
    $input = $GLOBALS['uxlink']->real_escape_string($input);

    return $input;
}


#get random chars
function random_characters($length, $special_chars=false){
		$characters = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		if($special_chars) $characters.="~!@#$%^&*()_+";
        $charactersLength = strlen($characters);

        $random_characters = "";
        for ($i = 0; $i < $length; $i++) {
            $random_characters .= $characters[rand(0, $charactersLength - 1)];
        }

        return $random_characters;
}


function random_numbers($lenght){

	$characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $lenght; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;

}


//get full url not including the exact .php script
function full_url(){
	$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 
                "https" : "http") . "://" . $_SERVER['HTTP_HOST'] .  
                $_SERVER['REQUEST_URI'];   

	return $link; 
}

//get full url not including the exact .php script
function full_url_self(){
	$link = ( (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')? "https" : "http");
	$link = $link . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];   
	return str_replace("index.php", "", $link); 
}


#to keep track of where user was actually active incase you side-tracked user.
$previous_active_location=ROOT_URL;
function active_location(){ 
	if ( !isset($_SESSION) ) return;
	if (empty($_SESSION['my_location'])){
    	$_SESSION['my_location'] = ROOT_URL;
	}

	$GLOBALS['previous_active_location']=$_SESSION['my_location'];
	$ending = explode("?", $_SERVER['REQUEST_URI']);
	$ending = (count($ending) > 1)? end($ending):'';
	$ending = ($ending != '')? "?".$ending:''; 
	return $_SESSION['my_location'] = full_url_self().''.$ending;

}


function last_active_location(){
	if ( !isset($_SESSION) ) return;
	if(isset($_SESSION['my_location'])){
		return $_SESSION['my_location'];
	}else{
		return ''.ROOT_URL.'';
	}
	
}


######################################################################
###                        INITIALIZATION ENDS                 #######
######################################################################








#ITEMS you can start writing your codes here
##################################################################################################




// no user is defined for this project yet so this is empty
class User{


	public $loggedIn;
	public $name;
	public $email;
	


	function __construct(){


	}





	private function register_as_vistor(){
 
	}



	public static function logout(){
 
	}

	function is_visitor(){ return $this->isVisitor; }
	function is_familiar(){ return $this->isFamiliar; }


}



/**
* Use the person class to specify a person that is not the immediate user 
* this will be useful is situations like $User->follows($Person)
*/
class Person extends User
{
	private $id;

 public function get_user_id(){
 
 }

}




/**
* Use the app class for instances where the WebApp wants to act like a user 
* will be useful for APIs and instances like $App->delete($person), $App->pay($User)
*/
class App 
{

 public function get_user_id(){
 
 }

}


class Api extends App
{

 public function get_user_id(){
 
 }

}



// get_cookie_consent();
?>
