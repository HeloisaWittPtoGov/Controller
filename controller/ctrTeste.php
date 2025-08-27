<?php

require_once '../lib/libUtils.php';
require_once '../lib/libDatabase.php';
require_once '../model/mdlTbResponsavel.php';

if (isset($_GET['action']) && $_GET['action'] == 'winConsulta') {
  require_once '../view/viwConsultaTeste.php';
}