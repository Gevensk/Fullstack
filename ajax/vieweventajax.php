<?php
	$idteam = isset($_POST['idteam']) ? $_POST['idteam'] : 1;
	require_once("../class/event.php");
	require_once("../class/team.php");
	$team = new Team();
	$rowteam = $team->getTeamById($idteam);
	$event = new Event();
	$res = $event->getEventByTeam($idteam);

	$hasil = "<table border = '1'>";
	$hasil .= "<h1>".$rowteam['name']." Events</h1>";
	$hasil .= "<tr><th>Name</th><th>Date</th><th>Description</th></tr>";

	while($row = $res->fetch_assoc()){
		$hasil .= "<tr>";
		$hasil .= "<td>".$row['name']."</td>";
		$hasil .= "<td>".$row['date']."</td>";
		$hasil .= "<td>".$row['description']."</td>";
		$hasil .= "</tr>";
	}

	$hasil .= "</table>";

	echo $hasil;
?>