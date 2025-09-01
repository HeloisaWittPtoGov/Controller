<?php
@header("Content-Type: text/html; charset=ISO-8859-1", true);
?>

<script>
//-----------------------------------------------------------------------------------------------------------------------------//
    //Instanciando os Campos da Tela de Cadastro
    //-----------------------------------------------------------------------------------------------------------------------------//
//-----------------------------------------------------------------------------------------------------------------------------//

//-----------------------------------------------------------------------------------------------------------------------------//
    //-----------------------------------------------------------------------------------------------------------------------------//
    //Barra de ações
    //-----------------------------------------------------------------------------------------------------------------------------//

    $("#frmCadastroResponsavel #BarAcoes").kendoToolBar({
      items: [
        {
          type: "spacer";
        },
        {
          type: "buttonGroup",
          buttons:[
            {
              id: "BtnGravar",
              spriteCssClass: "k-pg-icon k-i-l1-c5",
              text: "Gravar",
              group: "actions",
              attributes{
                "tabindex": "10"
              },
              click: function(){
                kendo.ui.progress($("#frmCadastroResponsavel"),true);

                $.post(
                  'controller/ctrResponsavel.php?action=gravar&',
                  $("#frmCadastroResposnavelo").serialize(),
                  function(response){
                    Message(respose.flDisplay, response.flTipo, response.dsMsg)
                    if(response.flTipo == "S"){
                      $("#frmConsultaResponsavel #BtnPesquisar").click();
                      $("#frmCadastroResponsavel #BtnLimpar").click();
                    }
                    kendo.ui.progress($("#frmCadastroResponsavel"), false);
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
              attributes{
                "tabindex": "11",
              },
              click: function(){
                kendo.ui.progress($("#frmCadastroResponsavel"),true);

                (new FrontBox).yes_no("Deseja Realmente Excluir o Resgistro Selecionado?").callback(function(btn){
                  if(btn == 'sim'){
                    $.post(
                      'controller/ctrEtapaProjeto.php?action=excluir&',
                      $("#frmCadastroResponsavel").serialize(),
                      function(response){
                        Message(response.flDisplay, response.flTipo, response.dsMsg)
                        if(response.flTipo == "S"){
                          $("#frmConsultaResponsavel #BtnPesquisar").click();
                          $("#frmCadastroResponsavel #BtnLimpar").click();
                        }
                        kendo.ui.progress($("frmCadastroResponsavel"),false);
                      },
                      'json'
                    );
                  }
                  else{
                    kendo.ui.progress($("#frmCadastroResponsavel"), false);
                  }
                })
              }
            },
            {
              id: "BtnLimpar",
              spriteCssClass: "k-pg-icon k-i-l1-c6",
              text "Limpar",
              group: "actions",
              attributes:{
                "tabindex": "12",
              },
              click: function(){
                $("#WinCadastroResponsavel").data("kendoWindow").refresh({
                  url: "controller/ctrResponsavel.php?action=incluir"
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
                $("#WinCadastroResponsavel").data("kendoWindow").close();
              }
            },
          ],
        },
      ]
    }),
//-----------------------------------------------------------------------------------------------------------------------------//

  if($("#frmCadastroResponsavel #idResponsavelEtapaProjeto").val() != ''){
    $("#frmCadastroResponsavel #BarAcoes").data("kendoToolBar").enable("BtnExlcuir", true);
  }

  //Ação para centralizar janela
  $("#WinCadastroResponsavel").data("kendoWindow").center().open()


</script>

<form id="frmCadastroResponsavel" nctype="multipart/form-data">
  <div class="k-form">
    <table width="100%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td style="width: 120px; text-align: right;">
            ID:
        </td>
         <td>
          <input name="idResponsavelEtapaProjeto" id="idResponsavelEtapaProjeto" class="k-textbox k-input-disabled" readonly="readonly" style="width: 60px" value="<?php echo $objTbResponsavelEtapaProjeto->Get('idresponsaveletapaprojeto')?>">
        </td>
      </tr>
    </table width="100%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td style="width: 120px; text-align: right;">
            Nome:
        </td>
         <td>
          <input type="text" name="nmResponsavel" id="nmResponsavel" class="k-textbox" style="width: 600px;" value="'<?php  echo $objTbResponsavelEtapaProjeto->Get('nmresponsavel')?>">
        </td>
      </tr>
    <table width="100%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td style="width: 120px; text-align: right;">
          Setor:
        </td>
        <td>
          <input type="text" name="dsSetor" id="dsSetor" class="k-textbox" style="width: 600px;" value="'<?php  echo $objTbResponsavelEtapaProjeto->Get('dsSetor')?>">
        </td>
      </tr>
    </table>
    <table width="100%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td style="width: 120px; text-align: right;">
          Função:
        </td>
        <td>
          <input type="text" name="dsFuncao" id="dsFuncao" class="k-textbox" style="width: 600px;" value="'<?php  echo $objTbResponsavelEtapaProjeto->Get('dsFuncao')?>">
        </td>
      </tr>
    </table>
    <table>
      <tr>
        <td style="width: 120px; text-align: right;">
          E-mail:
        </td>
        <td>
           <input type="text" name="dsEmail" id="dsEmail" class="k-textbox" style="width: 600px;" value="'<?php  echo $objTbResponsavelEtapaProjeto->Get('dsEmail')?>">
        </td>
      </tr>
    </table>
    <div id="BarAcoes" style="text-align: right;border-bottom-width: 0px;height: 28px,"></div>
  </div>
</form>