<section>
<table id="table"></table>
<div id="le_tablePager"></div>
<div id="dialog-message"></div>
<div id="add_poll" style="display:none" >
	<div id="content" role="main">
	<h2 id="title"><?=$title; ?></h2>
		<?=form_open('/poll/create', array('class' => 'adpt_inputs_form')); ?>
		<ul class="adpt_errors"></ul>
		<dl>
			<dt>Назва опитування:</dt>
			<dd><?=form_input(array('name' => 'title', 'id' => 'title', 'class' => 'txt_input', 'value' => set_value('title'))); ?></dd>
		</dl>
		<div id="poll_options" class="adpt_inputs">
			<p>Введіть варіанти відповідей:</p>
			<ol class="adpt_inputs_list"></ol>
			<p><a href="#" class="adpt_add_option btn_add">Додати</a></p>
		</div>
		<?=form_error('options[]'); ?>
		<p><button type="submit" name="adpt_submit">Створити</button></p>
		<?=form_close(); ?>
	</div>
</div>
</section>	
<?=$js;?>
<script type="text/javascript">
$('#poll_options').WMAdaptiveInputs({
	minOptions: '<?=$min_options; ?>',
	maxOptions: '<?=$max_options; ?>',
	inputNameAttr: 'options[]',
	inputClassAttr: 'btn_remove'
});
function showForm(oper) 
{
	if(oper!='')
	{
		$.post('/poll/getEdit/'+oper,function(msg)
		{
			alert(msg);
			
		});	
		$('#title').text('Редагувати голосування');
	}
	else
	{
		
		$('#title').text('Додати голосування');
	}
	
	
	$( "form" )[ 0 ].reset();
	$('#add_poll').dialog({
		width:530,
		height:620
		});
}
$(function(){
var pager = $('#le_tablePager');
$('#table').jqGrid({
  url:'/adminka/getDataGrid/poll',
  datatype: 'json',
  mtype: 'POST',
  height: 300,
  width: 1024,
  colNames:['Запитання','Статус','Скинути','Створено'],
  colModel :[
	{name:'question', index:'question', width:200,searchoptions:{sopt:['bw','bn','ew',,'en','cn','nc']}},
	{name:'status', index:'status',align: 'center', width:50,editable:true, edittype:"select",
	editoptions:{value:"inactive:Неактивне;active:Активне"},formatter:'select'},
	{name:'reset',align: 'center', width:40,editable: false,search:false},
	{name:'data', index:'data',align: 'center', width:50,formatter: 'date',formatoptions:{srcformat:'Y-m-d H:i:s',newformat:'d F Y'},searchoptions:{sopt:['lt','le','gt','ge'],dataInit: function(element){$(element).datepicker({dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true});}}},
   ],
  pager: pager,
  viewrecords: true,
  rowNum:10,
  rowList:[10,20,25],
  sortname: 'id',
  sortorder: 'asc',
  caption: 'Всі опитування на сайті',
  rownumbers: true,
  rownumWidth: 40,
  editurl:'/adminka/jqgrid_crud/poll'
});
		
$("#table").jqGrid('navGrid','#le_tablePager',  // Управление тулбаром таблицы
    {add:false,edit:true,del:true},{},{},{},{ multipleSearch:true, closeAfterSearch:true, showQuery: true })./*navButtonAdd('#le_tablePager',
	{
	  caption:"",
	   buttonicon:" ui-icon-pencil",
	   title:"Редагувати опитування",
		onClickButton: function()
		{
			var selr = jQuery('#table').jqGrid('getGridParam','selrow'); 
			if(selr) showForm(selr);else message('Попередження',"Оберіть запис для редагування");  	
		}, 
		position:"first"
	 })*/navButtonAdd('#le_tablePager',{
	caption:"",
	title:"Додати опитування", 
	 buttonicon:" ui-icon-plus",
	onClickButton: function(){showForm('');}, 
	position:"first"
	});
});
</script>
<script  charset="utf-8">
		$(function(){
			$('form.adpt_inputs_form').each(function(){
				$this = $(this);
				$this.find('button[name="adpt_submit"]').on('click', function(event){
					event.preventDefault();
					var str = $this.serialize();
					$.post('/poll/create', str, function(response){
						var jsonObj = $.parseJSON(response);
						if (jsonObj.fail == false)
						{
							message('Повідомлення','Створено');
							$('#add_poll').dialog("close");
							$('#table').trigger( 'reloadGrid' );
						}
						else
							$this.find('.adpt_errors').html(jsonObj.error_messages).hide().slideDown();
					});
				});
			});
		});
	</script>