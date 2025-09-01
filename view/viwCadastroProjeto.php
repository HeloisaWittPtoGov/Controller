<?php
@header("Content-Type: text/html; charset=ISO-8859-1", true);
?>

<script>
  $(function() {

    //-----------------------------------------------------------------------------------------------------------------------------//
    //Instanciando os Campos da Tela de Cadastro
    //-----------------------------------------------------------------------------------------------------------------------------//
    $("#frmCadastroProjeto #flStatus").kendoDropDownList();

    $("#frmCadastroProjeto #dtInicio").kendoDatePicker({
      format: "dd/MM/yyyy"
    })

    $("#frmCadastroProjeto #dtInicio").kendoMaskedTextBox({
      mask: "00/00/0000"
    })

    $("#frmCadastroProjeto #dtPrevistaTermino").kendoDatePicker({
      format: "dd/MM/yyyy"
    })

    $("#frmCadastroProjeto #dtPrevistaTermino").kendoMaskedTextBox({
      mask: "00/00/0000"
    })
    //-----------------------------------------------------------------------------------------------------------------------------//

    //-----------------------------------------------------------------------------------------------------------------------------//
    //Barra de ações
    //-----------------------------------------------------------------------------------------------------------------------------//
    $("#frmCadastroProjeto #BarAcoes").kendoToolBar({
      items:[
        {
          type: "spacer"
        },
        {
          type:"buttonGroup",
          buttons:[
            {
              id: "BtnGravar",
              spriteCssClass: "k-pg-icon k-i-l1-c5",
              text: "Gravar",
              group: "actions",
              attributes: {
                "tabindex": "10"
              },
              click: function() {
                kendo.ui.progress($("#frmCadastroProjeto"), true);

                $.post(
                  'controller/ctrProjeto.php?action=gravar&',
                  $('#frmCadastroProjeto').serialize(),
                  function(response){
                    Message(response.flDisplay, response.flTipo, response.dsMsg)
                    if(response.flTipo == "S"){
                      $("#frmConsultaProjeto #BtnPesquisar").click();
                      $("#frmCadastroProjeto #BtnLimpar").click();
                    }
                    kendo.ui.progress($("#frmCadastroProjeto"), false);
                  },
                  'json'
                );
              } 
            },
            {
              id: "BtnExcluir",
              spriteCssClass: "k-pg-icon k-i-l1-c7",
              text: "Excluir",
              group: "actions",
              enable: false,
              attributes: {
                "tabindex": "11"
              },
              click: function() {
                kendo.ui.progress($("#frmCadastroProjeto"), true);

                (new FrontBox).yes_no("Deseja Realmente Excluir o Registro Selecionado?").callback(function(btn){
                  if(btn == 'sim'){
                    $.post(
                      'controller/ctrProjeto.php?action=excluir&',
                      $('#frmCadastroProjeto').serialize(),
                      function(response){
                        Message(response.flDisplay, response.flTipo, response.dsMsg)
                        if(response.flTipo == "S"){
                          $("#frmConsultaProjeto #BtnPesquisar").click();
                          $("#frmCadastroProjeto #BtnLimpar").click();
                        }
                        kendo.ui.progress($("#frmCadastroProjeto"), false);
                      },
                      'json'
                    );
                  }
                  else {
                    kendo.ui.progress($("#frmCadastroProjeto"), false);
                  }
                })
              }
            },
            { 
              id: "BtnLimpar",
              spriteCssClass: "k-pg-icon k-i-l1-c6",
              text: "Limpar",
              group: "actions",
              attributes: {
                "tabindex": "12"
              },
              click: function() {
                $("#WinCadastroProjeto").data("kendoWindow").refresh({
                  url: "controller/ctrProjeto.php?action=incluir"
                });
              }
            },
            {
              id: "BtnFechar",
              spriteCssClass: "k-pg-icon k-i-l1-c4",
              text: "Fechar",
              group: "actions",
              attributes: {
                "tabindex": "13"
              },
              click: function() {
                $("#WinCadastroProjeto").data("kendoWindow").close();
              }
            }, 
          ],
        },
      ]
    });
    //-----------------------------------------------------------------------------------------------------------------------------//
    if($("#frmCadastroProjeto #idProjeto").val() != ''){
      $("#frmCadastroProjeto #BarAcoes").data("kendoToolBar").enable("#BtnExcluir", true);
    }


  //Ação para centralizar janela
    $("#WinCadastroProjeto").data("kendoWindow").center().open()

  })
</script>

<form id="frmCadastroProjeto" enctype="multipart/form-data">
  <div class="k-form">
    <table width="100%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td style="width: 120px; text-align: right;">Id</td>
        <td>
          <input type="text" name="idProjeto" id="idProjeto" class="k-textbox k-input-disabled" readonly="readonly" style="width: 60px" value="<?php echo $objTbProjeto->Get('idprojeto')?>">
        </td>
      </tr>
    </table>
    <table width="100%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td style="width: 120px; text-align: right;" class="k-required">
          Titulo:
        </td>
        <td>
          <input type="text" name="dsTitulo" id="dsTitulo" class="k-textbox" style=" width: 600px;" value="<?php echo $objTbProjeto->Get('dstitulo') ?>">
        </td>
      </tr>
    </table>
    <table width="100%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td style="width: 120px; text-align: right;" class="k-required">
          Descrição:
        </td>
        <td>
          <input type="text" name="dsDescricao" id="dsDescricao" class="k-textbox" style="width: 600px;" value="<?php echo $objTbProjeto->Get('dsdescricao') ?>">
        </td>
      </tr>
    </table>
    <table width="100%" cellpadding="0" cellspancing="2" role="presentation">
			<tr>
				<td style="text-align: right; width: 120px;" class="k-required">
					Status:
				</td>
				<td>
					<select name="flStatus" id="flStatus" style="width: 100px;">
						<option value="AD" <?php echo $objTbProjeto->Get('flstatus') == 'AD' ? 'selected' : '' ?> >Andamento</option>
						<option value="PS" <?php echo $objTbProjeto->Get('flstatus') == 'PS' ? 'selected' : '' ?>>Pausado</option>
						<option value="CD" <?php echo $objTbProjeto->Get('flstatus') == 'CD' ? 'selected' : '' ?>>Concluído</option>
					</select>
				</td>
			</tr>
		</table>
    <table width="100%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td style="width: 120px; text-align: right;" class="k-required">
          Data de Inicio:
        </td>
        <td>
          <input name="dtInicio" id="dtInicio" style="width: 100px;" value="<?php echo $objTbProjeto->Get('dtinicio') ?>" >
        </td>
        <td style="width: 333px; text-align: right;" class="k-required">
          Data Prevista de Término:
        </td>
        <td>
          <input  name="dtPrevistaTermino" id="dtPrevistaTermino" style="width: 100px;" value="<?php echo $objTbProjeto->Get('dtprevistatermino') ?>" >
        </td>
      </tr>
    </table>
    <div id="BarAcoes" style="text-align: right;border-bottom-width: 0px;height: 28px,"></div>
  </div>
</form>