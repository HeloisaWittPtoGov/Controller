<?php
@header("Content-Type: text/html; charset=ISO-8859-1", true);
?>

<script>
  $(function (){

    var arrDataSource = [
      {
          name: "idetapaprojeto",
          type: "integer",
          label: "ID",
          visibleFilter: "true",
          orderFilter: "2",

          orderGrid: "1",
          widthGrid: "70",
          hiddenGrid: "false",
          headerAttributesGrid: "text-aling: center",
          attibutesGrid: "text-aling: center",

          showPreview: "true",
          widthPreview: "70",
          positionPreview: "1",
          indiceTabPreview: "tabDadosGerais",
      },
      {
          name: "idprojeto",
          type: "integer",
          label: "ID Projeto",
          visibleFilter: "true",
          orderFilter: "3",

          orderGrid: "2",
          widthGrid: "70",
          hiddenGrid: "false",
          headerAttributesGrid: "text-aling: center",
          attibutesGrid: "text-aling: center",

          showPreview: "true",
          widthPreview: "70",
          positionPreview: "2",
          indiceTabPreview: "tabDadosGerais",
          togetherPreview:"idetapaprojeto,"
      },
      {
          name: "nmetapa",
          type: "string",
          label: "Etapa",
          visibleFilter: "true",
          orderFilter: "1",

          orderGrid: "3",
          widthGrid: "",
          hiddenGrid: "false",
          headerAttributesGrid: "text-aling: center",
          attibutesGrid: "text-aling: center",

          showPreview: "true",
          widthPreview: "600",
          positionPreview: "3",
          indiceTabPreview: "tabDadosGerais",
      },
      {
          name: "dtprevistainicio",
          type: "date",
          label: "Data Prevista Inicio",
          visibleFilter: "true",
          orderFilter: "4",

          orderGrid: "4",
          widthGrid: "",
          hiddenGrid: "false",
          headerAttributesGrid: "text-aling: center",
          attibutesGrid: "text-aling: center",

          showPreview: "true",
          widthPreview: "100",
          positionPreview: "4",
          indiceTabPreview: "tabDadosGerais",
      },
      {
          name: "dtprevistatermino",
          type: "date",
          label: "Data Prevista Termino",
          visibleFilter: "true",
          orderFilter: "5",

          orderGrid: "5",
          widthGrid: "",
          hiddenGrid: "false",
          headerAttributesGrid: "text-aling: center",
          attibutesGrid: "text-aling: center",

          showPreview: "true",
          widthPreview: "100",
          positionPreview: "5",
          indiceTabPreview: "tabDadosGerais",
          togetherPreview:"dtprevistainicio" 
      },
      {
          name: "flstatus",
          type: "string",
          label: "Status",
          visibleFilter: "true",
          orderFilter: "6",

          orderGrid: "6",
          widthGrid: "",
          hiddenGrid: "false",
          headerAttributesGrid: "text-aling: center",
          attibutesGrid: "text-aling: center",

          showPreview: "true",
          widthPreview: "100",
          positionPreview: "6",
          indiceTabPreview: "tabDadosGerais",
      },
      {
          name: "idresponsaveletapaprojeto",
          type: "string",
          label: "Responsável Etapa",
          visibleFilter: "true",
          orderFilter: "7",

          orderGrid: "7",
          widthGrid: "",
          hiddenGrid: "false",
          headerAttributesGrid: "text-aling: center",
          attibutesGrid: "text-aling: center",

          showPreview: "true",
          widthPreview: "100",
          positionPreview: "7",
          indiceTabPreview: "tabDadosGerais",
      }
    ] 
    //------------------------------------------------------------------------------------------------------//
    // Configura tela para usar splitter
    //------------------------------------------------------------------------------------------------------//
    arrDataSource = LoadConfigurationQuery(arrDataSource, "ConsultaEtapaProjeto")
    //------------------------------------------------------------------------------------------------------//

    //------------------------------------------------------------------------------------------------------//
    // Instanciando os campos combo da consulta
    //------------------------------------------------------------------------------------------------------//
    createPgFilter(arrDataSource, "ConsultaEtapaProjeto")
    //------------------------------------------------------------------------------------------------------//

    //------------------------------------------------------------------------------------------------------//
    // Area de botões de ação
    //------------------------------------------------------------------------------------------------------//
    $("#frmConsultaEtapaProjeto #BarAcoes").kendoToolBar({
      items: [
        {
          type: "spacer"
        },
        {
          type: "buttonGroup",
          buttons: [
            {
              id: "BtnIncluir",
              spriteCssClass: "k-pg-icon k-i-l1-c1",
              text: "Incluir",
              group: "actions",
              attributes: {
                "tabindex": "30"
              },
              click: function () {
                OpenWindow(true, "CadastroEtapaProjeto", "controller/ctrEtapaProjeto.php?action=incluir");
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
              click: function () {
                var GrdConsultaEtapaProjeto = $("#frmConsultaEtapaProjeto #GrdConsultaEtapaProjeto").data("kendoGrid");
                var RstEtapaProjeto = GrdConsultaEtapaProjeto.dataItem(GrdConsultaEtapaProjeto.select());
                OpenWindow(true, "CadastroEtapaProjeto", "controller/ctrEtapaProjeto.php?action=editar&idEtapaProjeto="+RstEtapaProjeto.idetapaprojeto);
              }
            },
            {
              id: "BtnFechar",
              spriteCssClass: "k-pg-icon k-i-l1-c4",
              text: "Fechar",
              group: "actions",
              attributes: {
                "tabindex": "32"
              },
              click: function() {
                $("#WinConsultaEtapaProjeto").data("kendoWindow").close();
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
        var arrFields = LoadFilterSplitter('ConsultaEtapaProjeto', arrDataSource)

        return arrFields;
      }
      //-----------------------------------------------------------------------------------------------------//

      //------------------------------------------------------------------------------------------------------//
      // Instanciando dataSource da consulta
      //------------------------------------------------------------------------------------------------------//
      var DtsConsultaEtapaProjeto = new kendo.data.DataSource({
        pageSize: 100,
        serverPaging: true,
        serverFiltering: true,
        serverSorting: true,
        transport: {
          read: {
            url: "controller/ctrEtapaProjeto.php",
            type: "GET",
            dataType:"JSON",
            data: function(){
              return{
                action: 'ListEtapaProjeto',
                filters: getExtraFilter(),
              }
            }
          }
        },
        schema: {
          data: "jsnEtapaProjeto",
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
      $("#frmConsultaEtapaProjeto #BtnPesquisar").kendoButton({
        spriteCssClass: "k-pg-icon k-i-l1-c2",
        click: function(e){
          mountFilteredScreen('filterDefault', e, 'ConsultaEtapaProjeto', arrDataSource, DtsConsultaEtapaProjeto, getExtraFilter());

          $("#frmConsultaEtapaProjeto #BarAcoes").data("kendoToolBar").enable("#BtnEditar", false);
        }
      })
      //------------------------------------------------------------------------------------------------------//

      //------------------------------------------------------------------------------------------------------//
      // Instanciando grid da consulta
      //------------------------------------------------------------------------------------------------------//
      $("#frmConsultaEtapaProjeto #GrdConsultaEtapaProjeto").kendoGrid({
        pdf: SetPdfOptions("Listagem de Etapas do Projeto"),
        pdfExport: function(e) {
          tituloPdfExport = 'Listagem de Etapas do Projeto';
        },
        dataSource: DtsConsultaEtapaProjeto,
        heigth: getHeightGridQuery("ConsultaEtapaProjeto"),
        selectable: "row",
        resizable: true,
        rorderable: true,
        navigatable: true,
        columnMenu: true,
        filterable: true,
        sortable: {
          mode: "multiple",
          allowUnsort: true,
        },
        sort: function () {
        $("#frmConsultaEtapaProjeto #BarAcoes").data("kendoToolBar").enable("#BtnEditar", false);
        },
        pageable: {
          pageSizes: [100, 300, 500, "all"],
          numeirc: false,
          input: true
        },
        columns: getColumnsQuery(arrDataSource),
        columnShow: function (e) {
          setWidthOnShowColumnGrid(e, 'ConsultaEtapaProjeto');
        },
        columnHide: function (e) {
          setWidthOnHideColumnGrid(e, 'ConsultaEtapaProjeto');
        },
        dataBound: function (e) {
          LoadGridExportActions('frmConsultaEtapaProjeto', 'GrdConsultaEtapaProjeto', <?= ($frmResult === '') ?>);
        },
        filter: function (e) {
          mountFilteredScreen('filterColumn', e, 'ConsultaEtapaProjeto', arrDataSource, DtsConsultaEtapaProjeto, getExtraFilter())
        },
        change: function () {
          $("#frmConsultaEtapaProjeto #BarAcoes").data("kendoToolBar").enable("#BtnEditar")
        }
      })

      $("#frmConsultaEtapaProjeto #GrdConsultaEtapaProjeto").on("dbclick", " tbody> tr", function () {
      })
      //------------------------------------------------------------------------------------------------------//
  })

</script>

<div class="k-form">
  <form id="frmConsultaEtapaProjeto">
    <div id="splConsulta">
      <div id="splHeader">
        <div class="k-bg-blue screen-filter-content">
          <table>
            <tr>
              <td style="width: 120px;text-align: right;vertical-align: top;padding-top: 6px;">
                Filtro(s):
              </td>
              <td>
                <div id="fltConsultaEtapaProjeto" style="width: auto; "></div>
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
        <div id="GrdConsultaEtapaProjeto" data-use-state-screen="true" data-get-state-screen="false"
          style="height: auto"></div>
      </div>

      <div id="splFooter">
        <div id="buttonConsultaEtapaProjeto">
          <div id="tabStripConsultaEtapaProjeto">
            <ul>
              <li id="tabDadosGerais" class="k-state-active">Detalhes</li>
            </ul>
            <div id="tabDadosGeraisVisualizacaoConsultaEtapaProjeto"></div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>