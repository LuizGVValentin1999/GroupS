<?php
    $host ="sql210.main-hosting.eu";
    $db_user ="u868317686_groups";
    $db_password="Groups@123";
    $db="u868317686_groups";
	$con = mysqli_connect($host,$db_user,$db_password,$db) or die ('NAO FOI POSSIVEL');
	mysqli_query($con, "SET time_zone = '-03:00';");
	?>