<section>
<table id="table" ></table>
<div id="le_tablePager"></div>
<div id="dialog-message"></div>
</section>
<script type="text/javascript">
$(function(){
        var pager = $('#le_tablePager');
		 var lastsel;
$('#table').jqGrid({
	url:'/adminka/getDataGrid/movies',
	datatype: 'json',
	mtype: 'POST',
	height: 400,
	width:1024,
	colNames:['Ім\'я','Рік','Фантастика','Жахи','Комедія','Історичний','Мультфільм','Серіал','Драма','Бойовик','18+','IP користувача'],
	colModel :[
	{name:'name',index:'name', width:150,editable:true, edittype:"text", editrules: { required: true }},
	{name:'year',index:'year', width:40,align: 'center',editable:true, edittype:"select", editrules: { required: true },editoptions:{value:"Null:Обрати;<?php $i = 1970;$j = date('Y');for($j;$j>=$i;$j--)echo $j.':'.$j.';';?>"}},
	{name:'cat1',index:'cat1', width:50,align: 'center',formatter:'checkbox',editable:true,edittype:"checkbox"},
	{name:'cat2',index:'cat2', width:50,align: 'center',formatter:'checkbox',editable:true,edittype:"checkbox"},
	{name:'cat3',index:'cat3', width:50,align: 'center',formatter:'checkbox',editable:true,edittype:"checkbox"},
	{name:'cat4',index:'cat4', width:50,align: 'center',formatter:'checkbox',editable:true,edittype:"checkbox"},
	{name:'cat5',index:'cat5', width:50,align: 'center',formatter:'checkbox',editable:true,edittype:"checkbox"},
	{name:'cat6',index:'cat6', width:50,align: 'center',formatter:'checkbox',editable:true,edittype:"checkbox"},
	{name:'cat7',index:'cat7', width:50,align: 'center',formatter:'checkbox',editable:true,edittype:"checkbox"},
	{name:'cat8',index:'cat8', width:50,align: 'center',formatter:'checkbox',editable:true,edittype:"checkbox"},
	{name:'cat9',index:'cat9', width:50,align: 'center',formatter:'checkbox',editable:true,edittype:"checkbox"},
	{name:'ip',index:'ip', width:100,align: 'center',editable:true, edittype:"text", editrules: { required: true },editoptions:{value:"<?=$_SERVER["REMOTE_ADDR"];?>"}}
	],
	pager: pager,
	multiselect:true,
	rowNum:20,
	rowList:[20,40,50,100],
	sortname: 'id',
	sortorder: 'asc',
	caption: 'Фільми варті перегляду',
	rownumbers: true,
	rownumWidth: 40,
	viewrecords: true,
	editurl:'/adminka/jqgrid_crud/movies',
	});
	$("#table").jqGrid('navGrid','#le_tablePager',  // Управление тулбаром таблицы
	{add:true,edit:false,del:true,search: true},
	{},
	{},
	{},
	{ multipleSearch:true, closeAfterSearch:true, showQuery: true }
	// Опции окон удаления
	);
$('#table').jqGrid('setGroupHeaders', {
  useColSpanStyle: false, 
  groupHeaders:[
	{startColumnName: 'cat0', numberOfColumns: 9, titleText: '<em>Категорія</em>'}
  ]	
});
jQuery('#table').jqGrid('inlineNav', '#le_tablePager', { edit: true, add: false});
});
</script>