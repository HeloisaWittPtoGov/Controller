<?php

require_once '../lib/libUtils.php';
require_once '../lib/libDatabase.php';

require_once '../model/mdlTbResponsavel.php';
require_once '../model/mdlTbProjeto.php';

if (isset($_GET['action']) && $_GET['action'] == 'winConsulta') {
  require_once '../view/viwConsultaProjeto.php';
}

if(isset($_GET['action']) && $_GET['action'] == 'incluir'){
  require_once '../view/viwCadastroProjeto.php';
}

if(isset($_GET['action']) && $_GET ['action'] == 'ListProjeto'){
  $objFilter = new Filter($_GET);
  $strFiltro = $objFilter->GetWhere();

  $aroTbProjeto = TbProjeto::ListByCondicao($strFiltro, $objFilter->GetOrderBy());

  if(is_array($aroTbProjeto) && count($aroTbProjeto) > 0){
    $arrLinhas = [];
    $arrTempor = [];

    foreach($aroTbProjeto as $objTbProjeto){
      $arrTempor["idprojeto"] = $objTbProjeto->Get("idprojeto");
      $arrTempor["dstitulo"]= $objTbProjeto->Get("dstitulo");
      $arrTempor["dsdescricao"]= $objTbProjeto->Get("dsdescricao");
      $arrTempor["dtinicio"]= $objTbProjeto->Get("dtinicio");
      $arrTempor["dtprevistatermino"]= $objTbProjeto->Get("dtprevistatermino");
      $arrTempor["flstatus"]= $objTbProjeto->Get("flstatus");

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