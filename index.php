<?php

    //session_start();

    $error = "";
    $successMessage = "";
    $login = $_POST["email"];
    $password = $_POST["password"];

    if($_POST)
    {
      $link = mysqli_connect("shareddb-h.hosting.stackcp.net", "secretdi-33331e1f", "12345ABCDEF", "secretdi-33331e1f");

      if(mysqli_connect_error()){
        die("Database connection error");
      }

      $error = "";
  
      if(!$login)
      {
        $error.=" An email address is required. <br>";
      }
      if(!$password)
      {
        $error.=" Invalid password <br>";
      }
  
      if ($login && filter_var($login, FILTER_VALIDATE_EMAIL) == false) {
        $error.=" The email address is invalid. <br>"; 
      }
  
      if($error != ""){
  
       $error= '<div class="alert alert-danger" role="alert"><strong>There were error(s) in your form:'
         . $error . '</strong> Change a few things up and try submitting again.</div>';
  
      } else {
          $query = "SELECT id FROM `users` WHERE email = '".mysqli_real_escape_string($_POST["email"])."' LIMIT 1";
          $result = mysqli_query($link, $query);
          
          if(mysqli_num_rows($result) > 0){
            $error .= "That email address is taken.";
          }

          else{
            $query = " INSERT INTO `users` (`email`, `password`) VALUES ('".mysqli_real_escape_string($_POST['email'])."', '".mysqli_real_escape_string($_POST['password'])."')";
            if(!mysqli_query($link,$query)){
              $error = "<p>Could not sign you up - please try again later </p>";
            }
            else{
              echo "signup successfull";
              header("location:login.php");
              exit();
            }
          }  
      }
    }
    

    if($_POST["remember_me"]=='1' || $_POST["remember_me"]=='on')
    {
      $hour = time() + 3600 * 24 * 30;
      setcookie('email', $login, $hour);
      setcookie('password', $password, $hour);
    }
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
</head>
<body>
<!-- Login -->
<div class="container">
    <form method= "post">
    <div id = "error">
          <? echo $error.$successMessage; ?>
    </div>
    <div class="row">
		<div class="span12">
			<form class="form-horizontal" action='' method="POST">
			  <fieldset>
			    <div id="legend">
			      <legend class="">Login</legend>
			    </div>
			    <div class="control-group">
			      <!-- Username -->
			      <label class="control-label"  for="email">Email</label>
			      <div class="controls">
			        <input type="text" id="email" name="email" placeholder="" class="input-xlarge">
			      </div>
			    </div>
			    <div class="control-group">
			      <!-- Password-->
			      <label class="control-label" for="password">Password</label>
			      <div class="controls">
			        <input type="password" id="password" name="password" placeholder="" class="input-xlarge">
			      </div>
			    </div>
			    <div class="control-group">
            <!-- Remeber me check box -->
            <div class="checkbox">
              <label><input type="checkbox" name = "remember_me" id = "remember_me"> Remember me</label>
            </div>
			      <!-- Button -->
			      <div class="controls">
			        <button class="btn btn-success">Login</button>
			      </div>
			    </div>
			  </fieldset>
			</form>
		</div>
	</div>
</div>    
<!-- Sign up -->
<div class="container">
    <form method= "post">
    <div id = "error">
          <? echo $error.$successMessage; ?>
    </div>
    <div class="row">
		<div class="span12">
			<form class="form-horizontal" action='' method="POST">
			  <fieldset>
			    <div id="legend">
			      <legend class="">Sign up</legend>
			    </div>
			    <div class="control-group">
			      <!-- Username -->
			      <label class="control-label"  for="email">Email</label>
			      <div class="controls">
			        <input type="text" id="email" name="email" placeholder="" class="input-xlarge">
			      </div>
			    </div>
			    <div class="control-group">
			      <!-- Password-->
			      <label class="control-label" for="password">Password</label>
			      <div class="controls">
			        <input type="password" id="password" name="password" placeholder="" class="input-xlarge">
			      </div>
			    </div>
			    <div class="control-group">
            <!-- Remeber me check box -->
            <div class="checkbox">
              <label><input type="checkbox" name = "remember_me" id = "remember_me"> Remember me</label>
            </div>
			      <!-- Button -->
			      <div class="controls">
			        <button class="btn btn-success">Sign up!</button>
			      </div>
			    </div>
			  </fieldset>
			</form>
		</div>
	</div>
</div>    
</body>

<script type = "text/javascript">


        $("form").submit(function (e){
            

            var error = "";

            if($("#email").val() == ""){

                error+="<p>The email field is required.</p>";
            }

            if(error != ""){

              $("#error").html('<div class="alert alert-danger" role="alert"><strong>There were error(s) in your form:'
               + error+ '</strong> Change a few things up and try submitting again.</div>');
              
              return false;
            }
            else
            {
              return true;
            }
        });
    
</script>
</html>


