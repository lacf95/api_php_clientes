<?php
class MiBD extends SQLite3 {
  function __construct() {
    $this->open('./ventas.db');
  }
}
?>
