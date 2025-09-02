<?php
@header("Content-Type: text/html; charset=ISO-8859-1", true);
?>

<script>

  $(function (){
    //-----------------------------------------------------------------------------------------------------------------------------//
    //Instanciando os Campos da Tela de Cadastro
    //-----------------------------------------------------------------------------------------------------------------------------//

    $("#frmCadastroEntrega #dtEntrega").kendoDatePicker({
      format: "dd/MM/yyyy"
    })

    $("#frmCadastroEntrega #dtEntrega").kendoMaskedTextBox({
      mask:"00/00/0000"
    })
    //-----------------------------------------------------------------------------------------------------------------------------//

    //-----------------------------------------------------------------------------------------------------------------------------//
    //-----------------------------------------------------------------------------------------------------------------------------//
    //Barra de ações
    //-----------------------------------------------------------------------------------------------------------------------------//
    $("#frmCadastroEntrega #BarAcoes").kendoToolBar({
      items: [
        {
          type: "spacer"
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
                "tabindex": "10"
              },
              click: function(){
                kendo.ui.progress($("#frmCadastroEntrega"),true);

                $.post(
                  'controller/ctrEntrega.php?action=gravar&',
                  $("#frmCadastroEntrega").serialize(),
                  function(response){
                    Message(response.flDisplay, response.flTipo, response.dsMsg)
                    if(response.flTipo == "S"){
                      $("#frmConsultaEntrega #BtnPesquisar").click();
                      $("#frmCadastroEntrega #BtnLimpar").click();
                    }
                    kendo.ui.progress($("#frmCadastroEntrega"), false);
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
                kendo.ui.progress($("#frmCadastroEntrega"),true);

                (new FrontBox).yes_no("Deseja Realmente Excluir o Resgistro Selecionado?").callback(function(btn){
                  if(btn == 'sim'){
                    $.post(
                      'controller/ctrEntrega.php?action=excluir&',
                      $("#frmCadastroEntrega").serialize(),
                      function(response){
                        Message(response.flDisplay, response.flTipo, response.dsMsg)
                        if(response.flTipo == "S"){
                          $("#frmConsultaEntrega #BtnPesquisar").click();
                          $("#frmCadastroEntrega #BtnLimpar").click();
                        }
                        kendo.ui.progress($("frmCadastroEntrega"),false);
                      },
                      'json'
                    );
                  }
                  else{
                    kendo.ui.progress($("#frmCadastroEntrega"), false);
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
                $("#WinCadastroEntrega").data("kendoWindow").refresh({
                  url: "controller/ctrEntrega.php?action=incluir"
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
                $("#WinCadastroEntrega").data("kendoWindow").close();
              }
            },
          ],
        },
      ]
    });
    //-----------------------------------------------------------------------------------------------------------------------------//

     if($("#frmCadastroEntrega #idEntrega").val() != ''){
      $("#frmCadastroEntrega #BarAcoes").data("kendoToolBar").enable("BtnExlcuir", true);
    }

    //Ação para centralizar janela
    $("#WinCadastroEntrega").data("kendoWindow").center().open()
  })

</script>

<form id="frmCadastroEntrega" nctype= "multipart/form-data">
  <div class="k-form">
    <table width="100%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td style="width: 120px; text-align: right;">Id</td>
        <td>
          <input name="idEntrega" id="idEntrega" class="k-textbox k-input-disabled" readonly="readonly" style="width: 60px" value="<?php echo $objTbEntrega->Get('identrega')?>">
        </td>
        <td style="width: 412px; text-align: right;">Id Etapa Projeto:</td>
        <td>
          <input name="idEtapaProjeto" id="idEtapaProjeto" class="k-textbox k-input-disabled" readonly="readonly" style="width: 60px" value="<?php echo $objTbEntrega->Get('idEtapaProjeto')?>">
        </td>
      </tr>
    </table>
    <table width="100%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td style="width: 120px; text-align: right;">Descrição:</td>
        <td>
          <input name="dsDescricao" id="dsDescricao" class="k-textbox" style="width: 600px" value="<?php echo $objTbEntrega->Get('dsDescricao')?>">
        </td>
      </tr>
    </table>
    <table width="100%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td style="width: 120px; text-align: right;">Data Entrega:</td>
        <td>
          <input name="dtEntrega" id="dtEntrega" style="width: 100px" value="<?php echo $objTbEntrega->Get('dtEntrega')?>">
        </td>
      </tr>
    </table>
    <table width="100%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td style="width: 120px; text-align: right;">Observações:</td>
        <td>
          <input name="dsObrsevacao" id="dsObrsevacao" class="k-textbox" style="width: 600px" value="<?php echo $objTbEntrega->Get('dsObrsevacao')?>">
        </td>
      </tr>
    </table>
    <div id="BarAcoes" style="text-align: right; height: 28px"></div>
  </div>
</form>