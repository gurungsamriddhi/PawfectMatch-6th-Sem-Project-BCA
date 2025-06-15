<?php global $current_page; ?><!-- to apply css for active pages  -->


<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" href="favicon.png">

  <meta name="description" content="" />
  <meta name="keywords" content="bootstrap, bootstrap4" />

		<!-- Bootstrap CSS -->
		<link href="public/assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
		<link href="public/assets/css/tiny-slider.css" rel="stylesheet">
		<link href="public/assets/css/style.css" rel="stylesheet">
		<title>Pets For Adoption </title>
	</head>

	<body>

		<!-- Start Header/Navigation -->
		<nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark  sticky-top">

			<div class="container">
				<a class="navbar-brand" href="index.php?page=home">PawfectMatch</a>

				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbars" >
					<span class="navbar-toggler-icon"></span><!--hamburger toggle button for small screens -->
				</button>

				<div class="collapse navbar-collapse" id="navbars">
					<ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
						<li class="nav-item  <?= ($current_page=='home')?'active':''?>"><!--class active to the list-->
							<a class="nav-link" href="index.php?page=home">Home</a>
						</li>
						<li class="nav-item <?=($current_page=='browse')?'active':''?>">
                            <a class="nav-link" href="index.php?page=browse">Browse</a>
                        </li>
						<li class="nav-item <?=($current_page=='aboutus')?'active':''?>">
                            <a class="nav-link" href="index.php?page=aboutus">About us</a>
                        </li>
						<li class="nav-item <?=($current_page=='adoptionprocess')? 'active' :''?>">
                            <a class="nav-link" href="index.php?page=adoptionprocess">Adoption Process</a>
                        </li>
						<li class="nav-item <?=($current_page=='contactus')?'active' :''?>">
                            <a class="nav-link" href="index.php?page=contactus">Contact us</a>
                        </li>
					</ul>

					<ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
						<li><a class="nav-link" href="index.php?page=register"><img src="public/assets/images/user.svg"></a></li>
						
					</ul>
				</div>
			</div>
				
		</nav>
		<!-- End Header/Navigation -->
