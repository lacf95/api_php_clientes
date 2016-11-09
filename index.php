<?php
require "clientes.php";
header("Content-Type: application/json");

$C_Method = $_SERVER["REQUEST_METHOD"];
$O_Clientes = new Clientes();

if ($C_Method == "GET") {
  if ($_GET["id"]) {
    $N_Id = intVal($_GET["id"]);
    $O_Result = $O_Clientes->getCliente($N_Id);
  } else {
    $O_Result = $O_Clientes->getClientes();
  }
  http_response_code($O_Result[0]);
  echo json_encode($O_Result[1]);
} else if ($C_Method == "POST") {
  $C_Nombre = $_POST["nombre"];
  $C_Direccion = $_POST["direccion"];
  $C_Telefono = $_POST["telefono"];
  $C_Correo = $_POST["correo"];
  $O_Response = $O_Clientes->setCliente($C_Nombre, $C_Direccion, $C_Telefono, $C_Correo);
  http_response_code($O_Response[0]);
  echo json_encode(["status" => $O_Response[1]]);
} else if ($C_Method == "PUT") {
  parse_str(file_get_contents("php://input"), $_PUT);
  $N_Id = intVal($_PUT["id"]);
  $C_Nombre = $_PUT["nombre"];
  $C_Direccion = $_PUT["direccion"];
  $C_Telefono = $_PUT["telefono"];
  $C_Correo = $_PUT["correo"];
  $O_Response = $O_Clientes->updateCliente($N_Id, $C_Nombre, $C_Direccion, $C_Telefono, $C_Correo);
  http_response_code($O_Response[0]);
  echo json_encode(["status" => $O_Response[1]]);
} else if ($C_Method == "DELETE") {
  parse_str(file_get_contents("php://input"), $O_Body);
  $N_Id = intVal($O_Body["id"]);
  $O_Response = $O_Clientes->destroyCliente($N_Id);
  http_response_code($O_Response[0]);
  echo json_encode(["status" => $O_Response[1]]);
} else {
  http_response_code(400);
  echo json_encode(["status" => "Método no soportado $C_Method"]);
}
?>
