<?php

require_once '../lib/libUtils.php';
require_once '../lib/libDatabase.php';

require_once '../model/mdlTbEntrega.php';
require_once '../model/mdlTbProjeto.php';
require_once '../model/mdlTbEtapaProjeto.php';

$objTbEntrega = new TbEntrega();
$objMsg = new Message();
$fmt = new Format();


  //------------------------------------------------------------------------------------------------------------------------------------------------------//
  //Ação de Abertura da Tela de Consulta
  //------------------------------------------------------------------------------------------------------------------------------------------------------//

if (isset($_GET['action']) && $_GET['action'] == 'winConsulta') {
  require_once '../view/viwConsultaEntrega.php';
}
  //------------------------------------------------------------------------------------------------------------------------------------------------------//

  //------------------------------------------------------------------------------------------------------------------------------------------------------//
  //Ação de Inclusão de Registros
  //------------------------------------------------------------------------------------------------------------------------------------------------------//

if(isset($_GET['action']) && $_GET['action'] == 'incluir'){
  require_once '../view/viwCadastroEntrega.php';
}
//------------------------------------------------------------------------------------------------------------------------------------------------------//


//------------------------------------------------------------------------------------------------------------------------------------------------------//
  //Ação de Edição de Registros
  //------------------------------------------------------------------------------------------------------------------------------------------------------//

if(isset($_GET['action']) && $_GET['action'] == 'editar'){
  $objTbEntrega = TbEntrega::LoadByIdEntrega($_GET['idEntrega']);
  require_once '../view/viwCadastroEntrega.php';
}
//------------------------------------------------------------------------------------------------------------------------------------------------------//


//------------------------------------------------------------------------------------------------------------------------------------------------------//
//Ação para consulta de Registros
//------------------------------------------------------------------------------------------------------------------------------------------------------//

if(isset($_GET['action']) && $_GET ['action'] == 'ListEntrega'){
  $objFilter = new Filter($_GET);
  $strFiltro = $objFilter->GetWhere();

  $aroTbEntrega = TbEntrega::ListByCondicao($strFiltro, $objFilter->GetOrderBy());

  if(is_array($aroTbProjeto) && count($aroTbProjeto) > 0){
    $arrLinhas = [];
    $arrTempor = [];

    foreach($aroTbEntrega as $objTbEntrega){
      $arrTempor["identrega"] = utf8_encode($objTbEntrega->Get("identrega"));
      $arrTempor["idetapaprojeto"] = utf8_encode($objTbEntrega->Get("idetapaprojeto"));
      $arrTempor["dsdescricao"] = utf8_encode($objTbEntrega->Get("dsdescricao"));
      $arrTempor["dtentrega"] = utf8_encode($fmt->data($objTbEntrega->Get("dtentrega")));
      $arrTempor["dsobservacao"] = utf8_encode($objTbEntrega->Get("dsobservacao"));
      array_push($arrLinhas, $arrTempor);
    }

    echo '{"jsnEntrega":'.json_encode($arrLinhas).'}';
  }
  else if(!is_array($aroTbEntrega) && trim($aroTbEntrega) != ""){
    echo '{"error":"'.utf8_decode($aroTbEntrega).'"}';
  }
  else{
    echo '{"jsnEntrega": null}';
  }
}
//------------------------------------------------------------------------------------------------------------------------------------------------------//

//------------------------------------------------------------------------------------------------------------------------------------------------------//
//Ação para gravação de registros
//------------------------------------------------------------------------------------------------------------------------------------------------------//

if(isset($_GET['action']) && $_GET['action'] == "gravar"){
  $objTbEntrega->Set('identrega',utf8_decode($_POST['identrega']));
  $objTbEntrega->Set('idetapaprojeto', utf8_decode($_POST['idetapaprojeto']));
  $objTbEntrega->Set('dsdescricao', utf8_decode($_POST['dsDescricao']));
  $objTbEntrega->Set('dtentrega', utf8_decode($fmt->data($_POST['dtentrega'])));
  $objTbEntrega->Set('dsobservacao', utf8_decode($_POST['dsobservacao']));

   //Efetuando as validações
  $strMessage = "";
  

  if(empty($objTbEntrega->Get("dsdescricao") == "")){
    $strMessage .= "&raquo; O campo <strong>Descricao</strong> e de preenchimento obrigatorio.<br>";
  }
  if(empty($objTbEntrega->Get("dtinicio") == "")){
    $strMessage .= "&raquo; O campo <strong> Data de Entrega</strong> e de preenchimento obrigatorio.<br>";
  }
 
  //Caso tenha encontrado erros abre a janela de alerta
  if($strMessage != ""){
    $objMsg->Alert('dlg', $strMessage);
  }
  else{
    if($objTbEntrega->Get('idprojeto') != ""){ //Update
      $arrResult = $objTbEntrega->Update($objTbEntrega);

      if($arrResult["dsMsg"] == 'ok'){
        $objMsg->Succes('ntf', "Registro alterado com sucesso!");
        $objTbEntrega = new TbEntrega();
      }
      else{
        $objMsg->LoadMessage($arrResult);
      }
    }
    else{ //Insert
      $arrResult = $objTbEntrega->Insert($objTbEntrega);

      if($arrResult["dsMsg"] == 'ok'){
        $objMsg->Succes('ntf', "Registro inserido com sucesso!");
        $objTbEntrega = new TbEntrega();

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
  $objTbEntrega = TbEntrega::LoadByIdEntrega($_POST['idEntrega']);
  $arrResult = $objTbEntrega->Delete($objTbEntrega);
  
  if($arrResult['dsMsg'] == 'ok'){
    $objMsg->Succes('ntf', "Registro excluido com sucesso!");
    $objTbEntrega = new TbEntrega();
  }
  else{
    $objMsg->LoadMessage($arrResult);
  }
}
//------------------------------------------------------------------------------------------------------------------------------------------------------//



