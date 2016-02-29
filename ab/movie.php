<?php
include("includes/config.php");
include("includes/classes/database.php"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>My Address Book</title>
    <script> var base_url = '<?php echo BASE_URL ?>';</script>
    <script> var count = '<?php echo $count ?>';</script> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <link href='http://fonts.googleapis.com/css?family=Archivo+Narrow' rel='stylesheet' type='text/css'>
    <script src="js/jquery.js"></script>
</head>
<body style="background:url(images/black_bg.png)">
    <div class="container" style="">
    <div class="col-md-10 col-md-offset-1" style="background-color:#fff; "> 


        <div class="row" style="background-color:#eef; padding:0 10px 5px 10px">
            <div class="col-md-7" style="padding:10px 0 10px 3px;">
                <div class="pull-left">
                  <img src="<?php echo BASE_URL ?>/images/address.png" width="61px" height="61px">
                </div>  
                <div class="pull-left">
                    <span style="font-size:2.5em; padding:0 0 0 0; line-height:1.2em; color:#36424a; font-family: 'Archivo Narrow', sans-serif;">My Address Book</span><br>
                    <span style="font-size:1.2em; padding:0 0 0 3px; color:#70797F; letter-spacing:.356em;">AddressBook Is Better For Faculty</span>
                </div>
            </div>
            <div class="col-md-5" style="padding:10px 0 0 0">
                <div class="pull-right" style="padding:15px 0 0 0;">
                    <div class="pull-left"><button type="button" class="btn btn-primary" onclick="show()">Import</button></div>
                    <div class="pull-left" style="padding:0 0 0 10px"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Contact</button></div>
                </div>
            </div>
        </div>
        

        <div class="row" style="background-color:#eef; padding:0 10px 5px 10px; border-bottom:2px solid #ddd">
           
        </div>

        
       
        <div class="row" >
          <div style="background-color:#eef; border-bottom:10px solid #36424a; margin:20px 0 0 0; padding:15px 0 5px 0">
            <p class="text-center"><small>Developed By: Akvon</small></p>
          </div>
        </div>
  </div>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>

