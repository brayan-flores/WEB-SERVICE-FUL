<?php

 // Incluimos la conexion para poder ocupar la clase
 include 'conexion.php';
 
    $pdo = new Conexion();

    // Declaramos la repuesta del metodo GET , si el metodo es true nos traera el id especifico que selecionemos en la ruta 'localhost..../?dni=1'
    if($_SERVER['REQUEST_METHOD'] == 'GET'){

       if(isset($_GET['dni'])){
        $sql = $pdo->prepare("SELECT * FROM customers WHERE dni =:dni");
        $sql->bindValue(':dni', $_GET['dni']);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($sql->fetchAll());
        echo('<br />'. 'success true');
        exit;
       } 
       // En caso de ser false nos arroja toda la informacion de los dni
       else{

        $sql = $pdo->prepare("SELECT * FROM customers");
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

    $sql = "INSERT INTO customers (dni, id_reg, id_com, email, name, last_name, address, date_reg, status) VALUES (:dni, :id_reg, :id_com, :email, :name, :last_name, :address, :date_reg, :status)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':dni', $_POST['dni']);
    $stmt->bindValue(':id_reg', $_POST['id_reg']);
    $stmt->bindValue(':id_com', $_POST['id_com']);
    $stmt->bindValue(':email', $_POST['email']);
    $stmt->bindValue(':name', $_POST['name']);
    $stmt->bindValue(':last_name', $_POST['last_name']);
    $stmt->bindValue(':address', $_POST['address']);
    $stmt->bindValue(':date_reg', $_POST['date_reg']);
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

 $sql = "DELETE FROM customers WHERE dni=:dni";
 $stmt = $pdo->prepare($sql);
 $stmt->bindValue(':dni', $_GET['dni']);
 $stmt->execute();
 header("HTTP/1.1 200 OK");
 echo('<br />'. 'success true');
 exit;
}
  

?>