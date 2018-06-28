<div id="content">
<form action="/video/direct_upload" method="post"
  enctype="multipart/form-data" onsubmit="return checkForFile();">
  <input id="file" type="file" name="file"/>
  <div id="errMsg" style="display:none;color:red">
    You need to specify a file.
  </div>
  <input type="hidden" name="token" value="TOKEN"/>
  <input type="submit" value="go" />
</form>
 <div id="back-top"><a href="#top"><img src="/img/up.png" width="50" height="93" title="Вверх" alt="Вгору"></a></div>
</div>