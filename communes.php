<?php

 // Incluimos la conexion para poder ocupar la clase
 include 'conexion.php';
 
    $pdo = new Conexion();

    // Declaramos la repuesta del metodo GET , si el metodo es true nos traera el id especifico que selecionemos en la ruta 'localhost..../?id_com=1'
    if($_SERVER['REQUEST_METHOD'] == 'GET'){

       if(isset($_GET['id_com'])){
        $sql = $pdo->prepare("SELECT * FROM communes WHERE id_com =:id_com");
        $sql->bindValue(':id_com', $_GET['id_com']);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($sql->fetchAll());
        echo('<br />'. 'success true');
        exit;
       } 
       // En caso de ser false nos arroja toda la informacion de los id_com
       else{

        $sql = $pdo->prepare("SELECT * FROM communes");
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

    $sql = "INSERT INTO communes (id_com, description, status) VALUES (:id_com, :description, :status)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id_com', $_POST['id_com']);
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

 $sql = "DELETE FROM communes WHERE id_com=:id_com";
 $stmt = $pdo->prepare($sql);
 $stmt->bindValue(':id_com', $_GET['id_com']);
 $stmt->execute();
 header("HTTP/1.1 200 OK");
 echo('<br />'. 'success true');
 exit;
}
  

?>