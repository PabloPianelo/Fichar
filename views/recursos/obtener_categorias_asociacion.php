<?php


// require '../../models/CategoriaModel.php';

// $idasociacion = isset($_GET['idasociacion']) ? $_GET['idasociacion'] : null;

// $categoriaModel = new CategoriaModel();

// $categorias = $categoriaModel->getAsocicion($idasociacion);

// echo json_encode($categorias);



$servername = "localhost";
$username = "root";
$password = "";
$database = "fichar_proyecto";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
} else {
    $asociacion = $_GET['idasociacion']; 

    $sql = "SELECT * FROM categoria WHERE id_Asociacion = ? AND nombre != 'NULL'";
    
    $stmt = $conn->prepare($sql);
    
    $stmt->bind_param("i", $asociacion); 
    
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $resultados = array();
        while ($row = $result->fetch_assoc()) {
            $resultados[] = $row;
        }
        echo json_encode($resultados);
    }
    $conn->close();
    $stmt->close();
}
?>

















