<section>
<table id="table" ></table>
<div id="le_tablePager"></div>
</section>
<script type="text/javascript">
$(function(){
        var pager = $('#le_tablePager');
		// var curRowId = -1;
$('#table').jqGrid({
                  url:'/adminka/getDataGrid/service',
                  datatype: 'json',
                  mtype: 'POST',
				  height: 345,
				  width: 1024,
                  colNames:['Силка','Короткий опис'],
                  colModel :[
                    {name:'href', index:'href', width:200,formatter:'link',formatoptions:{target: '_blank'},editable:true, edittype:"text", editrules: { required: true }, editoptions: {size: 50}},
                    {name:'description', index:'description', width:600,editable:true, edittype:"textarea",editrules: { required: true },editoptions: {rows: 7,cols:50}},
                   ],
                  pager: pager,
				  rowNum:15,
                  rowList:[15,20,25],
				  sortname: 'id',
                  sortorder: 'asc',
				  viewrecords: true,
                  caption: 'Сервіси і лінки, які використовує сайт',
				  rownumbers: true,
				  rownumWidth: 40,
        		  editurl: '/adminka/jqgrid_crud/service'

         });

//var style = $('#table').jqGrid('editGridRow','new' ,{width:500,top:100,left:200}); 

$("#table").jqGrid('navGrid','#le_tablePager',  // Управление тулбаром таблицы
    {add:true,edit:true,del:true,search: false},
	{closeAfterAdd:true, recreateForm: true, width:460},   // Edit options
    {closeOnEscape:true,closeAfterEdit:true, recreateForm: true, width:460}    //
	

	 // Опции окон удаления
);
});
</script>