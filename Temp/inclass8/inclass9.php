<html>
<head>
    <script type="text/javascript">
    
        function makeRequest(str) {
          if (window.XMLHttpRequest) {
            xmlhttp=new XMLHttpRequest();
          } else {
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp.onreadystatechange=function() {
            if (this.readyState==4 && this.status==200) {
              document.getElementById("txtHint").innerHTML=this.responseText;
            }
          }
          xmlhttp.onreadystatechange = function() { formatTable(xmlhttp); };
          var subject = document.getElementById('subject').value;
          var problem = document.getElementById('problem').value;
          xmlhttp.open("GET","process.php?q="+str+"&subject="+subject+"&problem="+problem,true);
          xmlhttp.send();
        }
    
    function requestWord() {
        console.log("hello world");
    }
    
    </script>
</head>
<body>


    
    <table id="table">
    </table>    

    <button id="button" onclick="requestWord()"></button>
</body>   
</html>