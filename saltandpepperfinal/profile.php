<?php

	include("classes/autoload.php");

	$login = new Login();
	$_SESSION['mybook_userid'] = isset($_SESSION['mybook_userid']) ? $_SESSION['mybook_userid'] : 0;
	
	$user_data = $login->check_login($_SESSION['mybook_userid'],false);
 
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

		include("change_image.php");
		
		if(isset($_POST['first_name'])){

			$settings_class = new Settings();
			$settings_class->save_settings($_POST,$_SESSION['mybook_userid']);

		}else{

			$post = new Post();
			$id = $_SESSION['mybook_userid'];
			$result = $post->create_post($id, $_POST,$_FILES);
			
			if($result == "")
			{
				header("Location: profile.php");
				die;
			}else
			{

				echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey;'>";
				echo "<br>The following errors occured:<br><br>";
				echo $result;
				echo "</div>";
			}
		}
			
	}

	//collect posts
	$post = new Post();
	$id = $user_data['userid'];
	
	$posts = $post->get_posts($id);

	//collect friends
	$user = new User();
 	
	$friends = $user->get_following($user_data['userid'],"user");

	$image_class = new Image();

	//check if this is from a notification
	if(isset($_GET['notif'])){
		notification_seen($_GET['notif']);
	}

?>

<!DOCTYPE html>
	<html>
	<head>
		<title>Salt&Pepper|Profile</title>
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


		#textbox{

			width: 100%;
			height: 20px;
			border-radius: 5px;
			border:none;
			padding: 4px;
			font-size: 14px;
			border: solid thin grey;
			margin:10px;
 
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

			background-color: white;
			min-height: 400px;
			margin-top: 20px;
			color: #aaa;
			padding: 8px;
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

		}

		#post_button{

			float: right;
			background-color: #405d9b;
			border:none;
			color: white;
			padding: 4px;
			font-size: 14px;
			border-radius: 2px;
			width: 50px;
			min-width: 50px;
			cursor: pointer;
		}
 
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

	</style>

	<body style="font-family: tahoma; background-color: whitesmoke;">

		<?php include("header.php"); ?>
 
 		<!--change profile image area-->
 		<div id="change_profile_image" style="display:none;position:absolute;width: 100%;height: 100%;background-color: #000000aa;">
 			<div style="max-width:600px;margin:auto;min-height: 400px;flex:2.5;padding: 20px;padding-right: 0px;">
 					
 					<form method="post" action="profile.php?change=profile" enctype="multipart/form-data">
	 					<div style="border:solid thin #aaa; padding: 10px;background-color: white;">

	 						<input type="file" name="file"><br>
	 						<input id="post_button" type="submit" style="width:120px;" value="Change">
	 						<br>
							<div style="text-align: center;">
								<br><br>
							<?php

								echo "<img src='$user_data[profile_image]' style='max-width:500px;' >";
  
	 						?>
							</div>
	 					</div>
  					</form>

 				</div>
 		</div>
		
	

		<!--cover area-->
		<div style="width: 800px;margin:auto;min-height: 400px; background-color:whitesmoke;">
			
			<div style="background-color: white;text-align: center;color: #405d9b; height:250px; display:flex;">

				<div class="userpicturebox" style="width:40%; display:flex; align-items:center; justify-content:center;">
				<span style="font-size: 12px;">
					<?php 

						$image = "images/user_male.jpg";
						if($user_data['gender'] == "Female")
						{
							$image = "images/user_female.jpg";
						}
						if(file_exists($user_data['profile_image']))
						{
							$image = $image_class->get_thumb_profile($user_data['profile_image']);
						}
					?>

					<img id="profile_pic" src="<?php echo $image ?>"><br/>

					<?php if(i_own_content($user_data)):?>
					
						<a onclick="show_change_profile_image(event)" style="text-decoration: none;color:black;" href="change_profile_image.php?change=profile">Change Profile Image</a> 
					
					<?php endif; ?>

				</span>
				</div>
				

			
				<br>
					<div style="width:100%; font-size: 20px;color: black; display:flex; flex-flow:column; justify-content:center;">
					
					<!--row1-->
					<div style="display:flex; flex-flow:row; width:100%; height:33.33%; justify-content:flex-start; align-items:flex-end;">
					<span style="font-size:20px; margin-right:30px;">@<?=$user_data['tag_name']?></span>
					
					<a href="like.php?type=user&id=<?php echo $user_data['userid'] ?>">
							<input id="post_button" type="button" value="Follow" style="margin-left:50px;background-color:none; border:1px solid black; width:10px;">
						</a>

						<?php 
					if($user_data['userid'] == $_SESSION['mybook_userid']){
						echo '<a href="profile.php?section=settings&id='.$user_data['userid'].'"><div style="margin-left:10px; font-size:15px; color:black; border:1px solid black; " id="menu_buttons">Edit Profile</div></a>';
					}
				?>
					</div>
					<!--row1-->
					

					<?php 
							$mylikes = "";
							if($user_data['likes'] > 0){

								$mylikes = "(" . $user_data['likes'] . " Followers)";
							}
						?>
					<!--row2-->	
					<div style="display:flex; flex-flow:row; width:100%; height:33.33%; justify-content:flex-start; align-items:center;">
					<?php echo $mylikes ?>
					<a style="color:black; "; href="profile.php?section=followers&id=<?php echo $user_data['userid'] ?>"><div id="menu_buttons">Followers</div></a>
					<a style="color:black; href="profile.php?section=following&id=<?php echo $user_data['userid'] ?>"><div id="menu_buttons">Following</div></a>

					</div>
					<!--row2-->
					
					<!--row3-->
					<div style="display:flex; flex-flow:row; width:100%; height:33.33%; justify-content:flex-start; align-items:flex-start;">
					<a style="color:black; font-size:15px; text-decoration:none;" href="profile.php?id=<?php echo $user_data['userid'] ?>">
							<?php echo $user_data['first_name'] . " " . $user_data['last_name']  ?>
							<a  style="color:black; font-size:15px; href="profile.php?section=photos&id<?php echo $user_data['userid'] ?>"><div  id="menu_buttons">Photos</div></a>
							
						</a>
					</div>
					<!--row3-->	

					
				
				
				
					</div>
				<br>


				
			</div>
			


			<!--below cover area-->
	 
	 		<?php 

	 			$section = "default";
	 			if(isset($_GET['section'])){

	 				$section = $_GET['section'];
	 			}

	 			if($section == "default"){

	 				include("profile_content_default.php");
	 			 
	 			}elseif($section == "following"){
	 				
	 				include("profile_content_following.php");

	 			}elseif($section == "followers"){

	 				include("profile_content_followers.php");

	 			

	 			}elseif($section == "settings"){

	 				include("profile_content_settings.php");

	 			}elseif($section == "photos"){

	 				include("profile_content_photos.php");
	 			}



	 		?>

		</div>

	</body>
</html>

<script type="text/javascript">
	
	function show_change_profile_image(event){

		event.preventDefault();
		var profile_image = document.getElementById("change_profile_image");
		profile_image.style.display = "block";
	}


	function hide_change_profile_image(){

		var profile_image = document.getElementById("change_profile_image");
		profile_image.style.display = "none";
	}

	
	function show_change_cover_image(event){

		event.preventDefault();
		var cover_image = document.getElementById("change_cover_image");
		cover_image.style.display = "block";
	}


	function hide_change_cover_image(){

		var cover_image = document.getElementById("change_cover_image");
		cover_image.style.display = "none";
	}


	window.onkeydown = function(key){

		if(key.keyCode == 27){

			//esc key was pressed
			hide_change_profile_image();
			hide_change_cover_image();
		}
	}

	
</script>