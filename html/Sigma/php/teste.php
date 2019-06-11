<?php

	header('Access-Control-Allow-Origin: *');

    	header('Access-Control-Allow-Methods: GET, POST');

	header('Access-Control-Allow-Headers: X-Requested-With');

	$start = $_REQUEST['start'];
	$limit = $_REQUEST['limit'];
	$page  = $_REQUEST['page'];

	$searchSplit = '';
    	$searchQueryItems = array();


	//conectamos ao banco de dados
	$PDO = new PDO('firebird:dbname=192.168.4.5:C:\Sigma_Banco\NOVO_SIGMAPDCA_IGUACU_PRD.FDB;charset=utf8', 'SYSDBA', 'masterkey');
	$PDO->exec("set names utf8");

	if(isset($_REQUEST['query'])){

	$busca = $_REQUEST['query'];

	if($_REQUEST['tipo'] == 'radioCodEqui'){
          $tipo = 'EQUIPAM.EQUI_CODIG';
        }
        if($_REQUEST['tipo'] == 'radioDescEqui'){
          $tipo = 'EQUIPAM.EQUI_DESCR';
        }
        if($_REQUEST['tipo'] == 'radioCodMaq'){
          $tipo = 'MAQUINA.MAQ_CODIGO';
        }
        if($_REQUEST['tipo'] == 'radioTag'){
          $tipo = 'TAG.TAG_CODIGO';
        }

	   $searchSplit = explode(' ', $busca);
	  	foreach ($searchSplit as $searchTerm) {
          /*
           * NOTE: Check out the DB connections escaping part 
           * below for the one you should use.
           */
            $searchQueryItems[] = "LOWER ($tipo) LIKE '%" . trim($PDO->quote($searchTerm), "'") . "%'";
          }
		$sql = "SELECT EQUIPAM.EQUI_CODIG, EQUIPAM.EQUI_DESCR, EQUIPAM.MAQ_CODIGO, MAQUINA.MAQ_DESCRI, EQUIPAM.TAG_CODIGO, TAG.TAG_DESCRI FROM EQUIPAM, MAQUINA, TAG" . (!empty($searchQueryItems) ? " WHERE " . implode(" AND ", $searchQueryItems) : "") . " AND EQUIPAM.MAQ_CODIGO = MAQUINA.MAQ_CODIGO AND EQUIPAM.TAG_CODIGO = TAG.TAG_CODIGO";
		$sqlTotal = "SELECT count(*) FROM EQUIPAM, MAQUINA, TAG" . (!empty($searchQueryItems) ? " WHERE " . implode(" AND ", $searchQueryItems) : "") . " AND EQUIPAM.MAQ_CODIGO = MAQUINA.MAQ_CODIGO AND EQUIPAM.TAG_CODIGO = TAG.TAG_CODIGO";
	} else {
		$sql = "SELECT FIRST $limit SKIP $start EQUIPAM.EQUI_CODIG, EQUIPAM.EQUI_DESCR, EQUIPAM.MAQ_CODIGO, MAQUINA.MAQ_DESCRI, EQUIPAM.TAG_CODIGO, TAG.TAG_DESCRI FROM EQUIPAM, MAQUINA, TAG WHERE EQUIPAM.MAQ_CODIGO = MAQUINA.MAQ_CODIGO AND EQUIPAM.TAG_CODIGO = TAG.TAG_CODIGO";
		$sqlTotal = "SELECT count(*) FROM EQUIPAM, MAQUINA, TAG WHERE EQUIPAM.MAQ_CODIGO = MAQUINA.MAQ_CODIGO AND EQUIPAM.TAG_CODIGO = TAG.TAG_CODIGO";
	}

	//montamos e rodamos a query
	$result = $PDO->query($sql);

	//retornamos todos os registros (fetchAll) em forma de uma lista de Objetos (FECH_OBJ)
	$datas = $result->fetchAll(PDO::FETCH_ASSOC);

	$resultTotal = $PDO->query($sqlTotal);
	$total = $resultTotal->fetchColumn();

	$status = array(
		"success" => "success",
		"total" => $total,
		"data" => $datas
	);

	echo json_encode($status, JSON_UNESCAPED_UNICODE);
?>
