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

    $q = array();
    if($json['id'] !== ""){
        $q[] = "id = :id";
    }
    if(trim($json['RE']) !== ""){
        $q[] = "RE = :RE";
    }
    if(trim($json['Colaborador']) !== ""){
         $q[] = "Colaborador = :Colaborador";
    }
    if(trim($json['Cargo']) !== ""){
        $q[] = "Cargo = :Cargo";
    }
    if(trim($json['Setor']) !== ""){
        $q[] = "Setor = :Setor";
    }
    if(trim($json['EPI']) !== ""){
        $q[] = "EPI = :EPI";
    }
    if(trim($json['Data']) !== ""){
        $q[] = "Data = :Data";
    }
    if(trim($json['Responsavel']) !== ""){
        $q[] = "Responsavel = :Responsavel";
    }
    if(trim($json['verificado']) !== ""){
	$q[] = "verificado = :verificado";
    }

    $timestamp = date("d-m-Y H:i:s");

    $pdo = new PDO("mysql:host=localhost;dbname=iguacu", "opt", "qwe123");
    $pdo->exec("set names utf8");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



    if(sizeof($q) > 0){
        $query = "UPDATE ControleEPI SET " . implode(", ", $q) . " WHERE id = :id";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":id", $json['id']);

        if(trim($json['RE']) !== ""){
            $stmt->bindParam(":RE", $json['RE']);
        }
        if(trim($json['Colaborador']) !== ""){
            $stmt->bindParam(":Colaborador", $json['Colaborador']);
        }
        if(trim($json['Cargo']) !== ""){
            $stmt->bindParam(":Cargo", $json['Cargo']);
        }
        if(trim($json['Setor']) !== ""){
            $stmt->bindParam(":Setor", $json['Setor']);
        }
        if(trim($json['EPI']) !== ""){
            $stmt->bindParam(":EPI", $json['EPI']);
        }
        if(trim($json['Data']) !== ""){
            $stmt->bindParam(":Data", $json['Data']);
        }
        if(trim($json['Responsavel']) !== ""){
            $stmt->bindParam(":Responsavel", $json['Responsavel']);
        }
	if(trim($json['verificado']) !== ""){
	    $stmt->bindParam(":verificado", $json['verificado']);
	}

        $stmt->bindParam(":stamp", $timestamp);

        $stmt->execute();

	    echo $stmt->rowCount();
    }

}

?>

