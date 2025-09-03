<?php

require_once '../lib/libUtils.php';
require_once '../lib/libDatabase.php';

require_once '../model/mdlTbResponsavel.php';
require_once '../model/mdlTbProjeto.php';
require_once '../model/mdlTbEtapaProjeto.php';

$objTbResponsavelEtapaProjeto = new TbResponsavelEtapaProjeto();
$objMsg = new Message();
$fmt = new Format();

//------------------------------------------------------------------------------------------------------------------------------------------------------//
//Ação de Abertura da Tela de Consulta
//------------------------------------------------------------------------------------------------------------------------------------------------------//

if (isset($_GET['action']) && $_GET['action'] == 'winConsulta') {
  $frmResult = '';
  if($_GET['frmResult'] != '') {
    $frmResult = '#'.$_GET['frmResult'];
  }
  require_once '../view/viwConsultaResponsavel.php';
}

//------------------------------------------------------------------------------------------------------------------------------------------------------//

//------------------------------------------------------------------------------------------------------------------------------------------------------//
//Ação de Inclusão de Registros
//------------------------------------------------------------------------------------------------------------------------------------------------------//
if(isset($_GET['action']) && $_GET['action'] == 'incluir'){
  require_once '../view/viwCadastroResponsavel.php';
}
//------------------------------------------------------------------------------------------------------------------------------------------------------//

//------------------------------------------------------------------------------------------------------------------------------------------------------//
//Ação de Edição de Registros
//------------------------------------------------------------------------------------------------------------------------------------------------------//
if(isset($_GET['action']) && $_GET['action'] == 'editar'){
  $objTbResponsavelEtapaProjeto = TbResponsavelEtapaProjeto::LoadByIdResponsavelEtapaProjeto($_GET['idResponsavelEtapaProjeto']);
  require_once '../view/viwCadastroResponsavel.php';
}
//------------------------------------------------------------------------------------------------------------------------------------------------------//

//------------------------------------------------------------------------------------------------------------------------------------------------------//
//Ação para consulta de Registros
//------------------------------------------------------------------------------------------------------------------------------------------------------//

if(isset($_GET['action']) && $_GET ['action'] == 'ListResponsavel'){
  //Verificando o Filtro
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

    echo '{"jsnConsultaResponsavel":'.json_encode($arrLinhas).'}';
  }
  else if(!is_array($aroTbResponsavel) && trim($aroTbResponsavel) != ""){
    echo '{"error":"'.utf8_decode($aroTbResponsavelEtapaProjeto).'"}';
  }
  else{
    echo '{"jsnConsultaResponsavel": null}'; 
  }
}
//------------------------------------------------------------------------------------------------------------------------------------------------------//

//------------------------------------------------------------------------------------------------------------------------------------------------------//
//Ação para gravação de registros
//------------------------------------------------------------------------------------------------------------------------------------------------------//
if(isset($_GET['action']) && $_GET['action'] == "gravar"){
  $objTbResponsavelEtapaProjeto->Set('idresponsaveletapaprojeto',utf8_decode($_POST['idResponsavelEtapaProjeto']));
  $objTbResponsavelEtapaProjeto->Set('nmresponsavel', utf8_decode($_POST['nmResponsavel']));
  $objTbResponsavelEtapaProjeto->Set('dssetor', utf8_decode($_POST['dsSetor']));
  $objTbResponsavelEtapaProjeto->Set('dsfuncao', utf8_decode($_POST['dsFuncao']));
  $objTbResponsavelEtapaProjeto->Set('dsemail', utf8_decode($_POST['dsEmail']));
 
   //Efetuando as validações
  $strMessage = "";
  
  if(empty($objTbResponsavelEtapaProjeto->Get('nmresponsavel'))){
    $strMessage .= "&raquo; O campo <strong>Nome</strong> e de preeenchimento obrigatorio.<br>";
  }
  if(empty($objTbResponsavelEtapaProjeto->Get("dssetor"))){
    $strMessage .= "&raquo; O campo <strong>Setor</strong> e de preenchimento obrigatorio.<br>";
  }
  if(empty($objTbResponsavelEtapaProjeto->Get("dsfuncao"))){
    $strMessage .= "&raquo; O campo <strong>Funcao</strong> e de preenchimento obrigatorio.<br>";
  }
  if(empty($objTbResponsavelEtapaProjeto->Get("dsemail"))){
    $strMessage .= "&raquo; O campo <strong>E-mail</strong> e de preenchimento obrigatorio.<br>";
  }
  //Caso tenha encontrado erros abre a janela de alerta
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
//------------------------------------------------------------------------------------------------------------------------------------------------------//

//------------------------------------------------------------------------------------------------------------------------------------------------------//
//Ação para exclusão de registros
//------------------------------------------------------------------------------------------------------------------------------------------------------//

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
//------------------------------------------------------------------------------------------------------------------------------------------------------//

