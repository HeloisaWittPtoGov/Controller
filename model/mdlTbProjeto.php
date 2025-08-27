<?php

class TbProjeto{

  //-----------------------------------------------------------------------------------------------------------------------------------------//
  // Métodos de Definição da classe [CLASS]
  //-----------------------------------------------------------------------------------------------------------------------------------------//
  
  // Propriedades Persistentes

  private $idprojeto;
  private $dstitulo;
  private $dsdescricao;
  private $dtinicio;
  private $dtprevistatermino;
  private $flstatus;

  /**
   * Método Construct para limpeza do Objeto
   */
  public function __construct(){
    $this->idprojeto = "";
    $this->dstitulo = "";
    $this->dsdescricao = "";
    $this->dtinicio = "";
    $this->dtprevistatermino = "";
    $this->flstatus = "";
  }
  /**
   * Método Set para carga do objeto
   **/  
  public function Set($prpTbProjeto, $vlTbProjeto){
    $this->$prpTbProjeto = $vlTbProjeto;
  }

  /**
   * Método Get para carga do objeto
   **/  
  public function Get($prpTbProjeto){
    return $this->$prpTbProjeto;
  }

  /**
   * @param $resSet
   * @return TbProjeto
   */
  public function LoadObject($resSet){
    $objTbProjeto = new TbProjeto();
    $objTbProjeto->Set("idprojeto", $resSet["idprojeto"]);
    $objTbProjeto->Set("dstitulo", $resSet["dstitulo"]) ;
    $objTbProjeto->Set("dsdescricao", $resSet["dsdescricao"]);
    $objTbProjeto->Set("dtinicio", $resSet["dtinicio"]);
    $objTbProjeto->Set("dtprevistatermino", $resSet["dtprevistatermino"]);
    $objTbProjeto->Set("flstatus", $resSet["flstatus"]);
    return $objTbProjeto;
  }
  //-----------------------------------------------------------------------------------------------------------------------------------------//
  // Métodos de Manutenção do Objeto
  //-----------------------------------------------------------------------------------------------------------------------------------------//

   /**
    * Insere um registro na tabela TbProjeto
    * @param mixed $objTbProjeto -> Objeto com os dados a serem inseridos
    * @return string[]
    */ 

   public function Insert($objTbProjeto){
    $dtbLink = new DtbCliente();

    $dsSql = "INSERT INTO
                shtreinamento.tbprojeto(
                  idprojeto,
                  dstitulo,
                  dsdescricao,
                  dtinicio,
                  dtprevistatermino,
                  flstatus
                )
                VALUES(
                (SELECT NEXTVAL('shtreinamento.sqidprojeto'))
                '".$objTbProjeto->Get("dstitulo")."',
                '".$objTbProjeto->Get("dsdescricao")."',
                '".$objTbProjeto->Get("dtinicio")."',
                '".$objTbProjeto->Get("dtprevistatermino")."',
                '".$objTbProjeto->Get("flstatus")."'
                )";
    if(!$dtbLink->Exec($dsSql)){
      $arrMsg = $dtbLink->getMessage();
    }else{
      $arrMsg["dsMsg"] = "ok";
    }
    return $arrMsg;
   }

   /**
    * Altera um registro na tabela TbProjeto
    *@param $objTbProjeto -> Objeto com dados a serem alterados
    * @return string[]
    */

    public function Update($objTbProjeto){
      $dtbLink= new DtbCliente();

      $dsSql = "UPDATE 
                  shtreinamento.tbproduto
                SET
                  dstitulo = '".$objTbProjeto->Get("dstitulo")."',
                  dsdescricao = '".$objTbProjeto->Get("dsdescricao")."',
                  dtinicio = '".$objTbProjeto->Get("dtinicio")."',
                  dtprevistatermino = '".$objTbProjeto->Get("dtprevistatermino")."',
                  flstatus = '".$objTbProjeto->Get("flstatus")."' 
                WHERE
                  idprojeto = ".$objTbProjeto->Get("idprojeto").",";
      if(!$dtbLink->Exec($dsSql)){
        $arrMsg = $dtbLink->getMessage();
      }else{
        $arrMsg["dsMsg"] = "ok";
      }       
      return $arrMsg;     
    }

    /**
     * Elimina um registro da tabela Tbprojeto
     * @param $objTbProjeto -> Objeto com dados a serem eliminados
     * @return string[]
     */
    public function Delete($objTbProjeto){
      $dtbLink= new DtbCliente();
      
      $dsSql = "DELETE FROM
                  shtreinamento.tbprojeto
                WHERE
                  idprojeto = ".$objTbProjeto->Get("idprojeto").";";
      if(!$dtbLink->Exec($dsSql)){
        $arrMsg = $dtbLink->getMessage();
      }else{
        $arrMsg["dsMsg"] = "ok";
      }
      return $arrMsg; 
    }
    
  //-----------------------------------------------------------------------------------------------------------------------------------------//
  //Métodos de Consulta do Objeto
  //-----------------------------------------------------------------------------------------------------------------------------------------//

  /**
   * Busca os dados da tabela pela condição da chave primaria
   * @param $idProjeto -> Chave a ser buscada
   * @return TbProjeto
   **/  

  public function LoadByIdProjeto($idProjeto){
    $dtbLink= new DtbCliente();
    $fmt = new Format();
    $objTbProjeto = new TbProjeto;

    $dsSql = "SELECT
                pj.*
              FROM
                shtreinamento.tbprojeto pj
              WHERE
                pj.idprojeto = ".$idProjeto;
    if(!$dtbLink->Query($dsSql)){
     return $fmt->RemoveQuebraLinha($dtbLink->getMessage()["dsMsg"]."<br>");
    }else{
    $resSet = $dtbLink->FetchArray();
    $objTbProjeto = $objTbProjeto->LoadObject($resSet);
    return $objTbProjeto; 
    }
  }

   /**
   * Busca os dados da tabela com parâmetros de condição e ordenação
   * @param $strCondicao -> Condição da pesquisa
   * @param $strOrdenacao -> Ordenação da pesquisa
   * @return TbProjeto[]
   **/
   public static function LoadByCondicao($strCondicao, $strOrdenacao){
    $dtbLink= new DtbCliente();
    $fmt = new Format();
    $objTbProjeto = new TbProjeto;  

    $dsSql = "SELECT 
                pj.*
              FROM    
                shtreinamento.tbprojeto pj
              WHERE
                  1 = 1 ";
    if($strCondicao != ""){
      $dsSql .= $strCondicao;
    }
    if($strOrdenacao != ""){
      $dsSql.=" ORDER BY ".$strOrdenacao;
    }  
    if(!$dtbLink->Query($dsSql)){
      return $fmt->RemoveQuebraLinha($dtbLink->getMessage()["dsMsg"]."<br>");
    }            
    else{
      while($resSet = $dtbLink->FetchArray()){
        $aroTbProjeto = $objTbProjeto->LoadObject($resSet);
      }
      return $aroTbProjeto;
    }
  }

   /**
   * Retorn o Próximo Id da Sequencia
   * @return int
   */
  public static function GetNextId(){
    $dtbLink = new DtbCliente();
    $fmt = new Format();

    $dsSql = "SELECT NEXTVAL('shtreinamento.sqidprojeto') AS nextid";

    if(!$dtbLink->Query($dsSql)){
      return $fmt->RemoveQuebraLinha($dtbLink->getMessage()["dsMsg"]."<br>");
    }
    else{
      $resSet = $dtbLink->FetchArray();
      return $resSet["nextid"];
    }
  }
}