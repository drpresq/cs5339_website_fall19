<?php //Searchbar.php
      //Displays the searchbar

session_start();

echo <<<_END
    
    <form action="index.php" method="get">
		<input type="text" name="search">
		<center><input type="submit" value="Search"></center>
_END;
    //echo '<input name="session_id" type="hidden" value="'. session_id() .'">';
echo <<<_END
    </form>
    
</td>
</tr>
<tr>
<td>
_END;

?>
