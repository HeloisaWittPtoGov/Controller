<?php

require_once '../lib/libUtils.php';
require_once '../lib/libDatabase.php';

require_once '../model/mdlTbResponsavel.php';
require_once '../model/mdlTbProjeto.php';
require_once '../model/mdlTbEtapaProjeto.php';

$objTbProjeto = new TbProjeto();
$objMsg = new Message();
$fmt = new Format();


//------------------------------------------------------------------------------------------------------------------------------------------------------//

//------------------------------------------------------------------------------------------------------------------------------------------------------//
//Ação de Abertura da Tela de Consulta
//------------------------------------------------------------------------------------------------------------------------------------------------------//

if (isset($_GET['action']) && $_GET['action'] == 'winConsulta') {
  require_once '../view/viwConsultaProjeto.php';
}
//------------------------------------------------------------------------------------------------------------------------------------------------------//

//------------------------------------------------------------------------------------------------------------------------------------------------------//
//Ação de Inclusão de Registros
//------------------------------------------------------------------------------------------------------------------------------------------------------//

if(isset($_GET['action']) && $_GET['action'] == 'incluir'){
  require_once '../view/viwCadastroProjeto.php';
}
//------------------------------------------------------------------------------------------------------------------------------------------------------//

//------------------------------------------------------------------------------------------------------------------------------------------------------//
//Ação de Edição de Registros
//------------------------------------------------------------------------------------------------------------------------------------------------------//

if(isset($_GET['action']) && $_GET['action'] == 'editar'){
  $objTbProjeto = TbProjeto::LoadByIdProjeto($_GET['idProjeto']);
  require_once '../view/viwCadastroProjeto.php';
}

//------------------------------------------------------------------------------------------------------------------------------------------------------//

//------------------------------------------------------------------------------------------------------------------------------------------------------//
//Ação para consulta de Registros
//------------------------------------------------------------------------------------------------------------------------------------------------------//
if(isset($_GET['action']) && $_GET ['action'] == 'ListProjeto'){
  //Verificando o Filtro
  $objFilter = new Filter($_GET);
  $strFiltro = $objFilter->GetWhere();

  $aroTbProjeto = TbProjeto::ListByCondicao($strFiltro, $objFilter->GetOrderBy());

  if(is_array($aroTbProjeto) && count($aroTbProjeto) > 0){
    $arrLinhas = [];
    $arrTempor = [];

    foreach($aroTbProjeto as $objTbProjeto){
      $arrTempor["idprojeto"] = utf8_encode($objTbProjeto->Get("idprojeto"));
      $arrTempor["dstitulo"] = utf8_encode($objTbProjeto->Get("dstitulo"));
      $arrTempor["dsdescricao"] = utf8_encode($objTbProjeto->Get("dsdescricao"));
      $arrTempor["dtinicio"] = utf8_encode($fmt->data($objTbProjeto->Get("dtinicio")));
      $arrTempor["dtprevistatermino"] = utf8_encode($fmt->data($objTbProjeto->Get("dtprevistatermino")));
      $arrTempor["flstatus"] = utf8_encode($objTbProjeto->Get("flstatus"));

      array_push($arrLinhas, $arrTempor);
    }

    echo '{"jsnProjeto":'.json_encode($arrLinhas).'}';
  }
  else if(!is_array($aroTbProjeto) && trim($aroTbProjeto) != ""){
    echo '{"error":"'.utf8_decode($aroTbProjeto).'"}';
  }
  else{
    echo '{"jsnProjeto": null}';
  }
}
//------------------------------------------------------------------------------------------------------------------------------------------------------//

//------------------------------------------------------------------------------------------------------------------------------------------------------//
//Ação para gravação de registros
//------------------------------------------------------------------------------------------------------------------------------------------------------//

if(isset($_GET['action']) && $_GET['action'] == "gravar"){
  $objTbProjeto->Set('idprojeto',utf8_decode($_POST['idProjeto']));
  $objTbProjeto->Set('dstitulo', utf8_decode($_POST['dsTitulo']));
  $objTbProjeto->Set('dsdescricao', utf8_decode($_POST['dsDescricao']));
  $objTbProjeto->Set('dtinicio', utf8_decode($fmt->data($_POST['dtInicio'])));
  $objTbProjeto->Set('dtprevistatermino', utf8_decode($fmt->data($_POST['dtPrevistaTermino'])));
  $objTbProjeto->Set('flstatus',utf8_decode($_POST['flStatus']));

  //Efetuando as validações
  $strMessage = "";
  
  if(empty($objTbProjeto->Get('dstitulo') ==  "")){
    $strMessage .= "&raquo; O campo <strong>Titulo</strong> e de preeenchimento obrigatorio.<br>";
  }
  if(empty($objTbProjeto->Get("dsdescricao") == "")){
    $strMessage .= "&raquo; O campo <strong>Descricao</strong> e de preenchimento obrigatorio.<br>";
  }
  if(empty($objTbProjeto->Get("dtinicio") == ""))
    $strMessage .= "&raquo; O campo <strong>Data de Inicio</strong> e de preenchimento obrigatorio.<br>";
  }
  if(empty($objTbProjeto->Get("dtprevistatermino") == "")){
    $strMessage .= "&raquo; O campo <strong>Data Prevista de Termino</strong> e de preenchimento obrigatorio.<br>";
  }
  if(empty($objTbProjeto->Get("flstatus") == "")){
    $strMessage .= "&raquo; O campo <strong>Status</strong> e de preenchimento obrigatorio.<br>";
  }
  
  //Caso tenha encontrado erros abre a janela de alerta
  if($strMessage != ""){
    $objMsg->Alert('dlg', $strMessage);
  }
  else{
    if($objTbProjeto->Get('idprojeto') != ""){ //Update
      $arrResult = $objTbProjeto->Update($objTbProjeto);

      if($arrResult["dsMsg"] == 'ok'){
        $objMsg->Succes('ntf', "Registro alterado com sucesso!");
        $objTbProjeto = new TbProjeto();
      }
      else{
        $objMsg->LoadMessage($arrResult);
      }
    }
    else{ //Insert
      $arrResult = $objTbProjeto->Insert($objTbProjeto);

      if($arrResult["dsMsg"] == 'ok'){
        $objMsg->Succes('ntf', "Registro inserido com sucesso!");
        $objTbProjeto = new TbProjeto();

      }
      else{
        $objMsg->LoadMessage($arrResult);
      }
    }
  }


//------------------------------------------------------------------------------------------------------------------------------------------------------//

  //------------------------------------------------------------------------------------------------------------------------------------------------------//
  //Ação para exclusão de registros
  //------------------------------------------------------------------------------------------------------------------------------------------------------//
if(isset($_GET['action']) && $_GET['action'] == 'excluir'){
  $objTbProjeto = TbProjeto::LoadByIdProjeto($_POST['idProjeto']);
  $arrResult = $objTbProjeto->Delete($objTbProjeto);
  
  if($arrResult['dsMsg'] == 'ok'){
    $objMsg->Succes('ntf', "Registro excluido com sucesso!");
    $objTbProjeto = new TbProjeto();
  }
  else{
    $objMsg->LoadMessage($arrResult);
  }
}
 //------------------------------------------------------------------------------------------------------------------------------------------------------//




