<?php

class DtbCliente {
  private $lnkClient;
  private $qryClient;
  private $qryErrorCodeClient;
  private $strQueryClient;

  public function __construct() {
    $this->lnkClient = pg_connect("host=192.168.2.11 port=5432 dbname=dbsisgov user=ussisgov password=pgdesenv");
  }

  public function Exec($strSql) {
    $this->strQueryClient = $strSql;

    $this->qryClient = @pg_query($this->lnkClient, $this->strQueryClient);
    $qryClientStatus = pg_get_result($this->lnkClient);

    $this->qryErrorCodeClient = pg_result_error_field($qryClientStatus, PGSQL_DIAG_SQLSTATE);

    return $this->qryClient !== false;
  }

  public function Query($strSql) {
    $this->strQueryClient = $strSql;

    $this->qryClient = @pg_query($this->lnkClient, $this->strQueryClient);

    return $this->qryClient !== false;
  }

  public function getMessage() {
    $arrMsg = array();

    switch ($this->qryErrorCodeClient) {
      case '23505':
        $arrMsg['flTipo'] = 'A';
        $arrMsg['dsMsg'] = '&raquo; Já existe um registro cadastrado com os dados informados!<br>';
        break;
      case '23503':
        $arrMsg['flTipo'] = 'A';
        $arrMsg['dsMsg'] = '&raquo; Não é possível excluir o registro selecionado pois o mesmos está sendo utilizando em outros cadastros!<br>Erro:'.pg_last_error().'<br>';
        break;
      case '3F000':
        $arrMsg['flTipo'] = 'E';
        $arrMsg['dsMsg'] = 'Schema não encontrado no banco de dados!<br>'.pg_last_error().'<br>'.$this->strQueryClient.'<br>';
        break;
      case '42P01':
        $arrMsg['flTipo'] = 'E';
        $arrMsg['dsMsg'] = 'Erro de Sistema nº '.$this->qryErrorCodeClient.' tabela não existe no banco de dados. <br>'.pg_last_error().'<br>'.$this->strQueryClient.'<br>';
        break;
      case '42703':
        $arrMsg['flTipo'] = 'E';
        $arrMsg['dsMsg'] = 'Erro de Sistema nº '.$this->qryErrorCodeClient.' coluna não existe no banco de dados. <br>'.pg_last_error().'<br>'.$this->strQueryClient.'<br>';
        break;
      case '42601':
        $arrMsg['flTipo'] = 'E';
        $arrMsg['dsMsg'] = 'Erro de Sql nº '.$this->qryErrorCodeClient.' sintaxe do comando incorreta. <br>'.pg_last_error().'<br>'.$this->strQueryClient.'<br>';
        break;
      default:
        $arrMsg['flTipo'] = 'E';
        $arrMsg['dsMsg'] = 'Erro não catalogado: '.$this->qryErrorCodeClient.' <br>'.pg_last_error().'<br>Sql:'.$this->strQueryClient.'<br>';
        break;
    }

    return $arrMsg;
  }

  public function Begin() {
    $this->qryClient = pg_query($this->lnkClient, "begin;");
  }

  public function Commit() {
    $this->qryClient = pg_query($this->lnkClient, "commit;");
  }

  public function Rollback() {
    $this->qryClient = pg_query($this->lnkClient, "rollback;");
  }

  public function FetchArray() {
    return pg_fetch_array($this->qryClient);
  }
}
