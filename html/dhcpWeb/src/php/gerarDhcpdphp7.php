<?php
	
	include("tmpldhcpd.php");

    $PDO = new PDO('mysql:host=localhost;dbname=iguacu', 'root', 'qwe123');

	$sql = "SELECT id, ip_address, mac_address, descricao FROM dhcpClient WHERE status_dhcp = 1";
	$result = $PDO->query($sql);
	$hosts = $result->fetchAll(PDO::FETCH_ASSOC);

	echo json_encode($hosts);

	$myfile = fopen("/etc/dhcp/dhcpd.conf", "w") or die("Unable to open file!");

	fwrite($myfile, $default);

	foreach ($hosts as $key => $value){
		fwrite($myfile,"#".$value['descricao'].PHP_EOL.
			"   host ".$value['id']." {".PHP_EOL.
			"      hardware ethernet ".$value['mac_address'].";".PHP_EOL.
			"      fixed-address ".$value['ip_address'].";".PHP_EOL.
				   "}".PHP_EOL);
	}

	fclose($myfile);

?>
