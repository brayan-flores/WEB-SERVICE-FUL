<?php

 // Incluimos la conexion para poder ocupar la clase
 include 'conexion.php';
 
    $pdo = new Conexion();

    // Declaramos la repuesta del metodo GET , si el metodo es true nos traera el id especifico que selecionemos en la ruta 'localhost..../?id_reg=1'
    if($_SERVER['REQUEST_METHOD'] == 'GET'){

       if(isset($_GET['id_reg'])){
        $sql = $pdo->prepare("SELECT * FROM regions WHERE id_reg =:id_reg");
        $sql->bindValue(':id_reg', $_GET['id_reg']);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($sql->fetchAll());
        echo('<br />'. 'success true');
        exit;
       } 
       // En caso de ser false nos arroja toda la informacion de los id_reg
       else{

        $sql = $pdo->prepare("SELECT * FROM regions");
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($sql->fetchAll());
        echo('<br />'. 'success true ALL');
        exit;
    }
}

  // Respuesta del metodo POST para enviar datos a la BD, 
  if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $sql = "INSERT INTO regions (id_reg, description, status) VALUES (:id_reg, :description, :status)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id_reg', $_POST['id_reg']);
    $stmt->bindValue(':description', $_POST['description']);
    $stmt->bindValue(':status', $_POST['status']);
    $stmt->execute();
    // ocupamos lastInsertId para validar el id insertado, el cual por la base de datos debe ser AI
    $idPost = $pdo->lastInsertId();
     // SI idPost es true imprimimos el id agregado
    if($idPost){
         header("HTTP/1.1 200 OK");
         echo json_encode($idPost);
         echo('<br />'. 'success true');
         exit;
    }
}
   // Respuesta del metodo DELETE para eliminar registros por id
if($_SERVER['REQUEST_METHOD'] == 'DELETE'){

 $sql = "DELETE FROM regions WHERE id_reg=:id_reg";
 $stmt = $pdo->prepare($sql);
 $stmt->bindValue(':id_reg', $_GET['id_reg']);
 $stmt->execute();
 header("HTTP/1.1 200 OK");
 echo('<br />'. 'success true');
 exit;
}
  

?>