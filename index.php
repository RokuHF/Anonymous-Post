<?php

//An anonymous message board where the last 30 posts are displaye don the homepage.
// (c) Roku 2016


//Set your db info in Config.php!


include("config.php");
$link = new mysqli($dbHost, $dbUser, $dbPass, $dbDatabase);
function render_post() {
	echo "
	<html>
		<form action='?' method='post'>
		<input type='text' name='post'>
		<input type='submit'>
		</form> <br>

		".

		// CODE FOR SHOWING PREVIOUS POSTS
		$getPosts = "SELECT * FROM Posts";
		$x = 0;
		if($result = $link->query($getPosts)) {
			while($row = mysqli_fetch_assoc($result)) {
				foreach($row as $field) {
					$x = $x + 1;
					echo $field . "<br />";
					if($x > 29) { // If we've posted 30 posts, we can break the foreeach() statement. :)
						break;
					}
				}
			break;
			}
		} else {
			echo "An error occured while attempting to display the posts.";
		}


		."
	</html>
	";
}
if(!isset($_POST['post'])) {
	render_post();
} else {
	
	$post = $_POST['post'];
	
	$time = gmdate('Y-m-d H:i:s', time());

	// Inserts the post, along with the time the script was run, into the database and table set in config.php.

	if($result = $link->query("INSERT INTO ". $dbTable ." (Time, Post) VALUES ('". $time."',". $post .")")) {
		echo "Comment posted successfully.<br />";
		echo render_post();
	}
}
die();
?>