<?php
@header("Content-Type: text/html; charset=ISO-8859-1", true);
?>

<script>
  $(function (){

    var arrDataSource = [
      {
        name: "identrega",
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
        name: "dsdescricao",
        type: "string",
        label: "Descricao",
        visibleFilter: "true",
        orderFilter: "1",

        orderGrid: "2",
        widthGrid: "",
        hiddenGrid: "false",
        headerAttributesGrid: "text-align: center",
        attibutesGrid: "text-align: center",

        showPreview: "true",
        widthPreview: "",
        positionPreview: "2",
        indiceTabPreview: "tabDadosGerais",
      },
      {
        name: "dtentrega",
        type: "string",
        label: "Entrega",
        visibleFilter: "true",
        orderFilter: "3",

        orderGrid: "3",
        widthGrid: "110",
        hiddenGrid: "false",
        headerAttributesGrid: "text-align: center",
        attibutesGrid: "text-align: center",

        showPreview: "true",
        widthPreview: "",
        positionPreview: "3",
        indiceTabPreview: "tabDadosGerais",
      },
      {
        name: "dsobservacao",
        type: "string",
        label: "Observação",
        visibleFilter: "true",
        orderFilter: "4",

        orderGrid: "4",
        widthGrid: "",
        hiddenGrid: "false",
        headerAttributesGrid: "text-align: center",
        attibutesGrid: "text-align: center",

        showPreview: "true",
        widthPreview: "",
        positionPreview: "4",
        indiceTabPreview: "tabDadosGerais",
      },
      {
        name: "idetapaprojeto",
        type: "integer",
        label: "ID Etapa",
        visibleFilter: "true",
        orderFilter: "5",

        orderGrid: "5",
        widthGrid: "110",
        hiddenGrid: "false",
        headerAttributesGrid: "text-align: center",
        attibutesGrid: "text-align: center",

        showPreview: "true",
        widthPreview: "",
        positionPreview: "5",
        indiceTabPreview: "tabDadosGerais",
      },
      {
        name: "nmetapa",
        type: "string",
        label: "Etapa",
        visibleFilter: "true",
        orderFilter: "6",

        orderGrid: "6",
        widthGrid: "",
        hiddenGrid: "false",
        headerAttributesGrid: "text-align: center",
        attibutesGrid: "text-align: center",

        showPreview: "true",
        widthPreview: "",
        positionPreview: "6",
        indiceTabPreview: "tabDadosGerais",
      }
    ]
     
    //------------------------------------------------------------------------------------------------------//
    // Configura tela para usar splitter
    //------------------------------------------------------------------------------------------------------//
    arrDataSource = LoadConfigurationQuery(arrDataSource, "ConsultaEntrega")
    //------------------------------------------------------------------------------------------------------//

    //------------------------------------------------------------------------------------------------------//
    // Instanciando os campos combo da consulta
    //------------------------------------------------------------------------------------------------------//
    createPgFilter(arrDataSource, "ConsultaEntrega")
    //------------------------------------------------------------------------------------------------------//
    
    //------------------------------------------------------------------------------------------------------//
    // Area de botões de ação
    //------------------------------------------------------------------------------------------------------//
       $("#frmConsultaEntrega #BarAcoes").kendoToolBar({
      items:[
        {
          type: "spacer"
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
                "tabindex": "30"
              },
              click: function(){
                OpenWindow(true, "CadastroEntrega", "controller/ctrEntrega.php?action=incluir");
              }
            },
            {
              id: "BtnEditar",
              spriteCssClass: "k-pg-icon k-i-l1-c1",
              text: "Editar",
              group: "actions",
              enable: false,
              attributes: {
                "tabindex": "31"
              },
              click: function(){
                var GrdConsultaEntrega = $("#frmConsultaEntrega #GrdConsultaEntrega").data("kendoGrid");
                var RstEntrega = GrdConsultaEntrega.dataItem(GrdConsultaEntrega.select());
                OpenWindow(true, "CadastroEntrega", "controller/ctrEntrega.php?action=editar&idEntrega="+RstEntrega.identrega)
              }
            },
            {
              id: "BtnFechar",
              spriteCssClass: "k-pg-icon k-i-l1-c4",
              text: "Fechar",
              group: "actions",
              attributes: {
                "tabindex":"32"
              },
              click: function(){
                $("#WinConsultaEntrega").data("kendoWindow").close();
              }
            },
          ]
        }
      ]
    })
    //------------------------------------------------------------------------------------------------------//

     //-----------------------------------------------------------------------------------------------------//
      // Filtro extra da consulta
      //-----------------------------------------------------------------------------------------------------//
      function getExtraFilter(){
        //quando usa splitter
        var arrFields = LoadFilterSplitter('ConsultaEntrega', arrDataSource)

        return arrFields;
      }
      //-----------------------------------------------------------------------------------------------------//

     //------------------------------------------------------------------------------------------------------//
      // Instanciando dataSource da consulta
      //------------------------------------------------------------------------------------------------------//  
      var DtsConsultaEntrega = new kendo.data.DataSource({
        pageSize: 100,
        serverPaging: true,
        serverFiltering: true,
        serverSorting: true,
        transport: {
          read:{
            url: "controller/ctrEntrega.php",
            type: "GET",
            dataType: "JSON",
            data: function(){
              return{
                action: 'ListEntrega',
                filters: getExtraFilter(),
              }
            }
          }
        },
        schema:{
          data: "jsnEntrega",
          model:{
            fields: getModelDataSource(arrDataSource)
          },
          errors:"error"
        },
        error: function(e){
          DlgError(e.error);
        }
      })
      //------------------------------------------------------------------------------------------------------// 
      
      //------------------------------------------------------------------------------------------------------//
      // Instanciando o Botão de Consulta
      //------------------------------------------------------------------------------------------------------//
        $("#frmConsultaEntrega #BtnPesquisar").kendoButton({
          spriteCssClass: "k-pg-icon k-i-l1-c2",
          click: function(e){
            mountFilteredScreen('filterDefault', e, 'ConsultaEntrega', arrDataSource, DtsConsultaEntrega, getExtraFilter());

            $("#frmConsultaEntrega #BarAcoes").data("kendoToolBar").enable("#BtnEditar", false);
          }
        })
      //------------------------------------------------------------------------------------------------------//

     //------------------------------------------------------------------------------------------------------//
      // Instanciando grid da consulta
      //------------------------------------------------------------------------------------------------------//
        $("#frmConsultaEntrega #GrdConsultaEntrega").kendoGrid({
          pdf: SetPdfOptions("Listagem de Entregas"),
          pdfExport: function(e) {
            tituloPdfExport = 'Listagem de Entregas';
        },
        dataSource: DtsConsultaEntrega,
        height: getHeightGridQuery("ConsultaEntrega"),
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
          $("#frmConsultaEntrega #BarAcoes").data("kendoToolBar").enable("#BtnEditar", false);
        },
        pageable: {
          pageSizes: [100, 300, 500, "all"],
          numeric: false,
          input: true
        },
        columns: getColumnsQuery(arrDataSource),
        columnShow: function (e) {
          setWidthOnShowColumnGrid(e, 'ConsultaEntrega');
        },
        columnHide: function (e) {
          setWidthOnHideColumnGrid(e, 'ConsultaEntrega');
        },
        dataBound: function (e) {
          LoadGridExportActions('frmConsultaEntrega', 'GrdConsultaEntrega', <?= ($frmResult === '') ?>);
        },
        filter: function (e) {
          mountFilteredScreen('filterColumn', e, 'ConsultaEntrega', arrDataSource, DtsConsultaEntrega, getExtraFilter())
        },
        change: function () {
          $("#frmConsultaEntrega #BarAcoes").data("kendoToolBar").enable("#BtnEditar")
        }
      })

      $("#frmConsultaEntrega #GrdConsultaEntrega").on("dblclick", " tbody> tr", function () {
      })
      //------------------------------------------------------------------------------------------------------// 

    //------------------------------------------------------------------------------------------------------//
    // CriaTela de visualização de item do grid na consulta e faz outrs ajustes
    //------------------------------------------------------------------------------------------------------//
    createScreenPreview(arrDataSource, "ConsultaEntrega")
    //------------------------------------------------------------------------------------------------------//



  })
</script>

<div class="k-form">
  <form id="frmConsultaEntrega">
    <div id="splConsulta">
      <div id="splHeader">
        <div class="k-bg-blue screen-filter-content">
          <table>
            <tr>
              <td style="width: 120px;text-align: right;vertical-align: top;padding-top: 6px;">
                Filtros(s):
              </td>
              <td>
                <div id="fltConsultaEntrega" style="width: auto; "></div>
              </td>

              <td style="vertical-align: bottom;padding-bottom: 5px;">
                <span id="BtnPesquisar" style="cursor: pointer;width: 100px;height: 24px;" title="Pesquisar"
                  data-role="button" class="k-button k-button-icon" role="button" aria-disabled="false" tabindex="29">
                  <span class="k-sprite k-pg-icon k-i-l1-c2" style="margin: 0 auto; text-align: center;"></span>
                  <span style="margin: 0 auto; margin-right: 3px;">Pesquisar</span>
                </span>
                <span id="BtnAddFilter" style="cursor: pointer;width: 21px !important;height: 21px !important"
                  title="Adicionar Filtro" data-role="button" class="k-button k-button-icon" role="button" aria-disabled="false" tabindex="">
                  <span class="k-sprite k-pg-icon k-i-l1-c1" style="margin: 0 auto;margin-top: 1.4px;"></span>
                </span>
              </td>
            </tr>
          </table>
          <div id="BarAcoes" style="text-align: right; height: 28px"></div>
        </div>
      </div>

      <div id="splMiddle">
        <div id="GrdConsultaEntrega" data-use-state-screen ="true" data-get-state-screen = "false" style="height: auto"></div>
      </div>

      <div id="splFooter">
        <div id="bottonConsultaEntrega">
          <div id="tabStripConsultaEntrega">
            <ul>
              <li id="tabDadosGerais" class="k-state-active">Detalhes</li>
            </ul>
            <div id="tabDadosGeraisVisualizacaoConsultaEntrega"></div>
          </div>
      </div>

    </div>
  </form>

</div>