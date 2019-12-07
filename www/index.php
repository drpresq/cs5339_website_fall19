<?php
// Establish DB Connection
require_once 'assets/lib/header.php';
require_once 'assets/lib/searchbar.php';
require_once 'assets/lib/connect.php';
require_once 'assets/lib/strut.php';

$index = 0;
if (isset($_GET["pindex"])){
	$index = (int)filter_input(INPUT_GET, "pindex");	
}
if (isset($_GET["search"])) {
	$search_input = (string)filter_input(INPUT_GET, "search");
	if (isset($_SESSION["user_type"])) {
		$user_type = $_SESSION["user_type"];
		if ($user_type == "user"){
			$result = search($search_input, "user", $index);
			print_table($result, "user");
		} else if ($user_type == "admin") {
			$result = search($search_input, "user", $index);
			print_table($result, "admin");
		} else {
			$result = search($search_input, "guest", $index);
			print_table($result, "guest");
		}	
	} else {
		$result = search($search_input, "guest", $index);
		print_table($result, "guest");
	}
} 
/*
else {
	if (isset($_SESSION["user_type"])) {
		$result = search("", $_SESSION["user_type"], $index);
		print_table($result, $_SESSION["user_type"]);
	} else {
		$result = search("", "guest", $index);
		print_table($result, "guest");
	}
	
}
*/

/*

Guest
PartName, PartNumber, Suppliers, Category, Description01 

User
PartName, PartNumber, Suppliers, Category, Description01, Price

Admin 
* 
PartID, PartName, PartNumber, Suppliers, Category, Description01, 
Description02, Description03, Description04, Description05, Description06, 
Price, Estimated Shipping Cost, Associated image filename1, Associated image filename2, 
Associated image filename3, Associated image filename4, Notes, Shipping Weight
 * */

function search($keyword, $user_type, $index){

    $connection = get_connection();
    if ($connection->connect_error) die("Fatal Error");
       
	$result = array();
	try {
		$stmt = $connection->prepare("call sp_search( ?, ?, ? )");
		$stmt->bind_param("ssi", $keyword, $user_type, $index);
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

function getSearchCount($keyword){
   $connection = get_connection();
    if ($connection->connect_error) die("Fatal Error");
    
    $count = 0;
    try{
		// getting a result count
		$stmt = $connection->prepare("call sp_search_item_count( ? )");
		$stmt->bind_param("s", $keyword);
		$stmt->execute();
		$stmt->bind_result($c);
		while($stmt->fetch()) {
			$count = $c;
        }
        @mysqli_close($connection);
        return $count;
	} catch (\mysqli_sql_exception $ex) {
		throw $ex;
	} catch (Exception $e) {
		throw $e;
	}
}

function print_table ($query_result, $user_type) {
	require_once 'assets/lib/strut.php';
	if ($query_result == NULL || count($query_result) < 1 ) {
		echo "<p>Sorry, no results found!</p>";
		return;
	} 
	echo "<table class='table-filter' id='results'>";
	if ($user_type == "user") {
		/*
		echo "<tr><th>PartID</th><th>PartName</th><th>PartNumber</th><th>Suppliers</th>"
			."<th>Category</th><th>Description01</th><th>Description02</th><th>Description03</th>"
			."<th>Description04</th><th>Description05</th><th>Description06</th><th>Price</th>"
			."<th>Estimated Shipping Cost</th><th>Associated image filename1</th><th>Associated image filename2</th>" 
			."<th>Associated image filename3</th><th>Associated image filename4</th><th>Notes</th>"
			."<th>Shipping Weight</th></tr>";
		*/

		//Begin Table Code for: Sort by Header on Click
		$header = array("PartID","PartName","PartNumber","Suppliers","Category","Description01","Description02","Description03","Description04","Description05","Description06","Price","Estimated Shipping Cost","Associated image filename1", "Associated image filename2","Associated image filename3","Associated image filename4","Notes","Shipping Weight");
		echo "<tr>"
			 ."<!--When a header is clicked, run the sortTable function, with a parameter,0 for sorting by names, 1 for sorting by country: -->";
		foreach($header as $index => $field){
			echo '<th onclick="sortTable('.$index.')">'.$field."</th>";
		}
		echo "</tr>";
		// End Table Code for: Sort by Header on Click

		foreach ($query_result as $row) {
			echo "<tr>";
			foreach ($row as $column_data) {
				if(preg_match('/\.jpg/', $column_data)){
					echo "<td><img scr=\"http://".$_SERVER['HTTP_HOST']."/Classes/cs5339/gwwood/57bab0/assets/partimages/".htmlspecialchars($column_data)."\" alt=\"$column_data\"></td>";
				} else{ 
					echo "<td>".htmlspecialchars($column_data)."</td>";
				}
			}
			echo "</tr>";
		}
	} else if ($user_type == "admin") {
		/*
		echo "<tr><th>PartID</th><th>PartName</th><th>PartNumber</th><th>Suppliers</th>"
			."<th>Category</th><th>Description01</th><th>Description02</th><th>Description03</th>"
			."<th>Description04</th><th>Description05</th><th>Description06</th><th>Price</th>"
			."<th>Estimated Shipping Cost</th><th>Associated image filename1</th><th>Associated image filename2</th>" 
			."<th>Associated image filename3</th><th>Associated image filename4</th><th>Notes</th>"
			."<th>Shipping Weight</th><th>Edit</th></tr>";
		echo "<form method='post' action='assets/lib/update_part.php'>";
		*/

		//Begin Table Code for: Sort by Header on Click
		$header = array("PartID","PartName","PartNumber","Suppliers","Category","Description01","Description02","Description03","Description04","Description05","Description06","Price","Estimated Shipping Cost","Associated image filename1", "Associated image filename2","Associated image filename3","Associated image filename4","Notes","Shipping Weight","Edit");
		echo "<tr>"
			 ."<!--When a header is clicked, run the sortTable function, with a parameter,0 for sorting by names, 1 for sorting by country: -->";
		foreach($header as $index => $field){
			echo '<th onclick="sortTable('.$index.')">'.$field."</th>";
		}
		echo "</tr>";
		// End Table Code for: Sort by Header on Click
		
		echo "<form method='post' action='http://".$_SERVER['HTTP_HOST']."/Classes/cs5339/gwwood/57bab0/assets/lib/update_part.php'>";
		foreach ($query_result as $row) {
			$i = 0;
			$id = -1;
			foreach ($row as $key => $column_data) {
				if ($i < 1) {
					$id = htmlspecialchars($column_data);
				}
				if($key == 13){
					echo "<td><img scr=\"http://".$_SERVER['HTTP_HOST']."/Classes/cs5339/gwwood/57bab0/assets/partimages/".htmlspecialchars($column_data)."\" alt=\"$column_data\"></td>";
				} else{ 
					echo "<td>".htmlspecialchars($column_data)."</td>";
				}
				++$i;
			} 
			echo "<td><button name='partid' value='$id' type='submit'>Edit</button></td>";
			echo "</tr>";
		}
		echo "</form>";
	} else {
		/*
		echo "<tr><th>PartName</th><th>PartNumber</th><th>Suppliers</th>"
			."<th>Category</th><th>Description</th></tr>";
		*/

		//Begin Table Code for: Sort by Header on Click
		$header = array("PartName","PartNumber","Suppliers","Category","Description");
		echo "<tr>"
			 ."<!--When a header is clicked, run the sortTable function, with a parameter,0 for sorting by names, 1 for sorting by country: -->";
		foreach($header as $index => $field){
			echo '<th onclick="sortTable('.$index.')">'.$field."</th>";
		}
		echo "</tr>";
		// End Table Code for: Sort by Header on Click

		foreach ($query_result as $row) {
			echo "<tr>";
			foreach ($row as $column_data) {
				echo "<td>".htmlspecialchars($column_data)."</td>";
			}
			echo "</tr>";
		}
	}
	echo "</table>";

// Begin JS Code for: Sort by Header on Click
echo <<<END
	<script>
	function sortTable(n) {
	var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
	table = document.getElementById("results");
	switching = true;
	//Set the sorting direction to ascending:
	dir = "asc"; 
	/*Make a loop that will continue until
	no switching has been done:*/
	while (switching) {
		//start by saying: no switching is done:
		switching = false;
		rows = table.rows;
		/*Loop through all table rows (except the
		first, which contains table headers):*/
		for (i = 1; i < (rows.length - 1); i++) {
		//start by saying there should be no switching:
		shouldSwitch = false;
		/*Get the two elements you want to compare,
		one from current row and one from the next:*/
		x = rows[i].getElementsByTagName("TD")[n];
		y = rows[i + 1].getElementsByTagName("TD")[n];
		/*check if the two rows should switch place,
		based on the direction, asc or desc:*/
		if (dir == "asc") {
			if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
			//if so, mark as a switch and break the loop:
			shouldSwitch= true;
			break;
			}
		} else if (dir == "desc") {
			if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
			//if so, mark as a switch and break the loop:
			shouldSwitch = true;
			break;
			}
		}
		}
		if (shouldSwitch) {
		/*If a switch has been marked, make the switch
		and mark that a switch has been done:*/
		rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
		switching = true;
		//Each time a switch is done, increase this count by 1:
		switchcount ++;      
		} else {
		/*If no switching has been done AND the direction is "asc",
		set the direction to "desc" and run the while loop again.*/
		if (switchcount == 0 && dir == "asc") {
			dir = "desc";
			switching = true;
		}
		}
	}
	}
	</script>
END;
// End JS Code for: Sort by Header on Click

	print_nav_bar();
}


function print_nav_bar(){
	$search_input = "";
	if (isset($_GET["search"])) {
		$search_input = (string)filter_input(INPUT_GET, "search");
	}
	$page = 1;
	if (isset($_GET["page"])){
		$page = (int)filter_input(INPUT_GET, "page");	
	}
	$current_page = $page;
	$row_count = getSearchCount($search_input);
	$MAX_ROWS_PER_PAGE = 10;
	$MAX_INDEXES_PER_PAGE = 5;
	$page_count = (int)($row_count / $MAX_ROWS_PER_PAGE);
	if ($page_count === 0) {
		$page_count = 1;
	}
	
	
	echo "<div class='page_navigator'>";
	echo "Items Found: $row_count.<br/>";
	echo "Current Page: $current_page <br/>";
	echo "<nav>";
	$start_page = 1;
	if ($current_page > 2) {
		$previous_multiple_of_five = intval($current_page);
		while (($previous_multiple_of_five % $MAX_INDEXES_PER_PAGE) != 0) { 
			--$previous_multiple_of_five; 
		}
		$start_page = intval($previous_multiple_of_five);
		if ($start_page < 1) {
			$start_page = 1;
		}
		if ($current_page >= $MAX_INDEXES_PER_PAGE) {
			$pindex = $start_page * $MAX_ROWS_PER_PAGE;
			$page = $start_page - 1;
			
			if (isset($_GET["search"])){
				$search_input = (string)filter_input(INPUT_GET, "search");
				echo "<a href='index.php?search=$search_input&pindex=$pindex&page=".$page."' >...</a>";
			} else {
				echo "<a href='index.php?pindex=$pindex&page=".$page."' >...</a>";
			}
		}
	}
	$end_page = intval($page_count);
	$next_multiple_of_five = intval($current_page);
	if (($end_page - $curren_page) > 5) {
		while (($next_multiple_of_five % $MAX_INDEXES_PER_PAGE) != 0 
				|| $next_multiple_of_five == $current_page) { 
			++$next_multiple_of_five; 
		}
		if ($current_page <= $page_count) {
			$end_page = intval($next_multiple_of_five);
		}
	}
	$pindex = 0;
	for ($p = $start_page; $p <= $end_page; $p++) {
		$pindex = ($p - 1) * $MAX_ROWS_PER_PAGE;
		if (isset($_GET["search"])){
			$search_input = (string)filter_input(INPUT_GET, "search");
			echo "<a href='index.php?search=$search_input&pindex=$pindex&page=$p' >$p</a>";
		} else {
			echo "<a href='index.php?pindex=$pindex&page=$p' >$p</a>";
		}
	}
	if (($page_count - $current_page) > 5) {
		if (isset($_GET["search"])){
			$search_input = (string)filter_input(INPUT_GET, "search");
			echo "<a href='index.php?search=$search_input&pindex=$pindex&page=".($end_page + 1)."' >...</a>";
		} else {
			echo "<a href='index.php?pindex=$pindex&page=".($end_page + 1)."' >...</a>";
		}
	}
	echo "</nav>";
	echo "</div>";
}
/*
foreach($_SESSION as $key => $value){
    echo $key." = ".$value."<br>";
}
*/
require_once 'assets/lib/footer.php'; 
?>

