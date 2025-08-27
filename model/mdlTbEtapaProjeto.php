<?php

class TbEtapaProjeto{
  //-----------------------------------------------------------------------------------------------------------------------------------------//
  // Métodos de Definição da classe [CLASS]
  //-----------------------------------------------------------------------------------------------------------------------------------------//
  
  // Propriedades Persistentes
  private $idetapaprojeto;
  private $idprojeto;
  private $nmetapa;
  private $dtprevistainicio;
  private $dtprevistatermino;
  private $flstatus;
  private $idresponsaveletapaprojeto;

  /**
   * Método Construct para limpeza do Objeto
   */

  public function __construct() {
    $this->idetapaprojeto = "";
    $this->idprojeto = "";
    $this->nmetapa = "";
    $this->dtprevistainicio = "";
    $this->dtprevistatermino = "";
    $this->flstatus = "";
    $this->idresponsaveletapaprojeto = "";
  }
  /**
   * Método Set para carga do objeto
   **/  
  public function Set($prpTbEtapaProjeto, $vlTbEtapaProjeto){
    $this->$prpEtapaProjeto = $vlTbEtapaProjeto;
  }
    /**
   * Método Get para carga do objeto
   **/  
  public function Get($prpEtapaProjeto){
    return $this->$prpEtapaProjeto;
  }
  /**
   * @param $resSet
   * @return TbProjeto
   */
  public function LoadObject($resSet){
    $objTbEtapaProjeto = new TbEtapaProjeto();
    $objTbEtapaProjeto->Set("idetapaprojeto", $resSet["idetapaprojeto"]);
    $objTbEtapaProjeto->Set("idprojeto", $resSet["idprojeto"]);
    $objTbEtapaProjeto->Set("nmetapa", $resSet["nmetapa"]);
    $objTbEtapaProjeto->Set("dtprevistainicio", $resSet["dtprevistainicio"]);
    $objTbEtapaProjeto->Set("dtprevistatermino", $resSet["dtprevistatermino"]);
    $objTbEtapaProjeto->Set("flstatus", $resSet["flstatus"]);
    $objTbEtapaProjeto->Set("idresponsaveletapaprojeto", $resSet["idresponsaveletapaprojeto"]);
    return $objTbEtapaProjeto;
  }

  //-----------------------------------------------------------------------------------------------------------------------------------------//
  // Métodos de Manutenção do Objeto
  //-----------------------------------------------------------------------------------------------------------------------------------------//

   /**
    * Insere um registro na tabela TbProjeto
    * @param mixed $objTbProjeto -> Objeto com os dados a serem inseridos
    * @return string[]
    */ 

   public function Insert($objTbEtapaProjeto){
    $dtblink = new DtbCliente();

    $dsSql = "INSERT INTO
                shtreinamento.tbetapaprojeto(
                  idetapaprojeto,
                  idprojeto,
                  nmetapa,
                  dtprevistainicio,
                  dtprevistatermino,
                  flstatus,
                  idresponsaveletapaprojeto
                )
                VALUES(
                  (SELECT NEXTVAL('shtreinamento.sqidetapaprojeto')),
                  '".$objTbEtapaProjeto->Get("idprojeto")."',
                  '".$objTbEtapaProjeto->Get("nmetapa")."',
                  '".$objTbEtapaProjeto->Get("dtprevistainicio")."',
                  '".$objTbEtapaProjeto->Get("dtprevistaitermino")."',
                  '".$objTbEtapaProjeto->Get("dflstatus")."',
                  '".$objTbEtapaProjeto->Get("idresponsaveletapaprojeto")."'
                )";
    if(!$dtblink->Exec($dsSql)){
      $arrMsg = $dtblink->getMessage();
    }else{
      $arrMsg["dsMsg"] = "ok";
    }
    return $arrMsg;           
   }

   /**
    * Alterar um registro na tabela TbProjeto
    * @param mixed $objTbProjeto -> Objeto com os dados a serem Alterados
    * @return string[]
    */ 
   public function Update($objTbEtapaProjeto){
    $dtblink = new DtbCliente();

    $dsSql= "UPDATE
              shtreinamento.tbetapaprojeto
            SET
              nmetapa = '".$objTbProjeto->Get("nmetapa")."',  
              dtprevistainicio = '".$objTbProjeto->Get("dtprevistainicio")."'
              dtprevistatermino = '".$objTbProjeto->Get("dtprevistatermino")."'
              flstatus = '".$objTbProjeto->Get("flstatus")."'
              idresponsaveletapaprojeto = '".$objTbProjeto->Get("idresponsaveletapaprojeto")."'
            WHERE 
              idetapaprojeto = ".$objTbEtapaProjeto->Get("idetapaprojeto").";";
    if(!$drblink->Exec($dsSql)){
      $arrMsg = $dtblink->getMessage();
    } else{
      $arrMsg["dsMsg"] = "ok";
    }          
    return $arrMsg;
   }

   /**
    * Elimina um registro na tabela TbProjeto
    * @param mixed $objTbProjeto -> Objeto com os dados a serem eliminados
    * @return string[]
    */ 

   public function Delete($objTbEtapaProjeto){
    $dtblink = new DtbCliente();

    $dsSql = "DELETE FROM
                shtreinamento.tbetapaprojeto
              WHERE
                idetapaprojeto = ".$objTbEtapaProjeto->Get("idetapaprojeto").";";
    if(!$dtblink->Exec($dsSql)){
      $arrMsg = $dtblink->getMessage();
    } else{
      $arrMsg["dsMsg"] = "ok";
    } 
    return $arrMsg;          
   }

   //-----------------------------------------------------------------------------------------------------------------------------------------//
  //Métodos de Consulta do Objeto
  //-----------------------------------------------------------------------------------------------------------------------------------------//

  /**
   * Busca os dados da tabela pela condição da chave primaria
   * @param $idEtapaProjeto -> Chave a ser buscada
   * @return TbEtapaProjeto
   **/  
  public function LoadByIdEtapaProjeto($idEtapaProjeto){
    $dtblink = new DtbCliente();
    $fmt = new Format();
    $objTbEtapaProjeto = new TbEtapaProjeto();

    $dsSql = "SELECT
                ep.*
              FROM
                shtreinamento.tbetapaprojeto ep
              WHERE
                ep.idetapaprojeto = ".$idetapaprojeto;
    if(!$dtblink->Query($dsSql)){
      return $fmt->RemoveQuebraLinha($dtbLink->getMessage()["dsMsg"]."<br>");
    }  
    else{
      $resSet = $dtblink->FetchArray();
      $objTbEtapaProjeto = $objTbEtapaProjeto->LoadObject($resSet);
      return $objTbEtapaProjeto;
    }        
  }

  /**
   * Busca os dados da tabela com parâmetros de condição e ordenação
   * @param $strCondicao -> Condição da pesquisa
   * @param $strOrdenacao -> Ordenação da pesquisa
   * @return TbEtapaProjeto[]
   **/
  public function LoadByCondicao($strCondicao, $strOrdenacao){
    $dtbLink= new DtbCliente();
    $fmt = new Format();
    $objTbEtapaProjeto = new TbEtapaProjeto;  

    $dsSql = "SELECT
                 ep.*
              FROM    
                shtreinamento.tbetapaprojeto ep
              WHERE
              1 = 1 ";
    if($strCondicao != ""){
      $dsSql .=$strCondicao;
    }   
    if($strOrdenacao != ""){
      $dsSql.=" ORDER BY ".$strOrdenacao;
    }
    if(!$dtbLink->Query($dsSql)){
      return $fmt->RemoveQuebraLinha($dtbLink->getMessage()["dsMsg"]."<br>");
    }   
    else{
      while($resSet = $dtbLink->FetchArray()){
        $aroTbEtapaProjeto = $objTbEtapaProjeto->LoadObject($resSet);
      }
      return $aroTbEtapaProjeto;
    }      
  }

   /**
   * Retorn o Próximo Id da Sequencia
   * @return int
   */

   public function GetNextId(){
    $dtbLink= new DtbCliente();
    $fmt = new Format();

    $dsSql = "SELECT NEXTVAL('shtreinamento.sqidetapaprojeto') AS nextid";

    if(!$dtbLink->Query($dsSql)){
      return $fmt->RemoveQuebraLinha($dtbLink->getMessage()["dsMsg"]."<br>");
    }
    else{
      $resSet = $dtbLink->FetchArray();
      return $resSet["nextid"];
    }
  }
}