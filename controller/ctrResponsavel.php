<?php

require_once '../lib/libUtils.php';
require_once '../lib/libDatabase.php';

require_once '../model/mdlTbResponsavel.php';
require_once '../model/mdlTbProjeto.php';
require_once '../model/mdlTbEtapaProjeto.php';

$objTbResponsavelEtapaProjeto = new TbResponsavelEtapaProjeto();
$objMsg = new Message();
$fmt = new Format();

if (isset($_GET['action']) && $_GET['action'] == 'winConsulta') {
  require_once '../view/viwConsultaResponsavel.php';
}

if(isset($_GET['action']) && $_GET['action'] == 'incluir'){
  require_once '../view/viwCadastroResponsavel.php';
}

if(isset($_GET['action']) && $_GET['action'] == 'editar'){
  $objTbResponsavelEtapaProjeto = TbResponsavelEtapaProjeto::LoadByIdResponsavelEtapaProjeto($_GET['idresponsaveletapaprojeto']);
  require_once '../view/viwCadastroResponsavel.php';
}

if(isset($_GET['action']) && $_GET ['action'] == 'ListResponsavel'){
  $objFilter = new Filter($_GET);
  $strFiltro = $objFilter->GetWhere();

  $aroTbResponsavel = TbResponsavelEtapaProjeto::ListByCondicao($strFiltro, $objFilter->GetOrderBy());

  if(is_array($aroTbResponsavel) && count($aroTbResponsavel) > 0){
    $arrLinhas = [];
    $arrTempor = [];

    foreach($aroTbResponsavel as $objTbResponsavelEtapaProjeto){
      $arrTempor["idresponsaveletapaprojeto"] = utf8_encode($objTbResponsavelEtapaProjeto->Get("idresponsaveletapaprojeto"));
      $arrTempor["nmresponsavel"] = utf8_encode($objTbResponsavelEtapaProjeto->Get("nmresponsavel"));
      $arrTempor["dssetor"] = utf8_encode($objTbResponsavelEtapaProjeto->Get("dssetor"));
      $arrTempor["dsfuncao"] = utf8_encode($objTbResponsavelEtapaProjeto->Get("dsfuncao"));
      $arrTempor["dsemail"] = utf8_encode($objTbResponsavelEtapaProjeto->Get("dsemail"));
      array_push($arrLinhas, $arrTempor);
    }

    echo '{"jsnResponsavel":'.json_encode($arrLinhas).'}';
  }
  else if(!is_array($aroTbResponsavel) && trim($aroTbResponsavel) != ""){
    echo '{"error":"'.utf8_decode($aroTbResponsavelEtapaProjeto).'"}';
  }
  else{
    echo '{"jsnResponsavel": null}'; 
  }
}
if(isset($_GET['action']) && $_GET['action'] == "gravar"){
  $objTbResponsavelEtapaProjeto->Set('idresponsaveletapaprojeto',utf8_decode($_POST['idresponsaveletapaprojeto']));
  $objTbResponsavelEtapaProjeto->Set('nmresponsavel', utf8_decode($_POST['nmresponsavel']));
  $objTbResponsavelEtapaProjeto->Set('dssetor', utf8_decode($_POST['dssetor']));
  $objTbResponsavelEtapaProjeto->Set('dsfuncao', utf8_decode($_POST['dsfuncao']));
  $objTbResponsavelEtapaProjeto->Set('dsemail', utf8_decode($_POST['dsemail']));
 

  $strMessage = "";
  
  if($objTbResponsavelEtapaProjeto->Get('nmresponsavel') ==  ""){
    $strMessage .= "&raquo; O campo <strong>Nome</strong> e de preeenchimento obrigatorio.<br>";
  }
  if($objTbResponsavelEtapaProjeto->Get("dssetor") == ""){
    $strMessage .= "&raquo; O campo <strong>Setor/strong> e de preenchimento obrigatorio.<br>";
  }
  if($objTbResponsavelEtapaProjeto->Get("dsfuncao") == ""){
    $strMessage .= "&raquo; O campo <strong>Funcao</strong> e de preenchimento obrigatorio.<br>";
  }
  if($objTbResponsavelEtapaProjeto->Get("dsemail") == ""){
    $strMessage .= "&raquo; O campo <strong>E-mail</strong> e de preenchimento obrigatorio.<br>";
  }

  if($strMessage != ""){
    $objMsg->Alert('dlg', $strMessage);
  }
  else{
    if($objTbResponsavelEtapaProjeto->Get('idresponsaveletapaprojeto') != ""){ //Update
      $arrResult = $objTbResponsavelEtapaProjeto->Update($objTbResponsavelEtapaProjeto);

      if($arrResult["dsMsg"] == 'ok'){
        $objMsg->Succes('ntf', "Registro alterado com sucesso!");
        $objTbResponsavelEtapaProjeto = new TbResponsavelEtapaProjeto();
      }
      else{
        $objMsg->LoadMessage($arrResult);
      }
    }
    else{ //Insert
      $arrResult = $objTbResponsavelEtapaProjeto->Insert($objTbResponsavelEtapaProjeto);

      if($arrResult["dsMsg"] == 'ok'){
        $objMsg->Succes('ntf', "Registro inserido com sucesso!");
        $objTbResponsavelEtapaProjeto = new TbResponsavelEtapaProjeto();
      }
      else{
        $objMsg->LoadMessage($arrResult);
      }
    }
  }
}

if(isset($_GET['action']) && $_GET['action'] == 'excluir'){
  $objTbResponsavelEtapaProjeto = TbResponsavelEtapaProjeto::LoadByIdResponsavelEtapaProjeto($_POST['idResponsavelEtapaProjeto']);
  $arrResult = $objTbResponsavelEtapaProjeto->Delete($objTbResponsavelEtapaProjeto);
  
  if($arrResult['dsMsg'] == 'ok'){
    $objMsg->Succes('ntf', "Registro excluido com sucesso!");
    $objTbResponsavelEtapaProjeto = new TbResponsavelEtapaProjeto();
  }
  else{
    $objMsg->LoadMessage($arrResult);
  }
}
