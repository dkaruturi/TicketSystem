<?php
session_start();
if(!isset($_SESSION['security'])){
  header('Location:admin.php');
}

 ?>
 <html>

<script type="text/javascript">

var view = new Array();
function makeRequest(str) {
    var httpRequest;

    if (window.XMLHttpRequest) { // Mozilla, Safari, ...
        httpRequest = new XMLHttpRequest();



    httpRequest.onreadystatechange = function() { alertContents(httpRequest, str); };
    if(str=='createticket'){
      var subject = $("#subject").val();
      var problem = $("#problem").val();
    }

    if(str=='passwordchange'){
      var username = $("#username").val();
      var password = $("#password").val();

    }
      httpRequest.open("GET","processUser.php?q="+str+"&subject="+subject+"&problem="+problem+"&username="+username+"&password="+password,true);
      httpRequest.send(null);
}
//       return httpRequest.responseText;
}


    function alertContents(httpRequest,str) {

        if (httpRequest.readyState == 4) {
            if (httpRequest.status == 200) {

              if(str=='viewticket'){

                if($("#viewticket").html()==''){
                    createTable();
                  }

              console.log(httpRequest.responseText);
              var output = httpRequest.responseText.split(";");

              for (var i = 0; i < output.length; i++) {
                if(output[i]!=""){
                var temp_array = JSON.parse(output[i]);
                console.log(temp_array);
                updateTable(temp_array);
                  }
              }

              // var button = document.createElement("button");
              // var text = document.createTextNode("Back");
              // button.setAttribute("id","submitbutton");
              // button.appendChild(text);
              // button.onclick= showButtons;
              $("#viewticket").append('<br/>');
              $("#viewticket").append($("<button>", {
                id: "submitbutton",
                text: "Back",
                click: function(){
                  showButtons("viewticket");
                }
                }
              ));

            }
              // document.getElementById("viewticket").appendChild(button);

              if(str=='createticket'){
                  console.log(httpRequest.responseText);
                  var temp_array = JSON.parse(httpRequest.responseText);
                  alert("ticket submitted");
                  updateTable(temp_array);
              }

              if(str=='passwordchange'){
                if(httpRequest.responseText='success'){
                  alert("Your password changed!");
                }
                else{
                  alert("Your username was not recognized");
                }
              }

                console.log(httpRequest.responseText);
                }


            }
        }

        function createTable(){
          var tbl = document.createElement('table');
          tbl.style.width = '100%';
          tbl.setAttribute('border', '1');
          tbl.setAttribute('id', 'table');
          tbl.setAttribute('class', "w3-table-all w3-hoverable");
          var tbdy = document.createElement('tbody');
          tbdy.setAttribute('id', 'tbody');
          tbl.appendChild(tbdy);
          document.getElementById("viewticket").appendChild(tbl);
          var array = new Array("Ticket #","Received","Subject","Status" );
          console.log(array);
          updateTable(array);
        }

        function updateTable(array){
            var j;
            var tbdy = document.getElementById("tbody");
            var table = document.getElementById("table");

              var tr = document.createElement('tr');
              for (j = 0; j < 4; j++) {
                var td = document.createElement('td')
                td.appendChild(document.createTextNode(array[j]));
                tr.appendChild(td);
                }
                console.log(tr);
                console.log(tbdy);

              tbdy.appendChild(tr);

        table.appendChild(tbdy);
        }

        function showButtons(str){
          $("#newticket").toggle();
          $("#viewtickets").toggle();
          $("#changepassword").toggle();
          $("#logout").toggle();
          $("#regular_user").toggle();

          if(str=="viewticket"){
          $("#viewticket").toggle();
          }
          if(str=="createticket"){
            $("#createticket").toggle();
          }
          if(str=="passwordchange"){
          $("#passwordchange").toggle();
          }

        }
    function hideButtons(str){

      $("#newticket").toggle();
      $("#viewtickets").toggle();
      $("#changepassword").toggle();
      $("#logout").toggle();
      $("#regular_user").toggle();

      if(str=="viewticket"){
        $("#viewticket").toggle();
      }

      if(str=="passwordchange"){
        $("#passwordchange").toggle();
      }
    }

    function viewMyTickets() {
      var viewticket = $("#viewticket");
     if(viewticket.html()==''){
       makeRequest("viewticket");
     }
       hideButtons('viewticket');
    }

    function createForm(){
      var f = $("<form>", {
        method: "/POST",
        id: "ticket"
      });

      f.append($("<input>",{
          type: "text",
          name: "subject",
          id: "subject",
          placeholder: "subject",
          text: "Subject",
          allign: "center"
      }));
      f.append('<br/>');

      f.append($("<textarea>", {
        type: "text",
        name: "problem",
        id: "problem",
        placeholder: "Enter problem here...",
        allign: "center"
      }));
      f.append('<br/>');
      f.append('<br/>');

      f.append($("<input>", {
          type: "button",
          value: "Submit",
          id: "submitbutton",
          allign: "center",
          click: function(){
            makeRequest('createticket');
            showButtons("createticket");
          }}
        ));

      f.append('<br/>');
      f.append($("<input>", {
        type: "button",
        value: "Back",
        click: function(){
          showButtons("createticket");
        },
        align: "center",
        id: "submitbutton"
      }));

      $("#createticket").append(f);
      $("#createticket").css("textAlign",'center');

    }

    function submit_new_ticket(){
      $("#createticket").toggle();
      if($("#createticket").html()==''){
        createForm();
      }
       hideButtons('createticket');
    }

    function queryUser(){
      //create form
      var f = $("<form>", {
          method: "post",
          id: 'changeinfo'
        });

        f.append("<br />");

        //query username
        f.append($("<input>",{
            type: "text",
            name: "username",
            id: "username",
            placeholder: "username",
        }));
        f.append("<br />");
        f.append("<br />");

      //query for password
      f.append($("<input>",{
          type: "text",
          name: "password",
          id: "password",
          placeholder: "new password",
      }));
      f.append("<br />");
      f.append("<br />");
      //submit button
      f.append($("<input>",{
          type: "button",
          value: "Submit",
          id: "qsubmitbutton",
          allign: "center",
          click: function(){
            makeRequest('passwordchange');
            showButtons('passwordchange');
            }
      }));

      f.append("<br />");
      //back button
      f.append($("<input>",{
          type: "button",
          value: "Back",
          id: "qbbutton",
          click: function(){
            showButtons('passwordchange');
            }
      }));

      $("#passwordchange").append(f);
    }

    function changepassword(){
      if($("#passwordchange").html()=='') {
        queryUser();
      }

      hideButtons("passwordchange");
    }
    function logout(){
      makeRequest('logout');
      window.location='admin.php';
    }



</script>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="login.css" />
<div class="regular_user" id= "regular_user">
  <table id="options">
      <tr>
        <td><button id='newticket' type='submit' onclick='submit_new_ticket()'>Submit a New Ticket</button></td>
      </tr>
      <tr>
          <td><button id="viewtickets" type="submit" onclick="viewMyTickets()">View My Tickets</button></td>
      </tr>
      <tr>
          <td><button id="changepassword" type="submit" onclick="changepassword()">Change Password</button><td>
      </tr>
          <td><button id="logout" type="submit" onclick="logout()">Logout</button><td>
  </table>
</div>
  <div id="viewticket" style="display:none";></div>
  <div id="createticket" style="display:none";></div>
  <div id="passwordchange" style="display:none";></div>
</html>
