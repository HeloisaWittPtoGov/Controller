<?php

require_once '../lib/libUtils.php';
require_once '../lib/libDatabase.php';

require_once '../model/mdlTbResponsavel.php';
require_once '../model/mdlTbProjeto.php';
require_once '../model/mdlTbEtapaProjeto.php';

$objTbEtapaProjeto = new TbEtapaProjeto();
$objMsg = new Message();
$fmt = new Format();

if (isset($_GET['action']) && $_GET['action'] == 'winConsulta') {
  require_once '../view/viwConsultaEtapaProjeto.php';
}

if(isset($_GET['action']) && $_GET['action'] == 'incluir'){
  require_once '../view/viwCadastroEtapaProjeto.php';
}

if(isset($_GET['action']) && $_GET['action'] == 'editar'){
  $objTbEtapaProjeto = TbEtapaProjeto::LoadByIdEtapaProjeto($_GET['idEtapaProjeto']);
  require_once '../view/viwCadastroEtapaProjeto.php';
}

if(isset($_GET['action']) && $_GET ['action'] == 'ListEtapaProjeto'){
  $objFilter = new Filter($_GET);
  $strFiltro = $objFilter->GetWhere();

  $aroTbEtapaProjeto = TbEtapaProjeto::ListByCondicao($strFiltro, $objFilter->GetOrderBy());

  if(is_array($aroTbEtapaProjeto) && count($aroTbEtapaProjeto) > 0){
    $arrLinhas = [];
    $arrTempor = [];

    foreach($aroTbEtapaProjeto as $objTbEtapaProjeto){
      $arrTempor["idetapaprojeto"] = utf8_encode($objTbEtapaProjeto->Get("idetapaprojeto"));
      $arrTempor["idprojeto"] = utf8_encode($objTbEtapaProjeto->Get("idprojeto"));
      $arrTempor["nmetapa"] = utf8_encode($objTbEtapaProjeto->Get("nmetapa"));
      $arrTempor["dtprevistainicio"] = utf8_encode($fmt->data($objTbEtapaProjeto->Get("dtprevistainicio")));
      $arrTempor["dtprevistatermino"] = utf8_encode($fmt->data($objTbEtapaProjeto->Get("dtprevistatermino")));
      $arrTempor["flstatus"] = utf8_encode($objTbEtapaProjeto->Get("flstatus"));
      $arrTempor["idresponsaveletapaprojeto"] = utf8_encode($objTbEtapaProjeto->Get("idresponsaveletapaprojeto"));

      array_push($arrLinhas, $arrTempor);
    }

    echo '{"jsnEtapaProjeto":'.json_encode($arrLinhas).'}';
  }
  else if(!is_array($aroTbEtapaProjeto) && trim($aroTbEtapaProjeto) != ""){
    echo '{"error":"'.utf8_decode($aroTbEtapaProjeto).'"}';
  }
  else{
    echo '{"jsnEtapaProjeto": null}'; 
  }
}
if(isset($_GET['action']) && $_GET['action'] == "gravar"){
  $objTbEtapaProjeto->Set('idetapaprojeto',utf8_decode($_POST['idetapaprojeto']));
  $objTbEtapaProjeto->Set('idprojeto',utf8_decode($_POST['idProjeto']));
  $objTbEtapaProjeto->Set('nmetapa', utf8_decode($_POST['nmetapa']));
  $objTbEtapaProjeto->Set('dtprevistainicio', utf8_decode($fmt->data($_POST['dtprevistainicio'])));
  $objTbEtapaProjeto->Set('dtprevistatermino', utf8_decode($fmt->data($_POST['dtprevistatermino'])));
  $objTbEtapaProjeto->Set('flstatus', utf8_decode($_POST['flstatus']));
  $objTbEtapaProjeto->Set('idresponsaveletapaprojeto',utf8_decode($_POST['idresponsaveletapaprojeto']));

  $strMessage = "";
  
  if($objTbEtapaProjeto->Get('nmetapa') ==  ""){
    $strMessage .= "&raquo; O campo <strong>Titulo</strong> e de preeenchimento obrigatorio.<br>";
  }
  if($objTbEtapaProjeto->Get("dtprevistainicio") == ""){
    $strMessage .= "&raquo; O campo <strong>Data de Inicio</strong> e de preenchimento obrigatorio.<br>";
  }
  if($objTbEtapaProjeto->Get("dtprevistatermino") == ""){
    $strMessage .= "&raquo; O campo <strong>Data Prevista de Termino</strong> e de preenchimento obrigatorio.<br>";
  }
  if($objTbEtapaProjeto->Get("flstatus") == ""){
    $strMessage .= "&raquo; O campo <strong>Status</strong> e de preenchimento obrigatorio.<br>";
  }

  if($strMessage != ""){
    $objMsg->Alert('dlg', $strMessage);
  }
  else{
    if($objTbEtapaProjeto->Get('idetapaprojeto') != ""){ //Update
      $arrResult = $objTbEtapaProjeto->Update($objTbEtapaProjeto);

      if($arrResult["dsMsg"] == 'ok'){
        $objMsg->Succes('ntf', "Registro alterado com sucesso!");
        $objTbEtapaProjeto = new TbEtapaProjeto();
      }
      else{
        $objMsg->LoadMessage($arrResult);
      }
    }
    else{ //Insert
      $arrResult = $objTbEtapaProjeto->Insert($objTbEtapaProjeto);

      if($arrResult["dsMsg"] == 'ok'){
        $objMsg->Succes('ntf', "Registro inserido com sucesso!");
        $objTbEtapaProjeto = new TbEtapaProjeto();
      }
      else{
        $objMsg->LoadMessage($arrResult);
      }
    }
  }
}

if(isset($_GET['action']) && $_GET['action'] == 'excluir'){
  $objTbEtapaProjeto = TbEtapaProjeto::LoadByIdEtapaProjeto($_POST['idEtapaProjeto']);
  $arrResult = $objTbEtapaProjeto->Delete($objTbEtapaProjeto);
  
  if($arrResult['dsMsg'] == 'ok'){
    $objMsg->Succes('ntf', "Registro excluido com sucesso!");
    $objTbEtapaProjeto = new TbEtapaProjeto();
  }
  else{
    $objMsg->LoadMessage($arrResult);
  }
}


