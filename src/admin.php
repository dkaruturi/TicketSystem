<?php
session_start();
include 'adminClass.php';

//retrieve username and password and check if they in the database
if (isset($_POST['validate']) && !empty($_POST['username']) && !empty($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $db = new mysqli('localhost', 'root', '', 'tickets');
    $query = "SELECT user_info, admin_id, type FROM admin WHERE username = '$username'";
    $results = $db->query($query);
    $row = $results->fetch_assoc();
    $admin_id = $row['admin_id'];
    $temp = unserialize($row['user_info'])->password;
    $val = password_verify($password, unserialize($row['user_info'])->password);
    if ($val) {
        $_SESSION['security'] = true;
//checks user type and redirects them to the correct page
    if ($row['type'] == 'admin') {
        $_SESSION['admin_id'] = $admin_id;
        $_SESSION['admin_name'] = unserialize($row['user_info'])->name;
        $_SESSION['admin_email'] = unserialize($row['user_info'])->email;
        $_SESSION['user_name'] = unserialize($row['user_info'])->name;

        header('Location: admin_user.php');
        exit;
    } else {
        $_SESSION['user_name'] = unserialize($row['user_info'])->name;
        $_SESSION['user_email'] = unserialize($row['user_info'])->email;
        $_SESSION['username'] = $username;
        header('Location: regular_user.php');
    }
    }
    else{
      $message = "This is the wrong username/password combination";
      echo "<script type='text/javascript'>alert('$val');</script>";
    }
}
?>
<html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>


function makeRequest(str) {
    var httpRequest;

    if (window.XMLHttpRequest) { // Mozilla, Safari, ...
        httpRequest = new XMLHttpRequest();

    if(str=='forgotpassword'){
      var username = $("#username").val();
      var email = $("#email").val();
    }

    if(str=='registeruser'){
      var new_username = $("#new_username").val();
      var new_name = $("#firstname").val()+" "+$("#lastname").val();
      var new_email= $("#new_email").val();
      var new_password = $("#new_password").val();


    }

      httpRequest.onreadystatechange = function() { alertContents(httpRequest, str); };
      httpRequest.open("GET","processUser.php?q="+str+"&username="+username+"&email="+email+"&new_name="+new_name+"&new_email="+new_email+"&new_password="+new_password+"&new_username="+new_username,true);
      httpRequest.send(null);

    }

}

function alertContents(httpRequest,str) {

    if (httpRequest.readyState == 4) {
        if (httpRequest.status == 200) {

          console.log(httpRequest.responseText);

        }
    }
  }

  function newUser(){
    var changepassword= $("#registerpage");
    changepassword.show();

    var form = $("<form/>", {
                action: '/POST',
                id: 'changeinfo'
            });

      //query username
      form.append(
                  $("<input>", {
                      type: 'text',
                      name: 'new_username',
                      id: 'new_username',
                      placeholder: 'username'
                  })
              );
      form.append('<br/>');
      //query first name
      form.append(
                  $("<input>", {
                      type: 'text',
                      name: 'firstname',
                      id: 'firstname',
                      placeholder: 'first name'
                  })
              );
      form.append('<br/>');
      //query last name
      form.append(
                  $("<input>", {
                      type: 'text',
                      name: 'lastname',
                      id: 'lastname',
                      placeholder: 'last name'
                  })
              );
      form.append('<br/>');
      //query email
      form.append(
                  $("<input>", {
                      type: 'text',
                      name: 'new_email',
                      id: 'new_email',
                      placeholder: 'Enter email here'
                  })
              );
      form.append('<br/>');
      //query password
      form.append(
                  $("<input>", {
                      type: 'password',
                      name: 'new_password',
                      id: 'new_password',
                      placeholder: 'Password'
                  })
              );
      form.append('<br/>');
      //check password
      form.append(
                  $("<input>", {
                      type: 'password',
                      name: 'confirmpassword',
                      id: 'confirmpassword',
                      placeholder: 'Confirm password'
                  })
              );
      form.append('<br/>');
      //submit button
      form.append( $('<input/>',
          {
              type: 'button',
              value: 'Submit',
              id: 'rbutton',
              click: function () {
                if($("#new_password").val()==$("#confirmpassword").val()){
                makeRequest('registeruser');
                rback();
                  }
                  else{
                    alert("Note: the passwords don't match");
                  }
            }}
          ));
          form.append('<br/>');

        //back button
          form.append( $('<input/>',
                {
                  type: 'button',
                  value: 'Back',
                  id: 'rbutton',
                  click: function () {
                    rback();
                    }
                  }
              ));

  changepassword.append(form);

  }

  function rback(){
    $("#registerpage").hide();
    $("#registerpage").html('');
    $('#login').show();
  }


  function queryUser(){

  var form = $("<form/>", {
              method: '/POST',
              id: 'changeinfo'
          });

  //query username
  form.append(
    $('<input>',{
      type: 'text',
      name: 'name',
      id: 'username',
      placeholder: 'username'
    }
  ));
  form.append('<br>');
  form.append('<br/>');

  //query for email
  form.append(
  $('<input>',{

      type: 'text',
      name: 'email',
      id: 'email',
      placeholder: 'Enter email here'
  }));
  form.append('<br>');
  form.append('<br/>');

//submit button
form.append(
  $('<input>', {
  type: 'button',
  value: 'Submit',
  allign: 'center',
  id: 'qbbutton',
  click: function(){
    makeRequest('forgotpassword');
    bback();
    alert("check your email");
  }
}));
form.append('<br>');

//back button
form.append(
  $('<input>', {
  type: 'button',
  value: 'Back',
  allign: 'center',
  id: 'qbbutton',
  click: function(){
    bback();
  }
}));


//add form to page
$('#forgotpage').append(form);
  }

  function bback(){
      $("#login").show();
      $("forgotpage").html('');
      $("#forgotpage").hide();
  }

function fpassword(){
    $("#login").hide();
    if($("#forgotpage").html()==""){
    queryUser();
  }

    $("#forgotpage").toggle();
}

function registerUser(){
  $("#login").hide();
  newUser();
}

</script>
<body>
<center><H2><font face="verdana" color="black"><b>Login Form</b></font></H2></center>


<link rel="stylesheet" type="text/css" href="login.css" />
<div id="login" class="login">
  <form action = "admin.php"
      method = "POST">
  <table>
      <tr>
          <td><label> Username </label></td>
          <td><input type="text" name = "username" size = "40" maxlength= "50" /></td>
      </tr>
      <tr>
          <td><label> Password </label></td>
          <td> <input type="password" name = "password" size = "40" maxlength= "50" /></td>
      </tr>
      <tr>
        <td colspan="2">  <center><input type="submit" name = "validate" value="Submit"/></center></td>
      </tr>
  </table>
</form>
<center>
<button id="forgotpassword" onclick="fpassword()"><u>Forgot Password</u></button>
<button id="register"  onclick="registerUser()"><u>Register User</u></button>
</center>
</div>
<div id="forgotpage" style="display:none";></div>
<div id="registerpage" style="display:none";>
</div>
</body>
</html>
