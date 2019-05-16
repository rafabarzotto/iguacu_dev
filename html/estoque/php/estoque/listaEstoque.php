<?php
	//chama o arquivo de conexão com o bd
	include("../conectar.php");
	include("../util/utf8size.php");

	$start = $_REQUEST['start'];
	$limit = $_REQUEST['limit'];

	$desc = '';

	if (isset($_REQUEST['desc']) || $desc != '') {
		$desc = $_REQUEST['desc'];
		$queryString = "SELECT id, Descricao, Est, Estoque, Extra FROM Estoque WHERE Descricao LIKE '%$desc%' LIMIT $start, $limit";
		$queryTotal = mysql_query("SELECT count(*) as id FROM Estoque WHERE Descricao LIKE '%$desc%'") or die(mysql_error());
	} else{
		$queryString = "SELECT id, Descricao, Estoque, Est, Extra FROM Estoque LIMIT $start, $limit";
		$queryTotal = mysql_query("SELECT count(*) as id FROM Estoque") or die(mysql_error());
	}

	//consulta sql
	$query = mysql_query($queryString) or die(mysql_error());

	//faz um looping e cria um array com os campos da consulta
	$datas = array();
	while($data = mysql_fetch_assoc($query)) {
	    $datas[] = $data;
	}

	//consulta total de linhas na tabela
	$row = mysql_fetch_assoc($queryTotal);
	$total = $row['id'];

	//encoda para formato JSON
	$status = array(
		"success" => mysql_errno() == 0,
		"total" => $total,
		"data" => $datas
	);

	echo json_encode(utf8size($status));

	$mysqli->close();

?>