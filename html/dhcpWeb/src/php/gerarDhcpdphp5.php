<?php
	//chama o arquivo de conexão com o bd
	include("util/utf8size.php");
	include("tmpldhcpd.php");
	include("conectar.php");

	$queryString = "SELECT id, ip_address, mac_address, descricao FROM dhcpClient WHERE status_dhcp = 1";

	//consulta sql
	$query = mysql_query($queryString) or die(mysql_error());

	//faz um looping e cria um array com os campos da consulta
	$hosts = array();
	while($host = mysql_fetch_assoc($query)) {
	    $hosts[] = $host;
	}

	//consulta total de linhas na tabela
	$queryTotal = mysql_query('SELECT count(*) as num FROM dhcpClient WHERE status_dhcp = 1') or die(mysql_error());
	$row = mysql_fetch_assoc($queryTotal);
	$total = $row['num'];

	//encoda para formato JSON
	$status = array(
		"success" => mysql_errno() == 0,
		"total" => $total,
		"hosts" => $hosts
	);

	echo json_encode(utf8size($hosts));

	$mysqli->close();

	$myfile = fopen("dhcpd.conf", "w") or die("Unable to open file!");

	fwrite($myfile, $default);

	foreach ($hosts as $key => $value){
		fwrite($myfile,"#".$value['descricao'].PHP_EOL."		host ".$value['id']." {
    		hardware ethernet ".$value['mac_address'].";
    		fixed-address     ".$value['ip_address'].";
		}".PHP_EOL);
	}

	fclose($myfile);
?>