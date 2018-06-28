<section id="top" >
 <div class="main" >
   <div id="menu">
    <div id="tree" class="menu">
     <div class="name">Меню</div>
	  <div class="area">
      <ul>
       <?php $this->Menu_lib->outTree(0, 0);?>
       </ul>
      </div>
    </div>
  <div class="menu" id="poll">
  <div class="name" >Опитування</div>
   <div class="area">
   <?php if(is_array($poll))
   { 
    echo $poll['poll_form'];
	echo "<p><a href='/poll/poll_result' id='result'>Результати</a></p>"; 
	}
	else
		echo $poll;
   ?>
   </div>
  </div>
  <div class="menu">
   <div class="name">До нас заходять з</div>
	<div class="area">
	 <script type="text/javascript" src="http://jk.revolvermaps.com/r.js"></script>
	 <script type="text/javascript">rm_f1st('7','230','true','true','000000','axkgv41l98h','true','ff0000');</script>
	  <noscript>
        <applet codebase="http://rk.revolvermaps.com/j" code="core.RE" width="200" height="200" archive="g.jar">
        <param name="cabbase" value="g.cab" />
        <param name="r" value="true" />
        <param name="n" value="true" />
        <param name="i" value="axkgv41l98h" />
        <param name="m" value="7" />
        <param name="s" value="200" />
        <param name="c" value="ff0000" />
        <param name="v" value="true" />
        <param name="b" value="000000" />
        <param name="rfc" value="true" />
        </applet>
     </noscript>
    </div>
   </div>
  </div>