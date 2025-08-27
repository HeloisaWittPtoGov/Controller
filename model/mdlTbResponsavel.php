<?php

class TbResponsavelEtapaProjeto{

  //-----------------------------------------------------------------------------------------------------------------------------------------//
  // Métodos de Definição da classe [CLASS]
  //-----------------------------------------------------------------------------------------------------------------------------------------//
  
  // Propriedades Persistentes
  private $idresponsaveletapaprojeto;
  private $nmresponsavel;
  private $dssetor;
  private $dsfuncao;
  private $dsemail;

  /**
   * Método Construct para limpeza do Objeto
   */
  public function __construct(){
    $this->idresponsaveletapaprojeto = "";
    $this->nmresponsavel = "";
    $this->dssetor = "";
    $this->dsfuncao = "";
    $this->dsemail = "";
  }

  /**
   * Método Set para carga do objeto
   **/  
  public function Set($prpTbResponsavelEtapaProjeto, $vlTbResponsavelEtapaProjeto){
    $this->$prpTbResponsavelEtapaProjeto = $vlTbResponsavelEtapaProjeto;
  }

  /**
   * Método Get para carga do objeto
   **/  
  public function Get($prpTbResponsavelEtapaProjeto){
    return $this->$prpTbResponsavelEtapaProjeto;
  }

  /**
   * Carrega o objeto com os dados do resultSet de uma query
   * @param $resSet
   * @return TbResponsavelEtapaProjeto
   */
  public function LoadObject($resSet){
    $objTbResponsavelEtapaProjeto = new TbResponsavelEtapaProjeto();
    $objTbResponsavelEtapaProjeto->Set("idresponsaveletapaprojeto", $resSet["idresponsaveletapaprojeto"]);
    $objTbResponsavelEtapaProjeto->Set("nmresponsavel", $resSet["nmresponsavel"]);
    $objTbResponsavelEtapaProjeto->Set("dssetor", $resSet["dssetor"]);
    $objTbResponsavelEtapaProjeto->Set("dsfuncao", $resSet["dsfuncao"]);
    $objTbResponsavelEtapaProjeto->Set("dsemail", $resSet["dsemail"]);
    return $objTbResponsavelEtapaProjeto;
  }

  //-----------------------------------------------------------------------------------------------------------------------------------------//
  // Métodos de Manutenção do Objeto
  //-----------------------------------------------------------------------------------------------------------------------------------------//

  /**
   *Insere um registro na tabela TbResponsavelEtapaProjeto
   * @param mixed $objTbResponsavelEtapaProjeto->Objeto com os dados a serem inseridos
   * @return string[]
   */
  public function Insert($objTbResponsavelEtapaProjeto){
    $dtbLink = new DtbCliente();

    $dsSql = "INSERT INTO 
                shtreinamento.tbresponsavel(
                  idresponsaveletapaprojeto,
                  nmresponsavel,
                  dssetor,
                  dsfuncao,
                  dsemail
                )
                VALUES(
                  (SELECT NEXTVAL('shtreinamento.sqidresponsaveletapaprojeto')),
                  '".$objTbResponsavelEtapaProjeto->Get("nmresponsavel")."',
                  '".$objTbResponsavelEtapaProjeto->Get("dssetor")."',
                  '".$objTbResponsavelEtapaProjeto->Get("dsfuncao")."',
                  '".$objTbResponsavelEtapaProjeto->Get("dsemail")."'
                )";
    
    if(!$dtbLink->Exec($dsSql)){
      $arrMsg = $dtbLink->getMessage();
    }else{
      $arrMsg["dsMsg"] = "ok";
    }
    return $arrMsg;
  }

  /**
   * Altera um registro na tabela TbResponsavelEtapaProjeto
   * @param $objTbResponsavelEtapaProjeto->Objeto com dados a serem alterados
   * @return string[]
   */

  public function Update($objTbResponsavelEtapaProjeto){
    $dtbLink = new DtbCliente();

    $dsSql - "UPDATE
                shrteinamento.tbresponsavel
              SET
                nmresponsavel = '".$objTbResponsavelEtapaProjeto->Get("nmresponsavel")."',
                dssetor = '".$objTbResponsavelEtapaProjeto->Get("dssetor")."',
                dsfuncao = '".$objTbResponsavelEtapaProjeto->Get("dsfuncao")."',
                dsemail = '".$objTbResponsavelEtapaProjeto->Get("dsemail")."'
              WHERE
                idresponsaveletapaprojeto = ".$objTbResponsavelEtapaProjeto->Get('idresponsaveletapaprojeto').";";
    if(!$dtbLink->Exec($dsSql)){
      $arrMsg = $dtbLink->getMessage();
    } else{
      $arrMsg["dsMsg"] = "ok";
    }   
    return $arrMsg;        
  }

  /**
   * Elimina um registro na tabela TbResponsavelEtapaProjeto
   * @param $objTbResponsavelEtapaProjeto->Obejto com os dados a serem eliminados
   * @return string[]
   */
  public function Delete($objTbResponsavelEtapaProjeto){
    $dtLink = new DtbCliente();

    $dsSql = "DELETE FROM
                shrteinamento.tbresponsavel
              WHERE
                  idresponsaveletapaprojeto = ".$objTbResponsavelEtapaProjeto->Get('idresponsaveletapaprojeto').";";

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
   * @param $idResponsavelEtapaProjeto -> Chave a ser buscada
   * @return TbResponsavelEtapaProjeto
   **/
  public static function LoadByIdResponsavelEtapaProjeto($idResponsavelEtapaProjeto){
    $dtblink = new DtbCliente();
    $fmt = new Format();
    $objTbResponsavelEtapaProjeto = new TbResponsavelEtapaProjeto();

    $dsSql = "SELECT
                rp.*
              FROM
                shtreinamento.tbresponsavel rp
              WHERE
                rp.idresponsaveletapaprojeto = ".$idResponsavelEtapaProjeto;

    if(!$dtblink->Query($dsSql)){
      return $fmt->RemoveQuebraLinha($dtblink->getMessage()["dsMsg"]."<br>");
    }
    else{
      $resSet = $dtblink->FetchArray();
      $objTbResponsavelEtapaProjeto = $objTbResponsavelEtapaProjeto->LoadObject($resSet);
      return $objTbResponsavelEtapaProjeto;
    } 
  }       
    
  /**
   * Busca os dados da tabela com parâmetros de condição e ordenação
   * @param $strCondicao -> Condição da pesquisa
   * @param $strOrdenacao -> Ordenação da pesquisa
   * @return TbResponsavelEtapaProjeto[]
   **/

  public static function ListByCondicao($strCondicao, $strOrdenacao){
    $dtblink = new DtbCliente();
    $objTbResponsavelEtapaProjeto = new TbResponsavelEtapaProjeto();
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
        $aroTbResponsavelEtapaProjeto[] = $objTbResponsavelEtapaProjeto->LoadObject($resSet);
      }
      return $aroTbResponsavelEtapaProjeto;
    }

  }

  /**
   * Retorn o Próximo Id da Sequencia
   * @return int
   */
  public static function GetNextId(){
    $dtblink = new DtbCliente();
    $fmt = new Format();

    $dsSql = "SELECT NEXTVAL('shtreinamento.sqidresponsaveletapaprojeto') AS nextid";

    if(!$dtblink->Query($dsSql)){
      return $fmt->RemoveQuebraLinha($dtblink->getMessage()['dsMsg']."<br>");
    }
    else{
      $resSet = $dtblink->FetchArray();
      return $resSet["nextid"];
    }
  }
}