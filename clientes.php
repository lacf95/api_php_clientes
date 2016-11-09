<?php
require "dbConnection.php";
/**
 *
 */
class Clientes {
  private $O_Bd;

  function __construct() {
    $this->O_Bd = new MiBD();
  }

  function getClientes() {
    $C_Query = "SELECT * FROM clientes";
    $O_Clientes = [];
    $O_Result = $this->O_Bd->query($C_Query);
    while ($O_Row = $O_Result->fetchArray()) {
      array_push($O_Clientes, [
        "id" => $O_Row["id"],
        "nombre" => $O_Row["nombre"],
        "direccion" => $O_Row["direccion"],
        "telefono" => $O_Row["telefono"],
        "correo" => $O_Row["correo"],
      ]);
    }
    return [200, $O_Clientes];
  }

  function getCliente($N_Id) {
    if (is_numeric($N_Id)) {
      $C_Query = "SELECT * FROM clientes WHERE id = $N_Id";
      $O_Result = $this->O_Bd->querySingle($C_Query, true);
      $O_Response = [200, $O_Result];
    } else {
      $O_Response = [400, "Parámetros inválidos"];
    }
    return $O_Response;
  }

  function setCliente($C_Nombre, $C_Direccion, $C_Telefono, $C_Correo) {
    if (!empty($C_Nombre) && !empty($C_Direccion) && !empty($C_Telefono) && !empty($C_Correo)) {
       $O_Result = $this->O_Bd->query("SELECT correo FROM clientes WHERE correo = '$C_Correo'");
       $N_I = 0;
       while ($row = $O_Result->fetchArray())
          $N_I++;
       if ($N_I == 0) {
          $C_Query = "INSERT INTO clientes(nombre, direccion, telefono, correo) VALUES ('$C_Nombre', '$C_Direccion', '$C_Telefono', '$C_Correo')";
          if ($this->O_Bd->exec($C_Query))
             $O_Response = [200, "Cliente creado"];
          else
             $O_Response = [500, "Error interno del servidor"];
       } else
          $O_Response = [400, "Correo inválido"];
    } else
       $O_Response = [400, "Parámetros inválidos"];
    return $O_Response;
  }

  function updateCliente($N_Id, $C_Nombre, $C_Direccion, $C_Telefono, $C_Correo) {
    if (is_int($N_Id) && !empty($C_Nombre) && !empty($C_Direccion) && !empty($C_Telefono) && !empty($C_Correo)) {
      $C_Query = "UPDATE clientes SET nombre='$C_Nombre', direccion='$C_Direccion', telefono='$C_Telefono', correo='$C_Correo' WHERE id=$N_Id";
      if ($this->O_Bd->exec($C_Query))
         $O_Response = [200, "Cliente actualizado"];
      else
         $O_Response = [500, "Error interno del servidor"];
    } else
       $O_Response = [400, "Parámetros inválidos"];
    return $O_Response;
  }

  function destroyCliente($N_Id) {
    if (is_int($N_Id)) {
       $C_Query = "DELETE FROM clientes WHERE id = $N_Id";
       if ($this->O_Bd->exec($C_Query))
          $O_Response = [200, "Cliente eliminado"];
       else
          $O_Response = [500, "Error interno del servidor"];
    } else
       $O_Response = [400, "Parámetros inválidos"];
    return $O_Response;
  }
}
?>
