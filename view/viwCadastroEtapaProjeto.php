<?php
@header("Content-Type: text/html; charset=ISO-8859-1", true);
?>

<script>
  $(function(){

    //-----------------------------------------------------------------------------------------------------------------------------//
    //Instanciando os Campos da Tela de Cadastro
    //-----------------------------------------------------------------------------------------------------------------------------//

    $("#frmCadastroEtapaProjeto #dtPrevistaInicio").kendoDatePicker({
      format: "dd/MM/yyyy"
    })

    $("#frmCadastroEtapaProjeto #dtPrevistaInicio").kendoMaskedTextBox({
      mask: "00/00/0000"
    })

    $("#frmCadastroEtapaProjeto #dtPrevistaTermino").kendoDatePicker({
      format: "dd/MM/yyyy"
    })

    $("#frmCadastroEtapaProjeto #dtPrevistaTermino").kendoMaskedTextBox({
      mask: "00/00/0000"
    })

    $("#frmCadastroEtapaProjeto #flStatus").kendoDropDownList();

    //-----------------------------------------------------------------------------------------------------------------------------//
    //-----------------------------------------------------------------------------------------------------------------------------//
    //Instanciando Botão de abertura da tela de consulta de projetos
    //-----------------------------------------------------------------------------------------------------------------------------//
    $("#frmCadastroEtapaProjeto #BtnProjeto").kendoButton({
      spriteCssClass: "k-pg-icon k-i-l1-c2",
      click: function(e){
        OpenWindow(false, "ConsultaProjeto", "controller/ctrProjeto.php?action=winConsulta&frmResult=frmCadastroEtapaProjeto", "Consulta de Projetos")
      }
    });

    //-----------------------------------------------------------------------------------------------------------------------------//
    //Instanciando Botão de abertura da tela de consulta de Responsaveis
    //-----------------------------------------------------------------------------------------------------------------------------//
    $("#frmCadastroEtapaProjeto #BtnResponsavel").kendoButton({
      spriteCssClass: "k-pg-icon k-i-l1-c2",
      click: function(e){
        OpenWindow(false, "ConsultaResponsavel", "controller/ctrResponsavel.php?action=winConsulta&frmResult=frmCadastroEtapaProjeto", "Consulta de Responsaveis")
      }
    });

    //-----------------------------------------------------------------------------------------------------------------------------//


    //-----------------------------------------------------------------------------------------------------------------------------//
    //-----------------------------------------------------------------------------------------------------------------------------//
    //Barra de ações
    //-----------------------------------------------------------------------------------------------------------------------------//
  
    $("#frmCadastroEtapaProjeto #BarAcoes").kendoToolBar({
      items: [
        {
          type: "spacer",
        },
        {
          type: "buttonGroup",
          buttons:[
            {
              id: "BtnGravar",
              spriteCssClass: "k-pg-icon k-i-l1-c5",
              text: "Gravar",
              group: "actions",
              attributes:{
                "tabindex": "10",
              },
              click: function(){
                kendo.ui.progress($("#frmCadastroEtapaProjeto"),true);

                $.post(
                  'controller/ctrEtapaProjeto.php?action=gravar&',
                  $("#frmCadastroEtapaProjeto").serialize(),
                  function(response){
                    Message(response.flDisplay, response.flTipo, response.dsMsg)
                    if(response.flTipo == "S"){
                      $("#frmConsultaEtapaProjeto #BtnPesquisar").click();
                      $("#frmCadastroEtapaProjeto #BtnLimpar").click();
                    }
                    kendo.ui.progress($("#frmCadastroEtapaProjeto"), false);
                  },
                  'json'
                );
              }
            },
            {
              id:"BtnExcluir",
              spriteCssClass: "k-pg-icon k-i-l1-c7",
              text: "Excluir",
              group: "actions",
              enable: false,
              attributes:{
                "tabindex": "11",
              },
              click: function(){
                kendo.ui.progress($("#frmCadastroEtapaProjeto"),true);

                (new FrontBox).yes_no("Deseja Realmente Excluir o Resgistro Selecionado?").callback(function(btn){
                  if(btn == 'sim'){
                    $.post(
                      'controller/ctrEtapaProjeto.php?action=excluir&',
                      $("#frmCadastroEtapaProjeto").serialize(),
                      function(response){
                        Message(response.flDisplay, response.flTipo, response.dsMsg)
                        if(response.flTipo == "S"){
                          $("#frmConsultaEtapaProjeto #BtnPesquisar").click();
                          $("#frmCadastroEtapaProjeto #BtnLimpar").click();
                        }
                        kendo.ui.progress($("frmCadastroEtapaProjeto"),false);
                      },
                      'json'
                    );
                  }
                  else{
                    kendo.ui.progress($("#frmCadastroEtapaProjeto"), false);
                  }
                })
              }
            },
            {
              id: "BtnLimpar",
              spriteCssClass: "k-pg-icon k-i-l1-c6",
              text: "Limpar",
              group: "actions",
              attributes:{
                "tabindex": "12",
              },
              click: function(){
                $("#WinCadastroEtapaProjeto").data("kendoWindow").refresh({
                  url: "controller/ctrEtapaProjeto.php?action=incluir"
                });
              }
            },
            {
              id:"BtnFechar",
              spriteCssClass:"k-pg-icon k-i-l1-c4",
              text: "Fechar",
              group: "actions",
              attributes:{
                "tabindex":"13"
              },
              click: function(){
                $("#WinCadastroEtapaProjeto").data("kendoWindow").close();
              }
            }
          ],
        },
      ]
    });
    //-----------------------------------------------------------------------------------------------------------------------------//
    if($("#frmCadastroEtapaProjeto #idEtapaProjeto").val() != ''){
      $("#frmCadastroEtapaProjeto #BarAcoes").data("kendoToolBar").enable("BtnExcluir", true);
    }

    
    //Ação para centralizar janela
    $("#WinCadastroEtapaProjeto").data("kendoWindow").center().open()

  })

</script>

<form id="frmCadastroEtapaProjeto" nctype="multipart/form-data">
  <div class="k-form">
    <table width="100%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td style="width: 120px; text-align: right;">Id</td>
        <td>
          <input name="idEtapaProjeto" id="idEtapaProjeto" class="k-textbox k-input-disabled" readonly="readonly" style="width: 60px" value="<?php echo $objTbEtapaProjeto->Get('idetapaprojeto')?>">
        </td>
      </tr>
    </table>
    <table width="100%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td style="width: 120px; text-align:right;">Projeto:</td>
        <td>
          <input type="text" tabindex="-1" id="idProjeto" name="idProjeto", value="<?php echo $objTbEtapaProjeto->GetObjTbProjeto()->Get('idprojeto')?>" class="k-input-disabled k-textbox" readonly="readonly" style="width: 60px; background-color: #e8e8e8"/>
          <span tabindex="-1" id="BtnProjeto" style="cursor: pointer; width: 24px; height: 24px;" title="Consultar Projetos..."></span>
          <input type="text" tabindex="-1" id="dsTitulo" name="dsTitulo" value="<?php echo $objTbEtapaProjeto->GetObjTbProjeto()->Get('dstitulo') ?>" class="k-input-disabled k-textbox" readonly="readonly" style="width: 510px; background-color: #e8e8e8"/> 
        </td>
      </tr>
    </table>
    <table width="100%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td style="width: 120px; text-align:right;">Responsavel:</td>
        <td>
          <input type="text" tabindex="-1" id="idResponsavelEtapa" name="idResponsavelEtapa", value="<?php echo $objTbEtapaProjeto->GetObjTbResponsavel()->Get('idresponsaveletapaprojeto')?>" class="k-input-disabled k-textbox" readonly="readonly" style="width: 60px; background-color: #e8e8e8"/>
          <span tabindex="-1" id="BtnResponsavel" style="cursor: pointer; width: 24px; height: 24px;" title="Consultar Responsaveis..."></span>
          <input type="text" tabindex="-1" id="nmResponsavel" name="nmResponsavel" value="<?php echo $objTbEtapaProjeto->GetObjTbResponsavel()->Get('nmresponsavel')?>" class="k-input-disabled k-textbox" readonly="readonly" style="width: 510px; background-color: #e8e8e8"/> 
        </td>
      </tr>
    </table>
    <table idth="100%" border="0" cellspacing="2" cellpadding="0" >
      <tr>
        <td style="width: 120px; text-align: right;">Etapa</td>
        <td>
          <input type="text" name="nmEtapa" id="nmEtapa" class="k-textbox" style="width: 600px;" value="<?php  echo $objTbEtapaProjeto->Get('nmetapa')?>">
        </td>
      </tr>
    </table>
    <table idth="100%" border="0" cellspacing="2" cellpadding="0" >
      <tr>
        <td style="width: 120px; text-align: right;">Data Prevista Inicio</td>
        <td>
          <input name="dtPrevistaInicio" id="dtPrevistaInicio" style="width: 100px;" value="<?php  echo $objTbEtapaProjeto->Get('dtprevistainicio')?>">
        </td>
        <td style="width: 396px; text-align: right;">Data Prevista Termino</td>
        <td>
          <input name="dtPrevistaTermino" id="dtPrevistaTermino" style="width: 100px;" value="<?php  echo $objTbEtapaProjeto->Get('dtprevistatermino')?>">
        </td>
      </tr>
    </table>
    <table>
      <tr>
        <td style="width: 118px; text-align: right;">Status</td>
        <td>
          <select name="flStatus" id="flStatus" style="width: 200px;">
						<option value="NI" <?php echo $objTbEtapaProjeto->Get('flstatus') == 'NI' ? 'selected' : '' ?> >Nao Iniciado</option>
						<option value="EA" <?php echo $objTbEtapaProjeto->Get('flstatus') == 'EA' ? 'selected' : '' ?> >Em Andamento</option>
						<option value="CD" <?php echo $objTbEtapaProjeto->Get('flstatus') == 'CD' ? 'selected' : '' ?>>Concluído</option>
					</select>
        </td>
      </tr>
    </table>
    <div id="BarAcoes" style="text-align: right;border-bottom-width: 0px;height: 28px;"></div>
  </div>
</form>