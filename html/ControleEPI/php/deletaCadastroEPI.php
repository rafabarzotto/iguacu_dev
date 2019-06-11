<?php


    header('Access-Control-Allow-Origin: *');

    header('Access-Control-Allow-Methods: GET, POST');

    header('Access-Control-Allow-Headers: X-Requested-With');

    header('Access-Control-Allow-Headers: *');

   if(empty($_POST['data'])){
	echo "Vazio";
    } else {


    $info = $_POST['data'];
    $json = json_decode($info, JSON_UNESCAPED_UNICODE);

	echo $info;

        $timestamp = date("d-m-Y H:i:s");

        $pdo = new PDO("mysql:host=localhost;dbname=iguacu", "opt", "qwe123");
        $pdo->exec("set names utf8");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare('DELETE FROM ControleEPI WHERE id = :id;');

        $stmt->execute(array(
            ':id' => $json['id'],
        ));

        echo $stmt->rowCount();


	}

?>

