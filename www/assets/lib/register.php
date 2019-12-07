<?php // Register.php
      // Add a new user to the Database
//Session Start
session_start();
// Establish DB Connection
require_once 'connect.php';
require_once 'header.php';
require_once 'strut.php';
/*
Username varchar(100) NOT NULL,
UPassword varchar(256) NOT NULL,
EmailAddress varchar(100) NOT NULL,
utype varchar(10) not null,
 */
function register_new_user($username, $password, $email){
	$connection = get_connection();
    if ($connection->connect_error) die("Fatal Error");
	try {
		$stmt = $connection->prepare("insert into tusers (Username, UPassword, EmailAddress, utype) "
							. "values ( ? , ? , ? , ? ) ");
		$stmt->bind_param("ssss", $user, $passhash, $em, $ut);
		$user = $username;
		$passhash = $password;
		$em = $email;
		$ut = "user";
		$stmt->execute();
        @mysqli_close($connection);
	} catch (\mysqli_sql_exception $ex) {
		throw $ex;
	} catch (Exception $e) {
		throw $e;
	}
}

if($_POST['csrf_token'] === session_id()){
    if(isset($_POST['username']) && isset($_POST['password'])){
		$username = (string)filter_input(INPUT_POST, "username");
        $password = (string)filter_input(INPUT_POST, "password");
        $pwd_hash = hash("sha256", $password);
        $email = (string)filter_input(INPUT_POST, "email");
		/*
        $username = mysqli_real_escape_string($connection, $_POST['username']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $emailaddress = mysqli_real_escape_string($connection, $_POST['email']);
		*/
        register_new_user($username, $pwd_hash, $email);
        header('location: http://'.$_SERVER['HTTP_HOST'].$urlStrut.'index.php');
        //header("location: ../../index.php");
        
	}

    
}
?>

<script>
    function validateForm() {
        var uname = document.forms["myForm"]["username"].value;
        var psw = document.forms["myForm"]["password"].value;
        var email = document.forms["myForm"]["email"].value;
        
        // Check if fields blank
        if ((uname == "") || (psw == "") || (email == "")) {
            alert("All fields must be filled out");
            return false;
        }

        // Check if email utep.edu
        /*
        if (!(/.*\.utep\.edu$/.test(email))){
            alert("Email must be a utep address");
            return false;
        }
		*/
        return true;
    } 
</script>
<form name="myForm" action="register.php" onsubmit="return validateForm()" method="post">
Username: <input type="text" name="username">
Password: <input type="password" name="password">
Email:    <input type="text" name="email">
<input type="hidden" name="csrf_token" value="<?php echo session_id(); ?>">
<input type="submit" value="Register">
</form> 

<?php require_once 'footer.php'; ?>
