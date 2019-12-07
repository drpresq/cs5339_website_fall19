<?php // Register.php
      // Add a new user to the Database
//Session Start
session_start();
// Establish DB Connection
require_once 'connect.php';
require_once 'header.php';

function get_part_data($partid) {
	$connection = get_connection();
    if ($connection->connect_error) die("Fatal Error");
	$result = array();
	try {
		$stmt = $connection->prepare("call sp_get_part( ? )");
		$stmt->bind_param("i", $partid);
		$stmt->execute();
		$result_arr = $stmt->get_result();
        while($row = $result_arr->fetch_assoc()) {
			$result[] = $row;
		}
		@mysqli_close($connection);
		return $result;
	} catch (\mysqli_sql_exception $ex) {
		throw $ex;
	} catch (Exception $e) {
		throw $e;
	}
}

function update_part($args) {
	$connection = get_connection();
    if ($connection->connect_error) die("Fatal Error");

	$sql_stmt = "update carparts set ";
	$i = 0;
	$bind_param_str = "";
    foreach ($args as $field => $value) {
		if ($i < count($args) - 1 ) {
			$sql_stmt .= "`$field` = ? , ";
		} else {
			$sql_stmt .= "`$field` = ? ";
		}
		if (gettype($value) == "integer") {
			$bind_param_str .= "i";
		} else {
			$bind_param_str .= "s";
		}
		++$i;
	}
	$sql_stmt .= " where PartID = " . $args["PartID"] . "";
	try {
		$stmt = $connection->prepare($sql_stmt);
		$stmt->bind_param($bind_param_str, $pid, $pm, $pnum, $sup, $cat, $desc1,
				$des2, $desc3, $desc4, $desc5, $desc6, $pr, $ship, $image1, $image2,
				$image3, $image4, $notes, $shipw);
		$pid = $args["PartID"]; $pm = $args["PartName"]; $pnum = $args["PartNumber"];
		$sup = $args["Suppliers"]; $cat = $args["Category"]; $desc1 = $args["Description01"]; 
		$desc2 = $args["Description02"]; $desc3 = $args["Description03"]; $desc4 = $args["Description04"]; 
		$desc5 = $args["Description05"]; $desc6 = $args["Description06"]; $pr = $args["Price"]; 
		$ship = $args["Estimated Shipping Cost"]; $image1 = $args["Associated image filename1"]; 
		$image2 = $args["Associated image filename2"]; $image3 = $args["Associated image filename3"]; 
		$image4 = $args["Associated image filename4"]; $notes = $args["Notes"]; $shipw = $args["Shipping Weight"];
		$stmt->execute();
        @mysqli_close($connection);
	} catch (\mysqli_sql_exception $ex) {
		echo $ex;
	} catch (Exception $e) {
		echo $e;
	}
}
/*
Admin 
* 
PartID, PartName, PartNumber, Suppliers, Category, Description01, 
Description02, Description03, Description04, Description05, Description06, 
Price, Estimated Shipping Cost, Associated image filename1, Associated image filename2, 
Associated image filename3, Associated image filename4, Notes, Shipping Weight
 * */
 
if (isset($_POST["update"])) {
	if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] != session_id()){
		echo "";
	} else {
		$args = array( 
			"PartID" => (int)filter_input(INPUT_POST, "PartID"),
			"PartName" => (string)filter_input(INPUT_POST, "PartName"),
			"PartNumber" => (string)filter_input(INPUT_POST, "PartNumber"),
			"Suppliers" => (string)filter_input(INPUT_POST, "Suppliers"),
			"Category" => (string)filter_input(INPUT_POST, "Category"),
			"Description01" => (string)filter_input(INPUT_POST, "Description01"),
			"Description02" => (string)filter_input(INPUT_POST, "Description02"),
			"Description03" => (string)filter_input(INPUT_POST, "Description03"),
			"Description04" => (string)filter_input(INPUT_POST, "Description04"),
			"Description05" => (string)filter_input(INPUT_POST, "Description05"),
			"Description06" => (string)filter_input(INPUT_POST, "Description06"),
			"Price" => (string)filter_input(INPUT_POST, "Price"),
			"Estimated Shipping Cost" => (string)filter_input(INPUT_POST, "Estimated Shipping Cost"),
			"Associated image filename1" => (string)filter_input(INPUT_POST, "Associated image filename1"),
			"Associated image filename2" => (string)filter_input(INPUT_POST, "Associated image filename2"),
			"Associated image filename3" => (string)filter_input(INPUT_POST, "Associated image filename3"),
			"Associated image filename4" => (string)filter_input(INPUT_POST, "Associated image filename4"),
			"Notes" => (string)filter_input(INPUT_POST, "Notes"),
			"Shipping Weight" => (string)filter_input(INPUT_POST, "Shipping Weight"));
		update_part($args);
		echo "<Center><H2>Update Complete!</H2></Center>";
		return;
	}
}

if (!isset($_POST["partid"])) {
	echo "Please provide Part Id";
	return;
}



$partid = (int) (string)filter_input(INPUT_POST, "partid");
$parts = get_part_data($partid);

if ($parts != NULL) {
	echo "<table>";
	echo "<tr><th>Field</th><th>Value</th></tr>";
	echo "<form action='update_part.php' method='post'>";
	foreach ($parts[0] as $field => $value) {
		echo "<tr>";
		echo "<td>$field</td>";
		echo "<td><input type='text' name='$field' value='$value' /></td>";
		echo "</tr>";
	}
	echo "<tr><td><input type='hidden' name='csrf_token' value='". session_id() ."' /></td></tr>";
	echo "<tr><td><input type='submit' name='update' value='Update!' /></td></tr>";
	echo "</form>";
	echo "</table>";
} else {
	echo "Error Retrieving Car Parts data.";
}

?>

