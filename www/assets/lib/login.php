<?php 
session_start();
require_once('connect.php');
require_once 'strut.php';
function authenticate($user, $pass_hash){

    $connection = get_connection();
    if ($connection->connect_error) die("Fatal Error");
       
	$result = "";
	try {
		$stmt = $connection->prepare("call sp_authenticate( ?, ? )");
		$stmt->bind_param("ss", $user, $pass_hash);
		$stmt->execute();
		$stmt->bind_result($c);
		while($stmt->fetch()) {
			$result = $c;
        }
        @mysqli_close($connection);
        return $result;
	} catch (\mysqli_sql_exception $ex) {
		throw $ex;
	} catch (Exception $e) {
		throw $e;
	}
}


function get_user_type($username){
	$connection = get_connection();
    if ($connection->connect_error) die("Fatal Error");
       
	$result = "";
	try {
		$stmt = $connection->prepare("call sp_get_user_type( ? )");
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$stmt->bind_result($type);
		while($stmt->fetch()) {
			$result = $type;
        }
        @mysqli_close($connection);
        return $result;
	} catch (\mysqli_sql_exception $ex) {
		throw $ex;
	} catch (Exception $e) {
		throw $e;
	}
}

// Login 
if ($_POST['csrf_token'] === session_id()){

    if (isset($_POST['uname']) && isset($_POST['psw'])){
        
        (isset($_POST['remember']))?($_SESSION['RemeberMe'] = true):($_SESSION['RememberMe'] = false);

        //$username = mysqli_real_escape_string($connection, $_POST['uname']);
        //$password = $_POST['psw'];
        
        $username = (string)filter_input(INPUT_POST, "uname");
        $password = (string)filter_input(INPUT_POST, "psw");
        $pwd_hash = hash("sha256", $password);
        
        $authentic = authenticate($username, $pwd_hash);
        
        if ($authentic) {
			$_SESSION['Authenticated'] = True;                
			if ($_SESSION['RememberMe']){
				$_SESSION['SessionExp'] = time() + 604800; //Expire a week from right now
			}
			$_SESSION['SessionExp'] = time() + 3600; //Expire an hour from right now
			$_SESSION["user_type"] = get_user_type($username);
		} else {
			$_SESSION['ServerMessage'] = "Incorrect Username or Password";
		}
        
    } else {
        $_SESSION['ServerMessage'] = "No username or password";
    }
}

header('location: http://'.$_SERVER['HTTP_HOST'].$urlStrut.'index.php');
//header("location: ../../index.php");
?>
