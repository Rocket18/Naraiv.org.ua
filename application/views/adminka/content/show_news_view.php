<section>
<table id="table"></table>
<div id="le_tablePager"></div>
<div id="dialog-message"></div>
</section>
<script type="text/javascript">
$(function(){
var pager = $('#le_tablePager');
$('#table').jqGrid({
  url:'/adminka/getDataGrid/news',
  datatype: 'json',
  mtype: 'POST',
  height: 300,
  width: 1024,
  colNames:['Назва','Автор','Переглядів','Дата','Публіковані'],
  colModel :[
	{name:'title_news', index:'title_news', width:150,searchoptions:{sopt:['bw','bn','ew',,'en','cn','nc']}},
	{name:'author', index:'author',align: 'center', width:50,searchoptions:{sopt:['eq','bw','bn','ew',,'en','cn','nc']}},
	{name:'views',align: 'center', index:'views', width:40,searchoptions:{sopt:['lt','le','gt','ge']}},
	{name:'data', index:'data',align: 'center', width:50,formatter: 'date',formatoptions:{srcformat:'Y-m-d H:i:s',newformat:'d F Y'},searchoptions:{sopt:['lt','le','gt','ge'],dataInit: function(element){$(element).datepicker({dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true});}}},
	{name:'publish', index:'publish',align: 'center', width:40, formatter:'checkbox',search:false,},
   ],
  pager: pager,
  viewrecords: true,
  rowNum:10,
  rowList:[10,20,30,100],
  sortname: 'news_id',
  sortorder: 'asc',
  caption: 'Всі новини опубліковані на сайті',
  rownumbers: true,
  rownumWidth: 40  
});
		
$("#table").jqGrid('navGrid','#le_tablePager',  // Управление тулбаром таблицы
    {add:false,edit:false,del:true},{},{},{url:'/adminka/jqgrid_crud/news'},{ multipleSearch:true, closeAfterSearch:true, showQuery: true }).navButtonAdd('#le_tablePager',
	{
	  caption:"",
	   buttonicon:" ui-icon-pencil",
	   title:"Редагувати вибрану новину",
		onClickButton: function()
		{
			var selr = jQuery('#table').jqGrid('getGridParam','selrow'); 
			if(selr) redirect(selr);else message('Попередження',"Оберіть запис для редагування");  	
		}, 
		position:"first"
	 }).navButtonAdd('#le_tablePager',{
	caption:"",
	title:"Додати новину", 
	 buttonicon:" ui-icon-plus",
	onClickButton: function(){redirect('');}, 
	position:"first"
	});
function redirect(id)
{
	$.ajax({
	  type: "POST",
	  data: "ajax=1",
	  url: "/adminka/show/news_add/"+id,
	  beforeSend: function() {
		$("section").html('<p class="load">Триває завантаження...</p>');
	  },
	  success: function(msg){
		$("section").html(msg);
		$("body,html").animate(2000);
	  }
	}); 
}
});
</script>