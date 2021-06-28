<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script>
    function fprogress(e) { 
      document.getElementById('progress').innerHTML ='progress: ' + e.loaded + ' from 242 countries'; 
    }
    function call() {  
      var req = new XMLHttpRequest();  
      req.addEventListener("progress", fprogress, false);
      req.open('GET', 'main.php', true);  req.send(null);
    }
   </script>
  <title>Pars</title>
</head>
<body>
  <button onclick='call()'>parse</button>
  <div id='progress'>...</div>
</body>
</html>