<?php
@header("Content-Type: text/html; charset=ISO-8859-1", true);
?>

<script>
  $(function (){

    var arrDataSource = [
      {
        name: "idresponsaveletapaprojeto",
        type: "integer",
        label: "ID",
        visibleFilter: "true",
        orderFilter: "2",

        orderGrid: "1",
        widthGrid: "70",
        hiddenGrid: "false",
        headerAttributesGrid: "text-align: center",
        attibutesGrid: "text-align: center",

        showPreview: "true",
        widthPreview: "70",
        positionPreview: "1",
        indiceTabPreview: "tabDadosGerais",
      },
      {
        name: "nmresponsavel",
        type: "string",
        label: "Nome",
        visibleFilter: "true",
        orderFilter: "1",

        orderGrid: "2",
        widthGrid: "",
        hiddenGrid: "false",
        headerAttributesGrid: "text-align: center",
        attibutesGrid: "text-align: center",

        showPreview: "true",
        widthPreview: "600",
        positionPreview: "2",
        indiceTabPreview: "tabDadosGerais",
      },
      {
        name: "dssetor",
        type: "string",
        label: "Setor",
        visibleFilter: "true",
        orderFilter: "3",

        orderGrid: "3",
        widthGrid: "",
        hiddenGrid: "false",
        headerAttributesGrid: "text-align: center",
        attibutesGrid: "text-align: center",

        showPreview: "true",
        widthPreview: "600",
        positionPreview: "3",
        indiceTabPreview: "tabDadosGerais",
      },
      {
        name: "dsfuncao",
        type: "string",
        label: "Função",
        visibleFilter: "true",
        orderFilter: "4",

        orderGrid: "4",
        widthGrid: "",
        hiddenGrid: "false",
        headerAttributesGrid: "text-align: center",
        attibutesGrid: "text-align: center",

        showPreview: "true",
        widthPreview: "600",
        positionPreview: "4",
        indiceTabPreview: "tabDadosGerais",
      },
      {
        name: "dsemail",
        type: "string",
        label: "E-mail",
        visibleFilter: "true",
        orderFilter: "5",

        orderGrid: "5",
        widthGrid: "",
        hiddenGrid: "false",
        headerAttributesGrid: "text-align: center",
        attibutesGrid: "text-align: center",

        showPreview: "true",
        widthPreview: "600",
        positionPreview: "5",
        indiceTabPreview: "tabDadosGerais",
      }
    ]

    //------------------------------------------------------------------------------------------------------//
    // Configura tela para usar splitter
    //------------------------------------------------------------------------------------------------------//
    arrDataSource = LoadConfigurationQuery(arrDataSource, "ConsultaResponsavel")
    //------------------------------------------------------------------------------------------------------//

    //------------------------------------------------------------------------------------------------------//
    // Instanciando os campos combo da consulta
    //------------------------------------------------------------------------------------------------------//
    createPgFilter(arrDataSource, "ConsultaResponsavel")
    //------------------------------------------------------------------------------------------------------//
    
    //------------------------------------------------------------------------------------------------------//
    // Area de botões de ação
    //------------------------------------------------------------------------------------------------------//
    $("#frmConsultaResponsavel #BarAcoes").kendoToolBar({
      items:[
        {
          type: "spacer"
        },
         {
          type: "buttonGroup",
          buttons: [
             {
              id: "BtnSelecionar",
              spriteCssClass: "k-pg-icon k-i-l1-c1",
              text: "Selecionar",
              group: "actions",
              enable: false,
              attributes: {
                "tabindex": "30"
              },
              click: function () {
                var GrdConsultaResponsavel = $("#frmConsultaResponsavel #GrdConsultaResponsavel").data("kendoGrid");
                var RstResponsavel = GrdConsultaResponsavel.dataItem(GrdConsultaResponsavel.select());

                $("<?=$frmResult?> #idResponsavelEtapaProjeto").val(RstResponsavel.idresponsaveletapaprojeto).change();
                $("<?=$frmResult?> #nmResponsavel").val(RstResponsavel.nmresponsavel).change();

                $("#WinConsultaResponsavel").data("kendoWindow").close();
                
              }
            },
          ]
        },
        {
          type:"buttonGroup",
          buttons: [
            {
              id:"BtnIncluir",
              spriteCssClass:"k-pg-icon k-i-l1-c1",
              text: "Incluir",
              group: "actions",
              attributes: {
                "tabindex": "31"
              },
              click: function(){
                OpenWindow(true, "CadastroResponsavel", "controller/ctrResponsavel.php?action=incluir");
              }
            },
            {
              id: "BtnEditar",
              spriteCssClass: "k-pg-icon k-i-l1-c1",
              text: "Editar",
              group: "actions",
              enable: false,
              attributes: {
                "tabindex": "32"
              },
              click: function(){
                var GrdConsultaResponsavel = $("#frmConsultaResponsavel #GrdConsultaResponsavel").data("kendoGrid");
                var RstResponsavel = GrdConsultaResponsavel.dataItem(GrdConsultaResponsavel.select());
                OpenWindow(true, "CadastroResponsavel", "controller/ctrResponsavel.php?action=editar&idResponsavelEtapaProjeto="+RstResponsavel.idresponsaveletapaprojeto)
              }
            },
            {
              id: "BtnFechar",
              spriteCssClass: "k-pg-icon k-i-l1-c4",
              text: "Fechar",
              group: "actions",
              attributes: {
                "tabindex": "33"
              },
              click: function() {
                $("#WinConsultaResponsavel").data("kendoWindow").close()
              }
            },
          ],
        },
      ]
    })
    //------------------------------------------------------------------------------------------------------//

    //-----------------------------------------------------------------------------------------------------//
    // Filtro extra da consulta
    //-----------------------------------------------------------------------------------------------------//
    function getExtraFilter(){
      //quando usa splitter
      var arrFields = LoadFilterSplitter('ConsultaResponsavel', arrDataSource)

      return arrFields;
    }
    //-----------------------------------------------------------------------------------------------------//
      
    //------------------------------------------------------------------------------------------------------//
    // Instanciando dataSource da consulta
    //------------------------------------------------------------------------------------------------------//  
    var DtsConsultaResponsavel = new kendo.data.DataSource({
      pageSize: 100,
      serverPaging: true,
      serverFiltering: true,
      serverSorting: true,
      transport: {
        read:{
          url: "controller/ctrResponsavel.php",
          type: "GET",
          dataType: "JSON",
          data: function(){
            return{
              action: 'ListResponsavel',
              filters: getExtraFilter(),
            }
          }
        }
      },
      schema: {
      data: "jsnConsultaResponsavel",
      model: {
        fields: getModelDataSource(arrDataSource)
      },
      errors: "error"
    },
    error: function(e){
      DlgError(e.errors);
    }
    })
    //------------------------------------------------------------------------------------------------------//

    //------------------------------------------------------------------------------------------------------//
    // Instanciando o Botão de Consulta
    //------------------------------------------------------------------------------------------------------//
      $("#frmConsultaResponsavel #BtnPesquisar").kendoButton({
        spriteCssClass: "k-pg-icon k-i-l1-c2",
        click: function(e){
          mountFilteredScreen('filterDefault', e, 'ConsultaResponsavel', arrDataSource, DtsConsultaResponsavel, getExtraFilter());

          $("#frmConsultaResponsavel #BarAcoes").data("kendoToolBar").enable("#BtnEditar", false);
          $("#frmConsultaResponsavel #BarAcoes").data("kendoToolBar").enable("#BtnSelecionar", false)
        }
      })
    //------------------------------------------------------------------------------------------------------//

    //------------------------------------------------------------------------------------------------------//
    // Instanciando grid da consulta
    //------------------------------------------------------------------------------------------------------//
    $("#frmConsultaResponsavel #GrdConsultaResponsavel").kendoGrid({
      pdf: SetPdfOptions("Listagem de ResponsAveis"),
      pdfExport: function(e) {
        tituloPdfExport = 'Listagem de ResponsAveis';
      },
      dataSource: DtsConsultaResponsavel,
      height: getHeightGridQuery("ConsultaResponsavel"),
      selectable: "row",
      resizable: true,
      reorderable: true,
      navigatable: true,
      columnMenu: true,
      filterable: true,
      sortable:{
        mode: "multiple",
        allowUnsort: true,
      },
      sort: function(){
        $("#frmConsultaResponsavel #BarAcoes").data("kendoToolBar").enable("#BtnEditar", false)
        $("#frmConsultaResponsavel #BarAcoes").data("kendoToolBar").enable("#BtnSelecionar", false)
      },
      pageable: {
        pageSizes: [100, 300, 500, "all"],
        numeric: false,
        input: true
      },
      columns: getColumnsQuery(arrDataSource),
      columnShow: function (e) {
        setWidthOnShowColumnGrid(e, 'ConsultaResponsavel');
      },
      columnHide: function (e) {
        setWidthOnHideColumnGrid(e, 'ConsultaResponsavel');
      },
      dataBound: function (e) {
        LoadGridExportActions('frmConsultaResponsavel', 'GrdConsultaResponsavel', <?= ($frmResult === '') ?>);
      },
      filter: function (e) {
        mountFilteredScreen('filterColumn', e, 'ConsultaResponsavel', arrDataSource, DtsConsultaResponsavel, getExtraFilter())
      },
      change: function () {
        $("#frmConsultaResponsavel #BarAcoes").data("kendoToolBar").enable("#BtnEditar")
        if($("#frmConsultaResponsavel #frmResult").val() != ""){
          $("#frmConsultaResponsavel #BarAcoes").data("kendoToolBar").enable("#BtnSelecionar")
        }
      }
    })

    $("#frmConsultaResponsavel #GrdConsultaResponsavel").on("dblclick", " tbody> tr", function () {
    })
    //------------------------------------------------------------------------------------------------------//

    //------------------------------------------------------------------------------------------------------//
    // CriaTela de visualização de item do grid na consulta e faz outros ajustes
    //------------------------------------------------------------------------------------------------------//
    createScreenPreview(arrDataSource, "ConsultaResponsavel")
    //------------------------------------------------------------------------------------------------------//

  })

</script>

<div class="k-form">
  <form id="frmConsultaResponsavel">
    <input type="hidden" id="frmResult" name="frmResult" value="<?= $frmResult; ?>">
    
    <div id="splConsulta">
      <div id="splHeader">
        <div class="k-bg-blue screen-filter-content">
          <table>
            <tr>
              <td style="width: 120px;text-align: right;vertical-align: top;padding-top: 6px;">
                Filtro(s):
              </td>
              <td>
                <div id="fltConsultaResponsavel" style="width: auto; "></div>
              </td>

              <td style="vertical-align: bottom;padding-bottom: 5px;">
                <span id="BtnPesquisar" style="cursor: pointer;width: 100px;height: 24px;" title="Pesquisar" data-role="button" class="k-button k-button-icon" role="button" aria-disabled="false" tabindex="29">
                  <span class="k-sprite k-pg-icon k-i-l1-c2" style="margin: 0 auto; text-align: center;"></span>
                  <span style="margin: 0 auto; margin-right: 3px;">Pesquisar</span>
                </span>
                <span id="BtnAddFilter" style="cursor: pointer;width: 21px !important;height: 21px !important" title="Adicionar Filtro" data-role="button" class="k-button k-button-icon" role="button" aria-disabled="false" tabindex="">
                  <span class="k-sprite k-pg-icon k-i-l1-c1" style="margin: 0 auto;margin-top: 1.4px;"></span>
                </span>
              </td>
            </tr>
          </table>

          <div id="BarAcoes" style="text-align: right; height: 28px"></div>
        </div>
      </div>

      <div id="splMiddle">
       <div id="GrdConsultaResponsavel" data-use-state-screen ="true" data-get-state-screen = "false" ></div>
      </div>

      <div id="splFooter">
        <div id="bottonConsultaResponsavel">
          <div id="tabStripConsultaResponsavel">
            <ul>
              <li id="tabDadosGerais" class="k-state-active">Detalhes</li>
            </ul>
            <div id="tabDadosGeraisVisualizacaoConsultaResponsavel"></div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>