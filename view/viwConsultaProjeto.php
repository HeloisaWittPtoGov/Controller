<?php
@header("Content-Type: text/html; charset=ISO-8859-1", true);
?>

<script>
  $(function () {

    var arrDataSource = [
      {
        name: "idprojeto",
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
        name: "dstitulo",
        type: "string",
        label: "Titulo",
        visibleFilter: "true",
        orderFilter: "1",

        orderGrid: "2",
        widthGrid: "",
        hiddenGrid: "false",
        headerAttributesGrid: "text-aling: center",
        attibutesGrid: "text-aling: center",

        showPreview: "true",
        widthPreview: "600",
        positionPreview: "2",
        indiceTabPreview: "tabDadosGerais",
      },
      {
        name: "dsdescricao",
        type: "string",
        label: "Descrição",
        visibleFilter: "true",
        orderFilter: "3",

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
        name: "dtinicio",
        type: "date",
        label: "Data de Inicio",
        visibleFilter: "true",
        orderFilter: "4",

        orderGrid: "4",
        widthGrid: "",
        hiddenGrid: "false",
        headerAttributesGrid: "text-aling: center",
        attibutesGrid: "text-aling: center",

        showPreview: "true",
        widthPreview: "120",
        positionPreview: "4",
        indiceTabPreview: "tabDadosGerais",
      },
      {
        name: "dtprevistatermino",
        type: "date",
        label: "Data Prevista de Término",
        visibleFilter: "true",
        orderFilter: "5",

        orderGrid: "5",
        widthGrid: "",
        hiddenGrid: "false",
        headerAttributesGrid: "text-aling: center",
        attibutesGrid: "text-aling: center",

        showPreview: "true",
        widthPreview: "120",
        positionPreview: "7",
        indiceTabPreview: "tabDadosGerais",
        togetherPreview: "dtinicio",
      },
      {
        name: "flstatus",
        type: "string",
        label: "Status",
        visibleFilter: "true",
        orderFilter: "8",

        orderGrid: "8",
        widthGrid: "100",
        hiddenGrid: "false",
        headerAttributesGrid: "text-aling: center",
        attibutesGrid: "text-aling: center",

        showPreview: "true",
        widthPreview: "120",
        positionPreview: "8",
        indiceTabPreview: "tabDadosGerais",
      },
    ]

    //------------------------------------------------------------------------------------------------------//
    // Configura tela para usar splitter
    //------------------------------------------------------------------------------------------------------//
    arrDataSource = LoadConfigurationQuery(arrDataSource, "ConsultaProjeto")
    //------------------------------------------------------------------------------------------------------//

    //------------------------------------------------------------------------------------------------------//
    // Instanciando os campos combo da consulta
    //------------------------------------------------------------------------------------------------------//
    createPgFilter(arrDataSource, "ConsultaProjeto")
    //------------------------------------------------------------------------------------------------------//

    //------------------------------------------------------------------------------------------------------//
    // Area de botões de ação
    //------------------------------------------------------------------------------------------------------//
    $("#frmConsultaProjeto #BarAcoes").kendoToolBar({
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
                OpenWindow(true, "CadastroProjeto", "controller/ctrProjeto.php?action=incluir");
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
                var GrdConsultaProjeto = $("#frmConsultaProjeto #GrdConsultaProjeto").data("kendoGrid");
                var RstProjeto = GrdConsultaProjeto.dataItem(GrdConsultaProjeto.select());
                OpenWindow(true, "CadastroProjeto", "controller/ctrProjeto.php?action=editar&idProjeto="+RstProjeto.idprojeto);
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
                $("#WinConsultaProjeto").data("kendoWindow").close();
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
      var arrFields = LoadFilterSplitter('ConsultaProjeto', arrDataSource)

      return arrFields;
    }
    //-----------------------------------------------------------------------------------------------------//

    //------------------------------------------------------------------------------------------------------//
    // Instanciando dataSource da consulta
    //------------------------------------------------------------------------------------------------------//
    var DtsConsultaProjeto = new kendo.data.DataSource({
      paeSize: 100,
      serverPaging: true,
      serverFiltering: true,
      serverSorting: true,
      transport: {
        read: {
          url: "controller/ctrProjeto.php",
          type: "GET",
          dataType:"JSON",
          data: function(){
            return{
              action: 'ListProjeto',
              filters: getExtraFilter(),
            }
          }
        }
      },
      schema: {
        data: "jsnProjeto",
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
    $("#frmConsultaProjeto #BtnPesquisar").kendoButton({
      spriteCssClass: "k-pg-icon k-i-l1-c2",
      click: function(e){
        mountFilteredScreen('filterDefault', e, 'ConsultaProjeto', arrDataSource, DtsConsultaProjeto, getExtraFilter());

        $("#frmConsultaProjeto #BarAcoes").data("kendoToolBar").enable("#BtnEditar", false);
      }
    })
    //------------------------------------------------------------------------------------------------------//



    //------------------------------------------------------------------------------------------------------//
    // Instanciando grid da consulta
    //------------------------------------------------------------------------------------------------------//
    $("#frmConsultaProjeto #GrdConsultaProjeto").kendoGrid({
      pdf: SetPdfOptions("Listagem de Projeto"),
      pdfExport: function(e) {
        tituloPdfExport = 'Listagem de Projeto';
      },
      dataSource: DtsConsultaProjeto,
      heigth: getHeightGridQuery("ConsultaProjeto"),
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
       $("#frmConsultaProjeto #BarAcoes").data("kendoToolBar").enable("#BtnEditar", false);
      },
      pageable: {
        pageSizes: [100, 300, 500, "all"],
        numeirc: false,
        input: true
      },
      columns: getColumnsQuery(arrDataSource),
      columnShow: function (e) {
        setWidthOnShowColumnGrid(e, 'ConsultaProjeto');
      },
      columnHide: function (e) {
         setWidthOnHideColumnGrid(e, 'ConsultaProjeto');
      },
      dataBound: function (e) {
        LoadGridExportActions('frmConsultaProjeto', 'GrdConsultaProjeto', <?= ($frmResult === '') ?>);
      },
      filter: function (e) {
        mountFilteredScreen('filterColumn', e, 'ConsultaProjeto', arrDataSource, DtsConsultaProjeto, getExtraFilter())
      },
      change: function () {
        $("#frmConsultaProduto #BarAcoes").data("kendoToolBar").enable("#BtnEditar")
      }
    })

    $("#frmConsultaProjeto #GrdConsultaProjeto").on("dbclick", " tbody> tr", function () {
    })
    //------------------------------------------------------------------------------------------------------//

    //------------------------------------------------------------------------------------------------------//
    // Ações diversas da tela de consulta
    //------------------------------------------------------------------------------------------------------//

    //------------------------------------------------------------------------------------------------------//

    //------------------------------------------------------------------------------------------------------//
    // CriaTela de visualização de item do grid na consulta e faz outrs ajustes
    //------------------------------------------------------------------------------------------------------//
    createScreenPreview(arrDataSource, "ConsultaProjeto")
    //------------------------------------------------------------------------------------------------------//

  })
</script>

<div class="k-form">
  <form id="frmConsultaProjeto">
    <div id="splConsulta">
      <div id="splHeader">
        <div class="k-bg-blue screen-filter-content">
          <table>
            <tr>
              <td style="width: 120px;text-align: right;vertical-align: top;padding-top: 6px;">
                Filtro(s):
              </td>
              <td>
                <div id="fltConsultaProjeto" style="width: auto; "></div>
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
        <div id="GrdConsultaProjeto" data-use-state-screen="true" data-get-state-scree="false"
          style="height: auto"></div>
      </div>
      <div id="splfooter">
        <div id="bottonConsultaProjeto">
          <div id="tabStripConsultaProjeto">
            <ul>
              <li id="tabDadosGerais" class="k-state-active">Detalhes</li>
            </ul>
            <div id="tabDadosGeraisVisualizacaoConsultaProjeto"></div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

