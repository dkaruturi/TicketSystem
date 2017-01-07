<?php


session_start();
 ?>
<html>
<script type="text/javascript">
var info;
var array = new Array("Ticket", "Received", "Sender Name","Sender Email", "Subject", "Tech", "Status");
var sortArray;
var selectedTicket;
var ticketID;
var body;
window.onload=function(){
  makeRequest('viewalltickets');
};
function makeRequest(str) {
    var httpRequest;

    if (window.XMLHttpRequest) { // Mozilla, Safari, ...
        httpRequest = new XMLHttpRequest();


    if (!httpRequest) {
        alert('Giving up :( Cannot create an XMLHTTP instance');
        return false;
    }
      httpRequest.onreadystatechange = function() { alertContents(httpRequest, str); };
      if(str=='passwordchange'){
        var username = $("#username").val();
        var password = $("#password").val();
      }
      if(str=='emailsubmitter'){
        var subject = $("#subject").val();
        var text = $("#bodytext").val();
      }

      if(str=='textmessage'){
        var text = $("#bodytext").val();
        var phoneNumber = info[selectedTicket][7];
        var name = info[selectedTicket][2];
      }

      httpRequest.open("GET","processUser.php?q="+str+"&username="+username+"&password="+password+"&ticketID="+ticketID+"&subject="+subject+"&text="+text+"&phoneNumber="+phoneNumber+"&name="+name,true);
      httpRequest.send(null);
    }

}

function alertContents(httpRequest,str) {

    if (httpRequest.readyState == 4) {
        if (httpRequest.status == 200) {
          if(str=='viewalltickets'){
              $("#vatcheck").html("checked");
              var temp_output = httpRequest.responseText.split("***");
              var output = temp_output[0].split(";");
              var temp_body = temp_output[1].split(";");
              //console.log(output);
              output.pop();
              temp_body.pop();
              console.log(temp_body);

              info= new Array();
              body= new Array();
              var tbdy = document.createElement("tbody");
              tbdy.setAttribute("id", "tbody");

              for (var i = 0; i < output.length; i++) {

              var temp_thing = JSON.parse(temp_body[i]);
              var temp_array = JSON.parse(output[i]);
              info.push(temp_array);
              body.push(temp_thing[0]);
              updateTable(temp_array, tbdy,i);
              }
              sortArray=info;
              console.log(body);
          }

          if(str=='passwordchange'){
            if(httpRequest.responseText='success'){
              alert("Your password changed!");
            }
            else{
              alert("Your username was not recognized");
            }
          }

          if(str=='assignself'){
              var admin_name = $("#admin_name").val();
            if(httpRequest.responseText=='remove'){

              info[selectedTicket][5]=" ";
            }
            else if(httpRequest.responseText=='added'){
              info[selectedTicket][5]=admin_name;
            }
            selectTicket(selectedTicket);
          }

            console.log(httpRequest.responseText);
            }

        }
    }


    function createForm(type){
      var form = $("<form/>", {
                  method: '/POST',
                  id: 'email'
              });
              if(type!="text"){
              form.append(
                $('<input>',{
                  type: 'text',
                  name: 'subject',
                  id: 'subject',
                  placeholder: 'subject',
                  text: "subject"
                }
              ));
}
            form.append($('<textarea>',{
                  type: "text",
                  name: "text",
                  id: "bodytext",
                  placeholder: 'Enter message body here...',
                  allign: 'center'

            }));
            if(type=="text"){
              form.append($('<input>', {
                type: 'button',
                value: 'Submit',
                click: function() {
                  makeRequest("textmessage");
                  alert("text message sent");
                  back();
                },
                allign: 'center',
                id: 'submit'
              }));
            }
            else{
            form.append($('<input>', {
              type: 'button',
              value: 'Submit',
              click: function() {
                makeRequest('emailsubmitter');
                back();
              },
              allign: 'center',
              id: 'submit'
            }));
          }

          form.append($('<input>', {
              type: 'button',
              value: 'Back',
              click: function(){
                  back();
              },
              allign: 'center',
              id: 'backbutton'
            }));

      //add form
      $("#emailform").append(form);
      $("#emailform").css('text-align','center');

    }


function queryUser(){

  var form = $("<form/>", {
              method: '/POST',
              id: 'changeinfo'
          });

      form.append($('<input>', {
            type: "text",
            name: "username",
            id: "username",
            placeholder: "username"
        }));

  //query username
  form.append($('<input>', {
            type: "text",
            name: "username",
            id: "username",
            placeholder: "username"

  }));

  form.append($('<input>', {
            type: "text",
            name: "password",
            id: "password",
            placeholder: "new password"
          }));

//password change button
  form.append($('<input>',{
            type: "button",
            value: "Submit",
            click: function(){
              makeRequest('passwordchange');
              showButtons();
            },
            allign: "center",
            id: "qbbutton"
          }));

    //back button
  form.append($('<input>',{
          type: "button",
          value: "Back",
          id: "qbbutton",
          click: function(){
            showButtons();
          }
        }));

  //append form to div
  $("#passwordchange").append(form);

}

function changepassword(){
  if($("#passwordchange").html()=='') {
    queryUser();
  }
  hideButtons("passwordchange");
}

function showButtons(){
  $("#buttons").show();
  $("table").show();
  $("#passwordchange").toggle();
}

function hideButtons(str){
$("#buttons").hide();
$("#vat").hide();

  if(str=="passwordchange"){
    $("#passwordchange").toggle();
  }
}
    function updateTable(row_array, tbdy, index){
          var table = document.getElementById("table");
          var tr = document.createElement('tr');
          tr.setAttribute("id","specialtr");
          console.log(row_array);
            for (var j = 0; j < row_array.length-1; j++) {
              var td = document.createElement('td');
              console.log(td);
              td.appendChild(document.createTextNode(row_array[j]));
              td.setAttribute("id", "special");
              tr.appendChild(td);
              }

            tr.onclick= function(){
                console.log(index);
                selectTicket(index);
            }
            console.log(tbdy);
            tbdy.appendChild(tr);

     table.appendChild(tbdy);
      }

function selectTicket(index){
  // sortArray=info[index];
  selectedTicket=index;
  var table = $("table").hide();
  var vat = $("#vat").hide();
  var buttons = $("#buttons").hide();
  var selected = $('#selected');
  $("#select_options").show();

  selected.html('');
    var i;
    var temp_info = info[index].concat(body[index]);
    var temp_array= array.concat("body");



    for(i=0; i<temp_info.length; i++) {
      if(i!=7){
      selected.append(document.createTextNode(temp_array[i]+": "+temp_info[i]));
      selected.append('<br/>');
      }
      else{
        selected.append(document.createTextNode(temp_array[i]+": "+temp_info[i+1]));
        selected.append('<br/>');
        i++;
      }
    }

    $("#selectpage").show();
}



function logout(){
  makeRequest('logout');
  window.location='admin.php';
}

function sortByReceived(index){
  $("#vat").show();

//sort functions
function sortInt(a, b) {
     if (parseInt(a[index]) === parseInt(b[index])) {
         return 0;
     }
     else {
         return a[index] < b[index] ? -1 : 1;
     }
 }

 function sortString(a,b){
   return (a[index]).localeCompare(b[index]);
 }

  if(index==0){
    sortArray.sort(mySorting);
  }
  else{
    sortArray.sort(sortString);
  }
  var table = document.getElementById("table");
  var tbdy = document.getElementById("tbody");
  tbdy.innerHTML='';
  for (var i = 0; i < sortArray.length; i++) {
    updateTable(sortArray[i], tbdy,i);
  }
}


function mySorting(a,b) {
a = parseInt(a[0]);
b = parseInt(b[0]);
return a == b ? 0 : (a < b ? -1 : 1)
}

function viewMyTickets(){
var admin_name = $("#admin_name").val();
var tbdy = document.getElementById("tbody");
tbdy.innerHTML="";
sortArray= new Array();
  for(i=0; i<info.length; i++){
      //if()
      if(info[i][5]==admin_name){
        updateTable(info[i], tbdy,i);
        sortArray.push(info[i]);
      }
    }
    $('#vat').show();
    $("#table").show();
}

function viewUnassignedTickets(){
var tbdy = document.getElementById("tbody");
tbdy.innerHTML="";
sortArray= new Array();
  for(i=0; i<info.length; i++){
      //if()
      console.log(info[i][5]);
      if(info[i][5]=="" ||info[i][5]==" "){
        updateTable(info[i], tbdy,i);
        sortArray.push(info[i]);
      }
    }
  $("#vat").show();
  $("#table").show();
}

function viewalltickets() {
        //  //console.log(output);
         var tbdy = document.getElementById("tbody");

        tbdy.innerHTML='';
         for (var i = 0; i < info.length; i++) {
           updateTable(info[i], tbdy,i);
         }
        sortArray=info;
        $("#vat").show()
        $("#table").show();

    }

function toggle(){
  console.log(info[selectedTicket]);
  if(info[selectedTicket][6]=='open'){
    info[selectedTicket][6]='closed';
  }
  else{
    info[selectedTicket][6]='open';
  }
  ticketID=info[selectedTicket][0];
  selectTicket(selectedTicket);
  makeRequest('toggle');
}

function assignself(){
  ticketID=info[selectedTicket][0];
  makeRequest('assignself');

}

function text(){
  ticketID=info[selectedTicket][0];
  var selectpage = $("#selectpage");
  var emailform = $("#emailform");
  selectpage.toggle();
  if(emailform.html()==''){
    createForm('text');
  }
  else{
    $("#emailform").toggle();
    emailform.html('');
    createForm('text');
  }

  console.log(info[selectedTicket]);
}

function backToAdmin(){
  $("#selectpage").hide();
  console.log($("#buttons").html());
  $("#buttons").show();
  $("table").show();
}

function findSubmitterTickets(){

  $("#selectpage").hide();
  $("#buttons").show();
  var sender = info[selectedTicket][2];

  var tbdy = document.getElementById("tbody");
  tbdy.innerHTML="";
  sortArray= new Array();
    for(i=0; i<info.length; i++){
        //if()
        if(info[i][2]==sender){
          updateTable(info[i], tbdy,i);
          sortArray.push(info[i]);
        }
      }
    $("#vat").show();
    $("#table").show();
}

function deleteTicket(){
  ticketID=info[selectedTicket][0];
  info.splice(selectedTicket,1);
  body.splice(selectedTicket,1);

  makeRequest('deleteTicket');
  $("#selectpage").hide();
  $("#buttons").show();
  $("table").show();
}

function emailsubmitter(){
  ticketID=info[selectedTicket][0];
  var selectpage = $("#selectpage");
  var emailform = $("#emailform");
  selectpage.hide();
  if(emailform.html()==''){
  createForm();
  }
  else{
  emailform.toggle();
  }
}

var findHighest = function(topics, cap) {

    if (topics.length === 0)
        return null;
    var modeMap = {};
    var maxEl = topics[0],
        maxCount = 1;
    for (var i = 0; i < topics.length; i++) {
        {
            var el = topics[i];
            if (modeMap[el] === null)
                modeMap[el] = 1;
            else
                modeMap[el]++;
            }
        }

    var highFreq = new Set();

    //add valid elements to set and then return
    for (var i = 0; i < topics.length; i++) {
        var el = topics[i];
        if (modeMap[el] >= cap) {
            highFreq.add(el);
        }
    }
    return highFreq;

}

function back(){
  $("#emailform").hide();
  $("#selectpage").show();
}

function findlike(){
var subject = info[selectedTicket][4];
var temp_array = subject.split(" ");
$("#selectpage").hide();
$("#buttons").show();
var tbdy = document.getElementById("tbody");
tbdy.innerHTML="";
sortArray= new Array();
var i,j;
  for(i=0; i<info.length;i++){
    for(j=0;j<temp_array.length;j++){
      var str1= info[i][4].toLowerCase();
      var word= temp_array[j];
      if(str1.includes(word)){
        sortArray.push(info[i]);
        updateTable(info[i], tbdy,i);
        break;
      }
    }
  }

  $("#vat").show();
  $("#table").show();
}

</script>

<link rel="stylesheet" type="text/css" href="login.css" />
  <div id="buttons">
  <table id="options">
      <tr>
          <td><button id='viewalltickets' type='submit' onclick='viewalltickets()'>View All Tickets</button></td>
          <td><button id="viewtickets" type="submit" onclick="viewMyTickets()">View My Tickets</button></td>
          <td><button id="unassigned" type="submit" onclick="viewUnassignedTickets()">View Unassigned</button></td>
          <td><button id="changepassword" type="submit" onclick="changepassword()">Change Password</button><td>
          <td><button id="logout" type="submit" onclick="logout()">Logout</button><td>
      </tr>
  </table>
</div>
  <div id="passwordchange" style='display:none'></div>
  <div id="vatcheck" style='display:none';></div>
  <br />
  <div id="selectpage" style='display:none'>
  <div id="selected" ></div>
  <div id="select_buttons">
  <br />
  <table id="select_options">
      <tr>
          <td><button id='toggle' type='submit' onclick='toggle()'>Toggle Status</button></td>
          <td><button id="assignself" type="submit" onclick="assignself()">Toggle Assignment</button></td>
          <td><button id="emailsender" type="submit" onclick="emailsubmitter()">Email Sender</button></td>
          <td><button id="delete" type="submit" onclick="deleteTicket()">Delete Ticket</button></td>
      </tr>
      <tr>
          <td><button id="sendertickets" type="submit" onclick="findSubmitterTickets()">Tickets from Sender</button></td>
          <td><button id="findsimilar" type="submit" onclick="findlike()">Find Similar Tickets</button></td>
          <td><button id="text" type="submit" onclick="text()">Message Sender</button></td>
          <td><button id="backadmin" type="submit" onclick="backToAdmin()">Go Back to Admin</button></td>
      </tr>
  </table>
  </div>
</div>
</link>
  <div id="vat" style='display:none';>
    <table id="table" class='w3-table-all w3-hoverable'>
      <tr>
        <th onclick="sortByReceived(0)">Ticket #</th>
        <th onclick="sortByReceived(1)">Received</th>
        <th onclick="sortByReceived(2)">Sender Name</th>
        <th onclick="sortByReceived(3)">Sender Email</th>
        <th onclick="sortByReceived(4)">Subject</th>
        <th onclick="sortByReceived(5)">Tech</th>
        <th onclick="sortByReceived(6)">Status</th>
      </tr>
    </table>
  </div>

  <section>
<div id='emailform'></div>
  <input id="admin_name" value="<?php echo $_SESSION['admin_name']; ?>" style='display:none'>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</section>
</html>
