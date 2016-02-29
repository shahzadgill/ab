<?php
	class Contacts extends Database{
		function __construct(){
			parent::__construct();
		}

		function createCity($name){
        $check_result=$this->make_query("select * from cities where name='$name'");
        $check_row=$this->fetch($check_result);
        if($check_row){
            return $check_row['id'];
        }
        else{
            $this->make_query("insert into cities(name) values('$name')");
            return $this->last_id();
        }
	    }
	    function createIndustry($name){
	        $check_result=$this->make_query("select * from industries where name='$name'");
	        $check_row=$this->fetch($check_result);
	        if($check_row){
	            return $check_row['id'];
	        }
	        else{
	            $this->make_query("insert into industries(name) values('$name')");
	            return $this->last_id();
	        }
	    }

	    function createContact($business_name,$name,$address,$phone,$cell,$industry_id,$city_id){
        $check_result=$this->make_query("select * from contacts where city_id=$city_id and industry_id=$industry_id and business_name='$business_name' and phone='$phone'");
        $check_row=mysqli_fetch_array($check_result);
	        if(!$check_row){
	            $d=date('Y-m-d');
	            $this->make_query("insert into contacts (industry_id,city_id,name,business_name,address,phone,cell,date_added) values($industry_id,$city_id,'$name','$business_name','$address','$phone','$cell','$d')");
	            return $this->last_id();
	        }
	        else{
	            return 0;
	        }
    	}

	}
	$c = new Contacts();
?>