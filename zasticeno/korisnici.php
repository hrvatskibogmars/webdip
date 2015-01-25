<?php
	include_once("../skripte/config.php");
	$users = R::getAll("select * from hokorisnici;");
	
        echo "<table id='profil' border='0' cellpadding='10'>";
        echo "<tr><th>ID</th><th>Korisnicko ime</th><th>Lozinka</th><th>Tip</th></tr>";

        foreach ($users as $key => $value) 
	{	
                echo "<tr>";
                echo "<td>" . $value['id'] . "</td>";
                echo "<td>" . $value['username'] . "</td>";
                echo "<td>" . $value['password'] . "</td>";
                echo "<td>" . $value['type'] . "</td>";
                
                echo "</tr>";
	}

        echo "</table>";
?>