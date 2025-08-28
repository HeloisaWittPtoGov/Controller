<?php
@header("Content-Type: text/html; charset=ISO-8859-1", true);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="ISO8859-1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Consulta de Projetos</title>

	<script>
		$(function () {

			var arrDataSource = [
				{
					name: "idprojeto",
					type: "interger",
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
			cratePgFilter(arrDataSource, "ConsultaLivro")
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
						button: [
							{
								id: "BtnIncluir",
								spriteCSSClass: "k-pg-icon k-i-l1-c1",
								text: "Incluir",
								group: "actions",
								attributes: {
									"tabindex": "30"
								},
								enable: false,
								click: function () {
									let GrdConsultaLivro = $("#frmConsultaProjeto #GrdConsultaProjeto").data("kendoGrid");
									let rstGrid = GrdConsultaProjeto.dataItem(GrdConsultaProjeto.select());
									$("#frmConsultaProjeto #idProjeto").val(rstGrid.idProjeto)

									OpenWindown(true, "CadastroProjeto");
								}
							}
						]
					}
				]
			})
			//------------------------------------------------------------------------------------------------------//

			//------------------------------------------------------------------------------------------------------//
			// Instanciando dataSource da consulta
			//------------------------------------------------------------------------------------------------------//
			var DtsConsultaProjeto = new kendo.data.DataSource({
				paeSize: 100,
				transport: {
					read: function (opitions) {
						opitions.success(arrProjetos)
						console.log(projetosStorage.arrProjetos)
					}
				},
				schema: {
					model: {
						fields: getModelDataSource(arrDataSource)
					}
				},
			})
			//------------------------------------------------------------------------------------------------------//

			//------------------------------------------------------------------------------------------------------//
			// Instanciando grid da consulta
			//------------------------------------------------------------------------------------------------------//
			$("#frmConsultaProjeto #GrdConsultaProjeto").kendoGrid({
				dataSource: DtsConsultaProjeto,
				heigth: getHeightGridQuery("ConsultaLivro"),
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
				},

				pageable: {
					pageSizes: [100, 300, 500, "all"],
					numeirc: false,
					input: true
				},
				toolbar: ["excel"],

				columns: getColumnsQuery(arrDataSource),
				columnShow: function (e) {
				},
				columnHide: function (e) {
				},
				dataBound: function (e) {
				},
				filter: function (e) {
				},
				change: function () {
					$("#BarAcoes").data("kendoToolBar").enable("#BtnEditar")
				}
			})

			$("#frmConsultaProjeto #GrdConsultaProjeto").on("dbclick", " tbody> tr", function () {
			})
			//------------------------------------------------------------------------------------------------------//

			//------------------------------------------------------------------------------------------------------//
			// Ações diversas da tela de consulta
			//------------------------------------------------------------------------------------------------------//
			$("#WinConsultaLivro").data("kendoWindow").open()
			//------------------------------------------------------------------------------------------------------//

			//------------------------------------------------------------------------------------------------------//
			// CriaTela de visualização de item do grid na consulta e faz outrs ajustes
			//------------------------------------------------------------------------------------------------------//
			crateScreenPreview(arrDataSource, "ConsultaProjeto")
			//------------------------------------------------------------------------------------------------------//

		})
	</script>
</head>

<body>
	<div class="k-form">
		<form id="frmConsultaProjeto">
			<input id="idProjeto" type="hidden">

			<div id="splConsulta">
				<div id="splHeader">
					<div class="k-bg-blue screen-filter-content">
						<table>
							<tr>
								<td style="width:120px; text-aling: right; vertical-align: top; padding-top:6px">
									Filtro(s):
								</td>
								<td>
									<div id="fltConsultaProjeto" style="width: auto;"></div>
								</td>
								<td style="vertical-align: bottom; padding-bottom: 5px;">
									<span id="BtnPesquisar" style="cursor: pointer; width: 100px; height: 24px"
										title="Pesquisar" data-role="button" class="k-button k-button-icon"
										role="button" aria-disabled="false" tabindex="29">
										<span class="k-sprite k-pg-icon k-i-11-c2"
											style="margin: 0 auto; text-align:center"></span>
										<span style="margin:0 auto; margin-right: 3px">Pesquisar</span>
									</span>
									<span id="BtnAddFilter"
										style="cursor: pointer; width: 21px !important; height: 12px !important"
										title="Adicionar filtro" data-role="button" class="k-button k-button-icon"
										role="button" aria-disabled="false" tabindex="">
										<span class="k-sprite k-pg-icon k-i-l1-c1"
											style="margin: 0 auto; margin-top: 1.4px;"></span>
									</span>
								</td>
							</tr>
						</table>
						<div id="BarAcoes" style="text-align: right; height: 28px"></div>
					</div>
				</div>
				<div id="splMiddle">
					<div id="GrdConsultaLivro" data-use-state-screen="true" data-get-state-scree="false"
						style="height: auto"></div>
				</div>
				<div id="splfooter">
					<div id="bottonConsultaProjeto">
						<div id="tabStripConsultaProjeto">
							<ul>
								<li id="tabDadosGerais" class="k-state-active">Detalhes</li>
							</ul>
							<div id="tabDadosGEraisVisualizacaoConsultaProejto"></div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>

</body>

</html>