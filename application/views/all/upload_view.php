<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="/css/fileuploader.css" rel="stylesheet" type="text/css" />
<title>Завантаження файлів</title>
</head>

<body>
<div id="file-uploader">
<noscript>
<p>Please enable JavaScript to use file uploader.</p>        
<!-- or put a simple form for upload here -->
</noscript>
</div>
<script src="/js/fileuploader.js" type="text/javascript"></script>
<script>            
function createUploader() {
         var uploader = new qq.FileUploader({
             element: document.getElementById('file-uploader'),
             action: '/upload2/do_upload',
             multiple: true,
             debug: true
         });
}        
// in your app create uploader as soon as the DOM is ready    
// don't wait for the window to load      
window.onload = createUploader;     
</script>
</body>
</html>