<?php
	class Auth{
		function __construct(){
			session_start();
		}
		function authenticate($this_url=''){
			if($_SESSION['uid']<1){
				header('location:./');
			}
			else
				return $_SESSION['uid'];
		}
		function create_session($userid){
			$_SESSION['uid']=$userid;
		}
		function get_id(){
			return intval($_SESSION['uid']);
		}
		function logout(){
			unset($_SESSION['uid']);
		}
	}
	$auth=new Auth();
?>