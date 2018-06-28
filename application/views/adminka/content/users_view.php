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
	url:'/adminka/getDataGrid/users',
	datatype: 'json',
	mtype: 'POST',
	height: 400,
	width:1024,
	colNames:['Прізвище','Ім\'я','Дата народження','email','Пароль','Статус','Дата реєстрації'],
	colModel :[
	{name:'surname',index:'surname', width:75,editable:true},
	{name:'name', index:'name', width:50,editable:true,searchoptions:{sopt:['in','ni']}},
	{name:'birth', index:'day', width:100,align: 'center',editable: true, searchoptions:{sopt:['eq','ne']}},
	{name:'email', index:'email', width:100,editable:true, edittype:"text",searchoptions:{sopt:['lt','le','gt','ge']}},
	{name:'pass',  width:100,editable:true, edittype:"text",searchoptions:{sopt:['lt','le','gt','ge']}},
	{name:'stutus', index:'stutus', width:50,editable:true, edittype:"text",searchoptions:{sopt:['lt','le','gt','ge']}},
	{name:'datatime', index:'datatime', width:100,editable:false, edittype:"text",formatter: 'date',formatoptions:{srcformat:'Y-m-d H:i:s',newformat:'d F Y'},searchoptions:{sopt:['lt','le','gt','ge'],dataInit: function(element){$(element).datepicker({dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true});}}},
	],
	pager: pager,
	rowNum:20,
	rowList:[20,40,50,100],
	sortname: 'id_user',
	sortorder: 'asc',
	caption: 'Користувачі',
	rownumbers: true,
	rownumWidth: 40,
	 viewrecords: true,
	editurl:'/adminka/jqgrid_crud/users'
	});
	$("#table").jqGrid('navGrid','#le_tablePager',  // Управление тулбаром таблицы
	{add:false,edit:true,del:true,search: true},
	{},
	{},
	{},
	{ multipleSearch:true, closeAfterSearch:true, showQuery: true }
	// Опции окон удаления
	);
/*jQuery("#table").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});*/

});
</script>