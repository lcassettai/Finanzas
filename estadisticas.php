<?php
session_start();
require 'admin/config.php';
require 'funciones.php';


verificarSesion();

require 'views/estadisticas.view.php';

 ?>
