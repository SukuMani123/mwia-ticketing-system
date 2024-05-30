<?php
/*
 *  CONFIGURE EVERYTHING HERE
 */
require_once("../Networking/DatabaseConnect.php");
require_once("../Model/adminUser.php");

// form field names and their translations.
// array variable name => Text to appear in the email
$fields = array('email' => 'Email', 'password' => 'Password'); 

// message that will be displayed when everything is OK :)
$okMessage = 'you successfully Login';

// If something goes wrong, we will display this message.
$errorMessage = 'failed login';

/*
 *  LET'S DO THE SENDING
 */

// if you are not debugging and don't need error reporting, turn this off by error_reporting(0);
error_reporting(E_ALL & ~E_NOTICE);

try
{

    if(count($_POST) == 0) throw new \Exception('Form is empty');
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $objUser = new adminUser();
    $resultUser = $objUser->selectUser($email,$password);

    if ($resultUser->id === NULL){
        $responseArray = array('type' => 'danger', 'message' => 'Invalid login');
        header("Location: loginError.html");
    }else{
        $okMessage = $resultUser->name;
    
        session_start();
        $_SESSION['user_mail']=$resultUser->email;

        $okMessage = $_SESSION['user_mail'] . $resultUser->id; 
        $responseArray = array('type' => 'success', 'message' => $okMessage);

        header("Location: registationResult.html");
    }
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $e);
}


// if requested by AJAX request return JSON response
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}
// else just display the message
else {
    echo $responseArray['message'];
}
