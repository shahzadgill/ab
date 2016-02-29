<?php
include("includes/config.php");
include("paging-class.php"); 
include("includes/classes/database.php"); 
include("includes/classes/auth.php"); 
include("includes/classes/contacts.php"); 
include("includes/functions.php"); 

    //$auth->authenticate();
      
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
		  if(strlen($cell)==10 && substr($cell,0,1)!="0") $cell="0".$cell;
		  
		  if(strlen($cell)!=11) $cell='';
          $industry=$row[5];
          $city=ucfirst($row[6]);
          
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
    <!--<script src="js/jquery-1.7.1.min.js"></script>-->
    <script src="js/jquery.js"></script>
    <script language="javascript">
    function show(){
      $("#csvf").trigger('click');
    }

    function upload(){
      //alert('here');
      $("#csvfrm").submit();
    }

    function del(id){
      //alert(id);
      if(confirm(('Delete ?'))){
        var f=document.addressfrm;
        f.add_id.value=id;
        f.submit();
      }
      return false;
    }
    </script>
    <style>
      .pageNo{
      padding:3px;
      margin-left:2px;
      color:#666;
      border:solid 1px #000;
      background:#FFF;
    }
    .pageNo:hover{
      color:#999;
      border:solid 1px #999;
      text-decoration:none;
    }
    .disabledPageNo{
      border:solid 1px #999;
      background:#ddd;
      padding:3px;
      margin-left:2px;
      color:#aaa;
    }
    .pagingBar{
      border:solid 1px #ccc;
      background:#ebebeb;
      padding:5px;
      margin-top:5px;
    }
    </style>
</head>
<body style="background:url(images/black_bg.png)">
    <div class="container" style="">
    <div class="col-md-10 col-md-offset-1" style="background-color:#fff; "> 
        <?php include("includes/header.php"); ?>

        <div class="row" style="background-color:#eef; padding:0 10px 5px 10px; border-bottom:2px solid #ddd">
            <div>
                <form role="form" class="form-inline" method="get" id="contact_details">
                    <div class="form-group">
                        <label for="industry"></label>
                        <?php echo render_industries('industry_id','txt1 form-control industry_id',$_REQUEST['industry_id'])?>
                        <span class="help-block" style="padding:0 0 0 7px ">e.g. Construction</span>
                    </div>
                    <div class="form-group">
                        <label for="city"></label>
                        <?php echo render_cities('city_id','txt1 form-control city_id',$_REQUEST['city_id'])?>
                        <span class="help-block">e.g. Sargodha</span>
                    </div>
                    <div style="display:inline-block; vertical-align:top"><input type="submit" class="btn btn-success" name="search" value="SEARCH"></div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="table-responsive">
                <table id="" class="table table-striped" width="100%" cellpadding="4px" style="margin:23px 0 0 0">
                  <tr>
                      <th>Id</th>
                      <th>Industry</th>
                      <th>Total Contacts</th>
                      <th>&nbsp;</th>
                  </tr>   
                  <?php
				  		$result=$db->make_query("SELECT i.id,i.name,count(*) as total FROM `contacts` c,industries i WHERE c.industry_id=i.id group by c.industry_id");
				  ?>
                    <?php while($row=mysqli_fetch_array($result)){ ?>
                    <tr>
                        <td><?php echo $row['id'] ?></td>
                        <td><?php echo $row['name'] ?></td>
                        <td><?php echo $row['total'] ?></td>
                        <td><a href="./?industry_id=<?php echo $row['id']?>&search=SEARCH">View Contacts</a></td>
                    </tr>  
                    <?php
                      }
                    ?>  
                </table>
            </div>
        </div>


        <div class="row" >
          <div style="background-color:#eef; border-bottom:10px solid #36424a; margin:20px 0 0 0; padding:15px 0 5px 0">
            <p class="text-center"><small>Developed By: Akvon</small></p>
          </div>
        </div>


        <form name="csvfrm" id="csvfrm" method="post" enctype="multipart/form-data">
          <input  id="csvf" type="file" name="csvf" style="display:none" onchange="upload()">
          <input type="hidden" name="cmd" id="cmd" value="upload_csv"> 
          <!--<input type="submit" name="submit" value="submit" style="" > -->  
        </form>

        <form name="addressfrm" id="addressfrm" method="post">
          <input type="hidden" name="add_id" id="add_id"> 
          <input type="hidden" name="cmd" id="cmd" value="delete"> 
          <!--<input type="submit" name="submit" value="submit" style="" > -->  
        </form>
  </div>

   <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add New Contact</h4>
      </div>
      <div class="modal-body">
       <form method="post">
          <div class="form-group required">
            <div class="row">
                <div class="col-md-4"><label for="career_id">Business Person:</label></div>
                <div class="col-md-8"> <input type="text" name="business_person" class="form-control business_person" id="business_person" placeholder="Business Person" required></div>
            </div>
          </div>
          <div class="form-group required">
            <div class="row">
                <div class="col-md-4"><label for="career_id">Industry:</label></div>
                <div class="col-md-8"> <input type="text" name="industry" class="form-control industry" id="industry" placeholder="Industry" required></div>
            </div>
          </div>
          <div class="form-group required">
            <div class="row">
                <div class="col-md-4"><label for="career_id">City Name:</label></div>
                <div class="col-md-8"> <input type="text" name="city_name" class="form-control city_name" id="city_name" placeholder="City Name" required></div>
            </div>
          </div>
          <div class="form-group required">
            <div class="row">
                <div class="col-md-4"><label for="career_id">Business Name:</label></div>
                <div class="col-md-8"> <input type="text" name="business_name" class="form-control business_name" id="business_name" placeholder="Business Name" required></div>
            </div>
          </div>
          <div class="form-group required">
            <div class="row">
                <div class="col-md-4"><label for="career_id">Address:</label></div>
                <div class="col-md-8"> <input type="text" name="address" class="form-control address" id="address" placeholder="Address" required></div>
            </div>
          </div>
          <div class="form-group required">
            <div class="row">
                <div class="col-md-4"><label for="career_id">Phone No:</label></div>
                <div class="col-md-8"> <input type="text" name="phone" class="form-control phone" id="phone" placeholder="Phone Number" required></div>
            </div>
          </div>
          <div class="form-group required">
            <div class="row">
                <div class="col-md-4"><label for="career_id">Cell No:</label></div>
                <div class="col-md-8"> <input type="text" name="cell" class="form-control cell" id="cell" placeholder="Cell Number" required></div>
            </div>
          </div>

          <div class="form-group required">
              <div class="row">
                  <div class="col-md-4"><label for="career_id">&nbsp;</label></div>
                  <div class="col-md-8"> <input type="submit" name="create_contact" class="btn btn-info" value="Create Contact"></div>
              </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  </div>



<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<?php if ($count>0):?>
  <script>
    alert(count+' Records have been added')
  </script>
<?php endif; ?>
</body>
</html>

