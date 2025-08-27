<?php

class TbResponsavel{

  //-----------------------------------------------------------------------------------------------------------------------------------------//
  // Métodos de Definição da classe [CLASS]
  //-----------------------------------------------------------------------------------------------------------------------------------------//
  
  // Propriedades Persistentes
  private $idresponsavel;
  private $nmresponsavel;
  private $dssetor;
  private $dsfuncao;
  private $dsemail;

  /**
   * Método Construct para limpeza do Objeto
   */
  public function __construct(){
    $this->idresponsavel = "";
    $this->nmresponsavel = "";
    $this->dssetor = "";
    $this->dsfuncao = "";
    $this->dsemail = "";
  }

  /**
   * Método Set para carga do objeto
   **/  
  public function Set($prpTbResponsavel, $vlTbResponsavel){
    $this->$prpTbResponsavel = $vlTbResponsavel;
  }

  /**
   * Método Get para carga do objeto
   **/  
  public function Get($prpTbResponsavel){
    return $this->$prpTbResponsavel;
  }

  /**
   * Carrega o objeto com os dados do resultSet de uma query
   * @param $resSet
   * @return TbResponsavel
   */
  public function LoadObject($resSet){
    $objTbResponsavel = new TbResponsavel();
    $objTbResponsavel->Set("idresponsavel", $resSet["idresponsavel"]);
    $objTbResponsavel->Set("nmresponsavel", $resSet["nmresponsavel"]);
    $objTbResponsavel->Set("dssetor", $resSet["dssetor"]);
    $objTbResponsavel->Set("dsfuncao", $resSet["dsfuncao"]);
    $objTbResponsavel->Set("dsemail", $resSet["dsemail"]);
    return $objTbResponsavel;
  }

  //-----------------------------------------------------------------------------------------------------------------------------------------//
  // Métodos de Manutenção do Objeto
  //-----------------------------------------------------------------------------------------------------------------------------------------//

  /**
   *Insere um registro na tabela TbResponsavel
   * @param mixed $objTbResponsavel->Objeto com os dados a serem inseridos
   * @return string[]
   */
  public function Insert($objTbResponsavel){
    $dtbLink = new DtbCliente();

    $dsSql = "INSERT INTO 
                shtreinamento.tbresponsavel(
                  idresponsavel,
                  nmresponsavel,
                  dssetor,
                  dsfuncao,
                  dsemail
                )
                VALUES(
                  (SELECT NEXTVAL('shtreinamento.sqidresponsavel')),
                  '".$objTbResponsavel->Get("nmresponsavel")."',
                  '".$objTbResponsavel->Get("dssetor")."',
                  '".$objTbResponsavel->Get("dsfuncao")."',
                  '".$objTbResponsavel->Get("dsemail")."'
                )";
    
    if(!$dtbLink->Exec($dsSql)){
      $arrMsg = $dtbLink->getMessage();
    }else{
      $arrMsg["dsMsg"] = "ok";
    }
    return $arrMsg;
  }

  /**
   * Altera um registro na tabela TbResponsavel
   * @param $objTbResponsavel->Objeto com dados a serem alterados
   * @return string[]
   */

  public function Update($objTbResponsavel){
    $dtbLink = new DtbCliente();

    $dsSql - "UPDATE
                shrteinamento.tbresponsavel
              SET
                nmresponsavel = '".$objTbResponsavel->Get("nmresponsavel")."',
                dssetor = '".$objTbResponsavel->Get("dssetor")."',
                dsfuncao = '".$objTbResponsavel->Get("dsfuncao")."',
                dsemail = '".$objTbResponsavel->Get("dsemail")."'
              WHERE
                idresponsavel = ".$objTbResponsavel->Get('idresponsavel').";";
    if(!$dtbLink->Exec($dsSql)){
      $arrMsg = $dtbLink->getMessage();
    } else{
      $arrMsg["dsMsg"] = "ok";
    }   
    return $arrMsg;        
  }

  /**
   * Elimina um registro na tabela TbResponsavel
   * @param $objTbResponsavel->Obejto com os dados a serem eliminados
   * @return string[]
   */
  public function Delete($objTbResponsavel){
    $dtLink = new DtbCliente();

    $dsSql = "DELETE FROM
                shrteinamento.tbresponsavel
              WHERE
                  idresponsavel = ".$objTbResponsavel->Get('idresponsavel').";";

    if(!$dtLink->Exec($dsSql)){
      $arrMsg = $dtLink->getMessage();
    }else {
      $arrMsg['dsMsg'] = 'ok';
    }
    return $arrMsg;
  }

  //-----------------------------------------------------------------------------------------------------------------------------------------//
  //Métodos de Consulta do Objeto
  //-----------------------------------------------------------------------------------------------------------------------------------------//

  /**
   * Busca os dados da tabela pela condição da chave primaria
   * @param $idResponsavel -> Chave a ser buscada
   * @return TbResponsavel
   **/
  public static function LoadByIdResponsavel($idResponsavel){
    $dtblink = new DtbCliente();
    $fmt = new Format();
    $objTbResponsavel = new TbResponsavel();

    $dsSql = "SELECT
                rp.*
              FROM
                shtreinamento.tbresponsavel rp
              WHERE
                rp.idresponsavel = ".$idResponsavel;

    if(!$dtblink->Query($dsSql)){
      return $fmt->RemoveQuebraLinha($dtblink->getMessage()["dsMsg"]."<br>");
    }
    else{
      $resSet = $dtblink->FetchArray();
      $objTbResponsavel = $objTbResponsavel->LoadObject($resSet);
      return $objTbResponsavel;
    } 
  }       
    
  /**
   * Busca os dados da tabela com parâmetros de condição e ordenação
   * @param $strCondicao -> Condição da pesquisa
   * @param $strOrdenacao -> Ordenação da pesquisa
   * @return TbResponsavel[]
   **/

  public static function ListByCondicao($strCondicao, $strOrdenacao){
    $dtblink = new DtbCliente();
    $objTbResponsavel = new TbResponsavel();
    $fmt = new Format();

    $dsSql = "SELECT
                rp.*
              FROM 
                shtreinamento.tbresponsavel rp
              WHERE
                1 = 1 ";

    if($strCondicao != ""){
      $dsSql .= $strCondicao;
    }
    if($strOrdenacao != ""){
      $dsSql .= " ORDER BY ".$strOrdenacao;
    }

    if(!$dtblink->Query($dsSql)){
      return $fmt->RemoveQuebraLinha($dtblink->getMessage()["dsMsg"]."<br>");
    }
    else{
      while($resSet = $dtblink->FetchArray()){
        $aroTbResponsavel[] = $objTbResponsavel->LoadObject($resSet);
      }
      return $aroTbResponsavel;
    }

  }

  /**
   * Retorn o Próximo Id da Sequencia
   * @return int
   */
  public static function GetNextId(){
    $dtblink = new DtbCliente();
    $fmt = new Format();

    $dsSql = "SELECT NEXTVAL('shtreinamento.sqidresponsavel') AS nextid";

    if(!$dtblink->Query($dsSql)){
      return $fmt->RemoveQuebraLinha($dtblink->getMessage()['dsMsg']."<br>");
    }
    else{
      $resSet = $dtblink->FetchArray();
      return $resSet["nextid"];
    }
  }
}