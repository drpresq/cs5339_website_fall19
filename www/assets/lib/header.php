<?php //Header.php
      //Constructs Standard Page Header  
require_once 'strut.php';
session_start();


if(($_SESSION['Authenticated'] === true) && ($_SESSION['SessionExp'] < time())){
  $_SESSION['ServerMessage'] = "Session Expired. Please log in again.";
  header('location: http://'.$_SERVER['HTTP_HOST'].$urlStrut.'assets/lib/logout.php');
}

//Render the html header
echo <<< _END
<html>
<head>
<style>
body {font-family: Arial, Helvetica, sans-serif;}

/* Full-width input fields */
input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

/* Set a style for all buttons */
button {
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

button:hover {
  opacity: 0.8;
}

/* Extra styles for the cancel button */
.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

/* Center the image and position the close button */
.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
  position: relative;
}

.container {
  padding: 16px;
}

span.psw {
  float: right;
  padding-top: 16px;
}

span.reg {
  float: left;
  padding-top: 16px;
}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  padding-top: 60px;
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
  border: 1px solid #888;
  width: 80%; /* Could be more or less, depending on screen size */
}

/* The Close Button (x) */
.close {
  position: absolute;
  right: 25px;
  top: 0;
  color: #000;
  font-size: 35px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: red;
  cursor: pointer;
}

/* Add Zoom Animation */
.animate {
  -webkit-animation: animatezoom 0.6s;
  animation: animatezoom 0.6s
}

@-webkit-keyframes animatezoom {
  from {-webkit-transform: scale(0)} 
  to {-webkit-transform: scale(1)}
}
  
@keyframes animatezoom {
  from {transform: scale(0)} 
  to {transform: scale(1)}
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 100%;
  }
  span.reg {
    display: block;
    float: none;
  }
}

.table-filter {
	background-color: #fff;
	border-bottom: 1px solid #eee;
}
.table-filter tbody tr:hover {
	cursor: pointer;
	background-color: #eee;
}
.table-filter tbody tr td {
	padding: 5px;
	vertical-align: middle;
	border-top-color: #eee;
}
.table-filter tbody tr.selected td {
	background-color: #eee;
}
.table-filter tr td:first-child {
	width: 80%;
}

.table-filter tr td:nth-child(2) {
	text-align: right;
}

.table-filter .artist {
    color:gray;
	font-size: 13px;
}

.page_navigator {
	margin: auto;
	width: 50%;
	padding: 10px;
}

nav a {
  display: inline-block;
  padding: 5px;
}

</style>
_END;


echo <<<_END
<table>
    <tr style="text-align:center;">
    <td width=10%>
_END;
    echo "<button onclick=\"location.href = 'http://".$_SERVER['HTTP_HOST'].$urlStrut."index.php'\" style=\"width:auto;\">Home</button>";
    //echo "<button onclick=\"location.href = '/index.php'\" style=\"width:auto;\">Home</button>";
echo <<<_END
    </td>
    <td width=80%>
    <H1>Parts!</H1>
_END;

// BEGIN ACTUAL VIEWABLE HEADER CONTENT
if(isset($_SESSION['ServerMessage']) && $_SESSION['ServerMessage'] != ''){
  echo "    ".$_SESSION['ServerMessage'];
  $_SESSION['ServerMessage'] = '';
}

echo <<<_END
    
    </td>
    <td width=10% style="text-aligh:right;">
_END;

// LOGIC TO SET THE CONTENT OF THE LOGIN / LOGOUT BUTTON DYNAMICALLY
if ($_SESSION['Authenticated'] === true) {
    echo "<button onclick=\"location.href = 'http://".$_SERVER['HTTP_HOST'].$urlStrut."assets/lib/logout.php'\" style=\"width:auto;\">Logout</button>";
}else{
    echo "<button onclick=\"document.getElementById('id01').style.display='block'\" style=\"width:auto;\">Login</button>";
}


echo "<div id=\"id01\" class=\"modal\">"
     ."<form class=\"modal-content animate\" action=\"http://".$_SERVER['HTTP_HOST'].$urlStrut."assets/lib/login.php\" method=\"post\">";
echo <<< _END
        <div class="container">
          <label for="uname"><b>Username</b></label>
          <input type="text" placeholder="Enter Username" name="uname" required>
    
          <label for="psw"><b>Password</b></label>
          <input type="password" placeholder="Enter Password" name="psw" required>
            
          <button type="submit">Login</button>
          <label>
            <input type="checkbox" checked="checked" name="remember"> Remember me
          </label>
_END;
        echo '<input type="hidden" name="csrf_token" value="'.session_id().'">';
echo <<<_END
        </div>
    
        <div class="container" style="background-color:#f1f1f1">
          <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
          <span class="reg"><a href="assets/lib/register.php">Register</a></span>
        </div>
      </form>
    </div>
    
    <script>
    // Get the modal
    var modal = document.getElementById('id01');
    
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    </script>    
    </td>
    </tr>
</table>
</head>
<body>
<table width=75% align=center>
<tr>
<td>
_END;

?>
