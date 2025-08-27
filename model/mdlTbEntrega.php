<?php

class TbEntrega{
//-----------------------------------------------------------------------------------------------------------------------------------------//
  // Métodos de Definição da classe [CLASS]
  //-----------------------------------------------------------------------------------------------------------------------------------------//
  
  // Propriedades Persistentes

  private $identrega;
  private $dsdescricao;
  private $dtentrega;
  private $dsobservacao;
  private $idetapaprojeto;

  /**
   * Método Construct para limpeza do Objeto
   */
  public function __construct(){
    $this->identrega = "";
    $this->dsdescricao = "";
    $this->dtentrega = "";
    $this->dsobservacao = "";
    $this->idetapaprojeto = "";
  }
    /**
   * Método Set para carga do objeto
   **/  
  public function Set($prpTbEntrega, $vlTbEntrega){
    $this->$prpEntrega = $vlTbEntrega;
  }
    /**
   * Método Get para carga do objeto
   **/  
  public function Get($prpTbEntrega){
    return $this->$prpTbEntrega;
  }

  /**
   * @param $resSet
   * @return TbEntrega
   */
  public function LoadObject($resSet){
    $objTbEntrega = new TbEntrega();
    $objTbEntrega->Set("identrega", $resSet["identrega"]);
    $objTbEntrega->Set("dsdescricao", $resSet["dsdescricao"]);
    $objTbEntrega->Set("dtentrega", $resSet["dtentrega"]);
    $objTbEntrega->Set("dsobservacao", $resSet["dsobservacao"]);
    $objTbEntrega->Set("idetapaprojeto", $resSet["idetapaprojeto"]);
    return $objTbEntrega;
  }
  //-----------------------------------------------------------------------------------------------------------------------------------------//
  // Métodos de Manutenção do Objeto
  //-----------------------------------------------------------------------------------------------------------------------------------------//

   /**
    * Insere um registro na tabela TbEntrega
    * @param mixed $objTbEntrega -> Objeto com os dados a serem inseridos
    * @return string[]
    */ 

  public function Insert($objTbEntrega){
    $dtblink = new DtbCliente();

    $dsSql = "INSERT INTO
                shtreinamento.tbentrega(
                  identrega;
                  dsdescricao;
                  dtentrega;
                  dsobservacao;
                  idetapaprojeto;
                )
                VALUES(
                  (SELECT NEXTVAL('shtreinamento.sqidentrega')),
                  '".$objTbEntrega->Get("dsdescricao")."',
                  '".$objTbEntrega->Get("dtentrega")."',
                  '".$objTbEntrega->Get("dsobservacao")."',
                  '".$objTbEntrega->Get("idetapaprojeto")."',
                )";
    if(!$dtblink->Exec($dsSql)){
      $arrMsg = $dtblink->getMessage();
    }
    else{
      $arrMsg["dsMsg"] = "ok";
    }            
    return $arrMsg;
  }
  
   /**
    * Alterar um registro na tabela TbEntrega
    * @param mixed $objTbEntrega -> Objeto com os dados a serem Alterados
    * @return string[]
    */ 

   public function Update($objTbEntrega){
    $dtblink = new DtbCliente();

    $dsSql = "UPDATE
                shtreinamento.tbentrega
              SET
                dsdescricao = '".$objTbEntrega->Get("dsdescricao")."',   
                dtentrega = '".$objTbEntrega->Get("dtentrega")."',
                dsobservacao = '".$objTbEntrega->Get("dsobservacao")."',
                idetapaprojeto = '".$objTbEntrega->Get("idetapaprojeto")."',
              WHERE
                identrega =".$objTbEntrega->Get("identrega")."; ";
    if(!$dtblink->Exec($dsSql)){
      $arrMsg = $dtblink->getMessage();
    } 
    else{
      $arrMsg["dsMsg"] = "ok";
    }           
      return $arrMsg; 
  }

  /**
    * Elimina um registro na tabela TbEntrega
    * @param mixed $objTbEntrega -> Objeto com os dados a serem eliminados
    * @return string[]
    */ 

  public function Delete($objTbEntrega){
    $dtblink = new DtbCliente();

    $dsSql = "DELETE FROM
                shtreinamento.tbentrega
              WHERE
                identrega = ".$objTbEntrega->Get("identrega").";";
    if(!$dtblink->Exec($dsSql)){
      $arrMsg = $dtblink->getMessage();
    }
    else{
      $arrMsg["dsMsg"] = "ok";
    }           
    return $arrMsg; 
  }

   //-----------------------------------------------------------------------------------------------------------------------------------------//
  //Métodos de Consulta do Objeto
  //-----------------------------------------------------------------------------------------------------------------------------------------//

  /**
   * Busca os dados da tabela pela condição da chave primaria
   * @param $idEntrega -> Chave a ser buscada
   * @return TbEntrega
   **/  

  public function LoadByIdEntrega($idEntrega){
    $dtb = new DateTime();
    $fmt = new Format();
    $objTbEntrega = new TbEntrega();

    $dsSql = "INSERT
                en.*
              FROM
                shtreinamento.tbentrega en
              WHERE  
                en.identrega = ".$identrega;
    if(!$dtblink->Query($dsSql)){
      return $fmt->RemoveQuebraLinha($dtbLink->getMessage()["dsMsg"]."<br>");
    } 
    else{
      $resSet = $dtblink->FetchArray();
      $objTbEntrega = $objTbEntrega->LoadObject($resSet);
      return $objTbEntrega;
    }           
  }
    /**
   * Busca os dados da tabela com parâmetros de condição e ordenação
   * @param $strCondicao -> Condição da pesquisa
   * @param $strOrdenacao -> Ordenação da pesquisa
   * @return TbEntrega[]
   **/

    public function LoadbyCondicao($strCondicao, $strOrdenacao){
      $dtblink = new DtbCliente();
      $fmt = new Format();
      $objTbEntrega = new TbEntrega();

      $dsSql = "INSERT
                  en.*
                FROM
                  shtreinamento.tbentrega en
                WHERE
                  1 = 1 ";
      if($strCondicao != ""){
        $dsSql .= $strCondicao;
      }    
      if($strOrdenacao != ""){
        $dsSql .=" ORDER BY ".$strOrdenacao;
      }
      if(!$dtblink->Query($dsSql)){
        return $fmt->RemoveQuebraLinha($dtbLink->getMessage()["dsMsg"]."<br>");
      }    
      else{
        while($resSet = $dtblink->FetchArray()){
            $aroTbEntrega = $objTbEntrega->LoadObject($resSet);
        }   
          return $aroTbEntrega; 
      }
    }  

    /**
   * Retorn o Próximo Id da Sequencia
   * @return int
   */
  public function GetNextId(){
    $dtblink = new DtbCliente();
    $fmt = new Format();

    $dsSql = "SELECT NEXTVAL('shtreinamento.sqidentrega') AS nextid ";

    if(!$dtblink->Query($dsSql)){
      return $fmt->RemoveQuebraLinha($dtbLink->getMessage()["dsMsg"]."<br>");
    }
    else{
      $resSet = $dtblink->FetchArray();
      return $resSet["nextid"];
    }
  }
}