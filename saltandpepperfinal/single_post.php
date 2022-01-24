<?php 

	include("classes/autoload.php");
 
	$login = new Login();
	$user_data = $login->check_login($_SESSION['mybook_userid']);
 
 	$USER = $user_data;
 	
 	if(isset($_GET['id']) && is_numeric($_GET['id'])){

	 	$profile = new Profile();
	 	$profile_data = $profile->get_profile($_GET['id']);

	 	if(is_array($profile_data)){
	 		$user_data = $profile_data[0];
	 	}

 	}
 	
	//posting starts here
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
 
			$post = new Post();
			$id = $_SESSION['mybook_userid'];
			$result = $post->create_post($id, $_POST,$_FILES);
			
			if($result == "")
			{
				header("Location: single_post.php?id=$_GET[id]");
				die;
			}else
			{

				echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey;'>";
				echo "<br>The following errors occured:<br><br>";
				echo $result;
				echo "</div>";
			}
 			
	}

	$Post = new Post();
	$ROW = false;

	$ERROR = "";
	if(isset($_GET['id'])){

		$ROW = $Post->get_one_post($_GET['id']);
	}else{

		$ERROR = "No post was found!";
	}
 
?>

<!DOCTYPE html>
	<html>
	<head>
	<title>Salt & Pepper | Post</title>
		<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	</head>

	<style type="text/css">
		
		@import url('https://fonts.googleapis.com/css2?family=Amatic+SC:wght@700&display=swap');
		
		#blue_bar{

			height: 50px;
			background-color: white;
			color: black;

		}

		#search_box{

			width: 350px;
			height: 25px;
			border-radius: 5px;
			border:none;
			padding: 2px;
			font-size: 14px;
			background-image: url(search.png);
			background-repeat: no-repeat;
			background-position: right;
			margin-left: 65px;
			background-color: #ccc;

		}

		::placeholder {
			color: black;
		}

		#profile_pic{

			width: 150px;
			border-radius: 50%;
			border:solid 2px white;
		}

		#menu_buttons{

			width: 100px;
			display: inline-block;
			margin:2px;
		}

		#friends_img{

			width: 75px;
			float: left;
			margin:8px;

		}

		#friends_bar{

			min-height: 400px;
			margin-top: 20px;
			padding: 8px;
			text-align: center;
			font-size: 20px;
			color: #405d9b;
		}

		#friends{

		 	clear: both;
		 	font-size: 12px;
		 	font-weight: bold;
		 	color: #405d9b;
		}

		textarea{

			width: 100%;
			border:none;
			font-family: tahoma;
			font-size: 14px;
			height: 60px;
			resize: none;
		}

/*post button */
		#post_button{
			float: right;
			background-color: white;
			border: 1px solid black;
			color: black;
			padding: 4px;
			font-size: 14px;
			border-radius: 2px;
			width: 50px;
			cursor: pointer;
		}
		#post_button:hover{
			background-color: black;
			color: white;
			border: 1px solid white;
		}
/*postbuttonend */
 
 		#post_bar{

 			margin-top: 20px;
 			background-color: white;
 			padding: 10px;
 		}

 		#post{

 			padding: 4px;
 			font-size: 13px;
 			display: flex;
 			margin-bottom: 20px;
 		}
		 		/*header dropdown*/
		.dropbtn {
  			cursor: pointer;
		}
		.dropdown {
			float: right;
		}
		.dropdown-content {
  			display: none;
  			position: absolute;
  			background-color: #f9f9f9;
			font-size: 20px;
			font-family: 'Amatic SC', cursive;
			margin-top: 37px;
  			min-width: 160px;
  			box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  			z-index: 1;
		}
		.dropdown-content a {
  			color: black;
  			padding: 12px 16px;
  			text-decoration: none;
  			display: block;
		}
		.dropdown-content a:hover {
			background-color: #f1f1f1
		}
		.dropdown:hover .dropdown-content {
  		display: block;
		}
		.dropdown:hover .dropbtn {
  		background-color: #3e8e41;
		}
		hr.rounded {
  			border-top: 1px solid #bbb;
  			border-radius: 5px;
			width: 85%;
		}

	</style>

	<body style="font-family: 'Amatic SC', cursive; background-color: white;">
		<?php include("header.php"); ?>

		<!--cover area-->
		<div style="width: 800px;margin:auto;min-height: 400px;">
		 
			<!--below cover area-->
			<div style="display: flex;">	

				<!--posts area-->
 				<div style="min-height: 400px;flex:2.5;padding: 20px;padding-right: 0px;">
 					
 					<div style="border:solid thin #aaa; padding: 10px;background-color: white;">

  					 <?php 
  					 		//check if this is from a notification
  					 		if(isset($_GET['notif'])){
  					 			notification_seen($_GET['notif']);
  					 		}

  					 		$user = new User();
  					 		$image_class = new Image();

  					 		if(is_array($ROW)){

 	 					 		$ROW_USER = $user->get_user($ROW['userid']);
  					 			
  					 			if($ROW['parent'] == 0){
  					 				include("post.php");
  					 			}else{
  					 				$COMMENT = $ROW;
  					 				include("comment.php");
  					 			}
  					 		}

  					 ?>
  					 <?php if($ROW['parent'] == 0): ?>

	  					 <br style="clear: both;">

	  					 <div style="border:solid thin #aaa; padding: 10px;background-color: white;">

	 						<form method="post" enctype="multipart/form-data">

		 						<textarea name="post" placeholder="Post a comment"></textarea>
		 						<input type="hidden" name="parent" value="<?php echo $ROW['postid'] ?>">
		 						<input type="file" name="file">
		 						<input id="post_button" type="submit" value="Post">
		 						<br>
	 						</form>
	 					</div>

 					 <?php else: ?>
 					 	<a href="single_post.php?id=<?php echo $ROW['parent'] ?>" >
 					 		<input id="post_button" style="width:auto;float: left;cursor: pointer;" type="button" value="Back to main post" />
 					 	</a>
 					 <?php endif; ?>

 						<?php 
 
 							$comments = $Post->get_comments($ROW['postid']);

 							if(is_array($comments)){

 								foreach ($comments as $COMMENT) {
 									# code...
 									$ROW_USER = $user->get_user($COMMENT['userid']);
 									include("comment.php");
 								}
 							}

 							//get current url
 							$pg = pagination_link();
 						?>
 					</div>
  

 				</div>
			</div>

		</div>

	</body>
</html>