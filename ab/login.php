<?php
include("includes/config.php");
include("paging-class.php"); 
include("includes/classes/database.php"); 
include("includes/classes/auth.php"); 
include("includes/classes/contacts.php"); 
include("includes/functions.php"); 

    $uid = $auth->get_id();
    if ($uid>0) {
      header('Location: index.php');
    }
      
    
    $count=0;
    $d = 0;
    if (isset($_POST['create_contact'])) {
      extract($_POST);
      $industry_id=$c->createIndustry($industry);
      $city_id=$c->createCity($city_name);
      $x=$c->createContact($business_name,$business_person,$address,$phone,$cell,$industry_id,$city_id);
      if($x>0){
        $count++;
      }

    }

    if ($_POST['cmd']=='upload_csv') {
      $file = $_FILES['csvf']['tmp_name'];
      //die($file);
      $ptr=fopen($file,"r");
      while( ($row=fgetcsv($ptr))!=NULL){
        
        if(count($row)==7){
        
          $business_name=$row[0];
          $name=$row[1];
          $address=$row[2];
          $phone=$row[3];
          $cell=$row[4];
          $industry=$row[5];
          $city=$row[6];
          
          $industry_id=$c->createIndustry($industry);
          $city_id=$c->createCity($city);
          $x=$c->createContact($business_name,$name,$address,$phone,$cell,$industry_id,$city_id);
          if($x>0){
            $count++;
            //die("c=".$count);
          }
          
        }
      }
      fclose($ptr);
    }

    if ($_POST['cmd']=='delete') {
      extract($_POST);
      if ($add_id>0) {
        $result=$db->make_query("delete from contacts where id=$add_id ");
        if ($result) {
          $d++;
        }
      }
    }

    $where = 1;

  $results_per_page=60;
  $pg_query="select * from contacts";
  $query=$pg_query." where ".$where;
  $pg=new Paging($pg_query,$results_per_page);
  $start=$pg->get_start();
  $query=$pg_query." limit $start,$results_per_page";
  if (isset($_POST['search'])) {
        extract($_POST);
        if ($city_id>0) {
            $where.= " and city_id=".$city_id;
        }
        if ($industry_id>0) {
            $where.= " and industry_id=".$industry_id;
        }
        $query=$pg_query." where ".$where;
    }
    $result=$db->make_query($query);
    //die($query);
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <link href='http://fonts.googleapis.com/css?family=Archivo+Narrow' rel='stylesheet' type='text/css'>
    <script src="js/jquery.js"></script>
</head>
<body style="background:url(images/black_bg.png)">
    <div class="container" style="">
    <div class="col-md-10 col-md-offset-1" style="background-color:#fff; "> 
      <!--<h1>Login Page</h1>-->

        
    </div>
    </div>



<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>

