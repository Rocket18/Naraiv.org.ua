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
	url:'/adminka/getDataGrid/video',
	datatype: 'json',
	mtype: 'POST',
	height: 400,
	width:1024,
	colNames:['Відео','Категорія','Доступ','Назва','Автор','Завантажено'],
	colModel :[
	{name:'href',sortable:false,search:false,editable: false,align: 'center', width:150,formatter:createvideo},
	{name:'cat', index:'cat', width:100,align: 'center',editable:true, edittype:"select",
	editoptions:{value:"0:Школа;1:Село і люди;2:Природа;3:У нас в клубі;4:Інше"},formatter:'select', stype:"select",searchoptions:{sopt:['in','ni'], value:"0:Школа;1:Село і люди;2:Природа;3:У нас в клубі;4:Інше",multiple: true}},
	{name:'access', index:'access', width:150,align: 'center',editable: true, edittype:"select",stype:"select",editoptions: {value:"1:Для всіх;2:Тільки для зареєстрованих;3:Не затверджено;13:Не(Для всіх);23:Не(Login)"},formatter:'select',searchoptions:{sopt:['eq','ne'],value:"1:Для всіх;2:Тільки для зареєстрованих;3:Не затверджено;13:Не(Для всіх);23:Не(Login)"}},
	{name:'name', index:'name', width:250,editable:true, edittype:"text",searchoptions:{sopt:['bw','bn','ew',,'en','cn','nc']}},
	{name:'author', index:'author', width:100,align: 'center',editable:false,searchoptions:{sopt:['eq','bw','bn','ew',,'en','cn','nc']}},
	{name:'date', index:'date', width:100,editable:false, edittype:"text",formatter: 'date',formatoptions:{srcformat:'Y-m-d H:i:s',newformat:'d F Y'},searchoptions:{sopt:['lt','le','gt','ge'],dataInit: function(element){$(element).datepicker({dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true});}}}
	],
	pager: pager,
	rowNum:20,
	rowList:[20,40,50,100],
	sortname: 'id',
	sortorder: 'desc',
	caption: 'Відеозаписи з YouTube',
	rownumbers: true,
	rownumWidth: 40,
	 viewrecords: true,
	editurl:'/adminka/jqgrid_crud/video',
	});
	$("#table").jqGrid('navGrid','#le_tablePager',  // Управление тулбаром таблицы
	{add:false,edit:false,del:true,search: true},
	{},
	{},
	{},
	{ multipleSearch:true, closeAfterSearch:true, showQuery: true }
	);
jQuery('#table').jqGrid('inlineNav', '#le_tablePager', { edit: true, add: false});
/*jQuery("#table").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});*/
function createvideo(links) 
{
	var output;
	output = '<iframe width="180" height="90" src="'+links+'" frameborder="0" allowfullscreen></iframe>'
	return output;
}

jQuery('#table_iledit').click(function()
{
	var selr = jQuery('#table').jqGrid('getGridParam','selrow'); 
	if(!selr) message('Попередження',"Оберіть запис для редагування");  	
});
});
</script>