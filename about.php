<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Do you want to work in a company that not only pays you well but also helps you grow. Well, welcome to SpeedX - the best IT and tech company in the universe">
        <meta name="keywords" content="HTML5, tags">
        <meta name="author" content="a group of students">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Exo+2">

        <link href="styles/common_styles.css" rel="stylesheet">
        <link href="styles/about_styles.css" rel="stylesheet">

        <title>About Us</title>
    </head>
	<body id ="about-body">
		<?php include("header.inc") ?>

		<main>

			<h2 id="Our-tutor">Our tutor: Vu Ngoc Binh</h2> <!--Our tutor's name-->
			<!--Students id here-->
			<section id="about-student-section">
				<p id="our-class">Class COS10026.2 - Friday 2pm</p> <!--Our tutor's name-->

				<ul>
					<li class = "about-student-id">
					<ul>
						<li>Trinh Thai Anh Tuan</li>
						<li>ID: SWH03039</li>
					</ul>
					</li>
					
					<li class = "about-student-id">
					<ul>
						<li>Vu Hoang Long</li>
						<li>ID: SWH03135</li>
					</ul>
					</li>
					
					<li class = "about-student-id">
					<ul>
						<li>Duong Tri Duc</li>
						<li>ID: SWH02992</li>
					</ul>
					</li>        
					
					<li class = "about-student-id">
					<ul>
						<li>Dang Thien An</li>
						<li>ID: SWH03458</li>
					</ul>
					</li>
				</ul>

			</section>
			<!-- Our particular responsibilities -->
			<h2 id="about-Group7-member-contribution">Members' Contributions</h2>
			<section id="Members-contributions">
				<figure id="about-figure-group">
					<img id="group-image" src="images/group-image.jpg" alt="Group 7 photo">
					<figcaption>Our group photo</figcaption>
				</figure>

				<dl id="contributions-details">
					<dt>Trinh Thai Anh Tuan</dt>
					<dd>Shared Responsibility: Home Page, CSS File</dd>
					<dd>Individual Responsibility: About Us page (about.php)</dd>

					<dt>Vu Hoang Long</dt>
					<dd>Shared Responsibility: Home Page, CSS File</dd>
					<dd>Individual Responsibility: Job Positions page (jobs.php)</dd>

					<dt>Duong Tri Duc</dt>
					<dd>Shared Responsibility: Home Page, CSS File</dd>
					<dd>Individual Responsibility: Job Applications page, some job positions' descriptions</dd>
					<dd>Question Poster</dd>

					<dt>Dang Thien An</dt>
					<dd>Shared Responsibility: Home Page, CSS File</dd>
					<dd>Question Poster</dd>
				</dl>
			</section>



			<!--Our interest table-->
			<table class="about-table">
			<caption>Our team's interests</caption>
			<tr>
				<th>Member</th>
				<th colspan="2">Books</th>
				<th>Music</th>
				<th>Films</th>
				<th colspan="2">Games</th>
			</tr>
			<tr>
				<td >Trinh Thai Anh Tuan</td>
				<td >Harry Potter</td>
				<td >Thinking, Fast and Slow</td>
				<td >J-rock</td>
				<td >The Lord of the Rings</td>
				<td >ELden Ring</td>
				<td >Roblox</td>
			</tr>
			<tr>
				<td  >Vu Hoang Long</td>
				<td >Harry Potter</td>
				<td >LIFE 3.0</td>
				<td >J-pop</td>
				<td >Breaking bad</td>
				<td >Expedition 33</td>
				<td >Outer Wilds</td>
			</tr>
			<tr>
				<td >Duong Tri Duc</td>
				<td >The school of life</td>
				<td >The Lord of The Rings</td>
				<td >Pop</td>
				<td >The revenant</td>
				<td >Granny</td>
				<td >Counter Strike</td>
			</tr>
			<tr>
				<td >Dang Thien An</td>
				<td >The 48 laws of power</td>
				<td >Lolita</td>
				<td >Jazz</td>
				<td >Transformer</td>
				<td >Wuthering Waves</td>
				<td >StarCraft II</td>
			</tr>
			</table>   
			
		</main>
		<?php include("footer.inc") ?>
	</body>
</html>