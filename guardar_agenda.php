<?php
header('Content-Type: application/json');

// Configuración de la base de datos
$servername = "localhost";
$username = "tu_usuario";
$password = "tu_contraseña";
$dbname = "nombre_base_datos";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Error de conexión']));
}

// Obtener datos del POST
$data = json_decode(file_get_contents('php://input'), true);

// Preparar y ejecutar consulta
$stmt = $conn->prepare("INSERT INTO agendamientos (email, documento, hora, fecha) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $data['email'], $data['documento'], $data['hora'], $data['fecha']);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al guardar']);
}

$stmt->close();
$conn->close();
?>