<!-- app/views/home.php -->
<?php include 'app/views/partials/header.php'; ?>

<main>
	<!-- Start Hero Section -->
	<div class="hero">

		<div class="container">
			<div class="row justify-content-between">
				<div class="col-lg-5">
					<div class="intro-excerpt">
						<h1>Find Your <span>PawfectMatch</span></h1>
						<p class="mb-4">Browse adorable pets waiting to be adopted. Bring love home today.</p>
						<p>
							<a href="index.php?page=browse" class="btn btn-secondary me-2">Browse</a>
							<a href="index.php?page=donate" class="btn btn-white-outline">Donate</a>
						</p>
					</div>
				</div>
				<div class="col-lg-7">
					<div class="hero-img-wrap">
						<img src="public/assets/images/herosection.png" class="img-fluid">
					</div>

				</div>
			</div>
		</div>
	</div>
	<!-- End Hero Section -->

	<!-- Start pet Section -->
	<div class="pet-section">
		<div class="container">
			<div class="row">

				<!-- Start Column 1 -->
				<div class="col-md-12 col-lg-3 mb-5 mb-lg-0">
					<h2 class="mb-4 section-title">Available Pets</h2>
					<p class="mb-4">All listed pets are currently in shelters, waiting for a loving home.We ensure each pet is:
					<ul>
						<li>Medically examined and vaccinated</li>
						<li>Ready for adoption</li>
					</ul>
					</p>
					<p><a href="index.php?page=browse" class="btn">Explore</a></p>
				</div>
				<!-- End Column 1 -->

				<!-- Start Column 2 -->
				<div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
					<a class="pet-item" href="index.php?page=petdetails">
						<img src="public/assets/images/pet-1.jpg" class="img-fluid pet-thumbnail">
						<h3 class="pet-title">Dexter</h3>
					</a>
				</div>
				<!-- End Column 2 -->

				<!-- Start Column 3 -->
				<div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
					<a class="pet-item" href="index.php?page=petdetails">
						<img src="public/assets/images/pet-2.png" class="img-fluid pet-thumbnail">
						<h3 class="pet-title">Milo</h3>


					</a>
				</div>
				<!-- End Column 3 -->

				<!-- Start Column 4 -->
				<div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
					<a class="pet-item" href="index.php?page=petdetails">
						<img src="public/assets/images/pet-3.jpg" class="img-fluid pet-thumbnail">
						<h3 class="pet-title">Nile</h3>


					</a>
				</div>
				<!-- End Column 4 -->

			</div>
		</div>
	</div>
	<!-- End pet Section -->

	<!-- Start Why Choose Us Section -->
	<div class="why-choose-section">
		<div class="container">
			<div class="row justify-content-between">
				<div class="col-lg-6">
					<h2 class="section-title">Why Choose PawfectMatch?</h2>
					<p>At PawfectMatch, we believe every pet deserves a loving home. We carefully match pets with compassionate families,
						ensuring a safe, happy, and lifelong bond. With our trusted adoption process and dedicated support, finding your
						perfect furry friend has never been easier.</p>


					<div class="row my-5">
						<div class="col-12">
							<div class="feature">
								<div class="icon">
									<i class="fa-solid fa-heart"></i>
								</div>
								<div class="text">
									<h3>Fast &amp; Kind to everyone</h3>
									<p>We ensure a smooth and compassionate experience for every visitor, making the adoption process quick and friendly.</p>
								</div>
							</div>
						</div>

						<div class="col-12">
							<div class="feature">
								<div class="icon">
									<i class="fa-solid fa-paw"></i>
								</div>
								<div class="text">
									<h3>Advocate Adoption</h3>
									<p>Our mission is to promote pet adoption and raise awareness about the importance of giving animals a loving home.</p>
								</div>
							</div>
						</div>

						<div class="col-12">
							<div class="feature">
								<div class="icon">
									<i class="fa-solid fa-house"></i>
								</div>
								<div class="text">
									<h3>Responsible Rehoming</h3>
									<p>We carefully match pets with families to ensure lifelong, responsible care and happy homes for every animal.</p>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-5">
					<div class="img-wrap">
						<img src="public/assets/images/why-choose-us-img.png" alt="Image" class="img-fluid">
					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- End Why Choose Us Section -->

	<!-- Start We Help Section -->
	<div class="we-help-section">
		<div class="container">
			<div class="row justify-content-between">
				<div class="col-lg-5">
					<div class="img-wrap">
						<img src="public/assets/images/adoptionprocess.png" alt="Image" class="img-fluid">
					</div>
				</div>
				<div class="col-lg-5 ps-lg-5">
					<h2 class="section-title mb-4">How Our Adoption Process Works</h2>
					<p>We believe every pet deserves a loving home. Our adoption process is designed to
						be simple, safe, and supportive — helping you find the perfect furry friend while
						ensuring the best care for every animal.</p>


					<p><a href="index.php?page=adoptionprocess" class="btn">See in detail -></a></p>
				</div>
			</div>
		</div>
	</div>
	<!-- End We Help Section -->



	<!-- Start Testimonial Slider -->
	<!-- <div class="testimonial-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-7 mx-auto text-center">
					<h2 class="section-title">Testimonials</h2>
				</div>
			</div>

			<div class="row justify-content-center">
				<div class="col-lg-12">
					<div class="testimonial-slider-wrap text-center">

						<div id="testimonial-nav">
							<span class="prev" data-controls="prev"><span class="fa fa-chevron-left"></span></span>
							<span class="next" data-controls="next"><span class="fa fa-chevron-right"></span></span>
						</div>

						<div class="testimonial-slider">

							<div class="item">
								<div class="row justify-content-center">
									<div class="col-lg-8 mx-auto">

										<div class="testimonial-block text-center">
											<blockquote class="mb-5">
												<p>&ldquo;Donec facilisis quam ut purus rutrum lobortis. Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate velit imperdiet dolor tempor tristique. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Integer convallis volutpat dui quis scelerisque.&rdquo;</p>
											</blockquote>

											<div class="author-info">
												<div class="author-pic">
													<img src="images/person-1.png" alt="Maria Jones" class="img-fluid">
												</div>
												<h3 class="font-weight-bold">Maria Jones</h3>
												<span class="position d-block mb-3">CEO, Co-Founder, XYZ Inc.</span>
											</div>
										</div>

									</div>
								</div>
							</div> -->
	<!-- END item -->

	<!-- <div class="item">
								<div class="row justify-content-center">
									<div class="col-lg-8 mx-auto">

										<div class="testimonial-block text-center">
											<blockquote class="mb-5">
												<p>&ldquo;Donec facilisis quam ut purus rutrum lobortis. Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate velit imperdiet dolor tempor tristique. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Integer convallis volutpat dui quis scelerisque.&rdquo;</p>
											</blockquote>

											<div class="author-info">
												<div class="author-pic">
													<img src="images/person-1.png" alt="Maria Jones" class="img-fluid">
												</div>
												<h3 class="font-weight-bold">Maria Jones</h3>
												<span class="position d-block mb-3">CEO, Co-Founder, XYZ Inc.</span>
											</div>
										</div>

									</div>
								</div>
							</div> -->
	<!-- END item -->

	<!-- <div class="item">
								<div class="row justify-content-center">
									<div class="col-lg-8 mx-auto">

										<div class="testimonial-block text-center">
											<blockquote class="mb-5">
												<p>&ldquo;Donec facilisis quam ut purus rutrum lobortis. Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate velit imperdiet dolor tempor tristique. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Integer convallis volutpat dui quis scelerisque.&rdquo;</p>
											</blockquote>

											<div class="author-info">
												<div class="author-pic">
													<img src="images/person-1.png" alt="Maria Jones" class="img-fluid">
												</div>
												<h3 class="font-weight-bold">Maria Jones</h3>
												<span class="position d-block mb-3">CEO, Co-Founder, XYZ Inc.</span>
											</div>
										</div>

									</div>
								</div>
							</div> -->
	<!-- END item -->
	<!-- 
						</div>

					</div>
				</div>
			</div>
		</div>
	</div> -->
	<!-- End Testimonial Slider -->

	<!-- Start Blog Section -->
	<!-- <div class="blog-section">
		<div class="container">
			<div class="row mb-5">
				<div class="col-md-6">
					<h2 class="section-title">Recent Blog</h2>
				</div>
				<div class="col-md-6 text-start text-md-end">
					<a href="#" class="more">View All Posts</a>
				</div>
			</div>

			<div class="row">

				<div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0">
					<div class="post-entry">
						<a href="#" class="post-thumbnail"><img src="images/post-1.jpg" alt="Image" class="img-fluid"></a>
						<div class="post-content-entry">
							<h3><a href="#">First Time Home Owner Ideas</a></h3>
							<div class="meta">
								<span>by <a href="#">Kristin Watson</a></span> <span>on <a href="#">Dec 19, 2021</a></span>
							</div>
						</div>
					</div>
				</div>

				<div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0">
					<div class="post-entry">
						<a href="#" class="post-thumbnail"><img src="images/post-2.jpg" alt="Image" class="img-fluid"></a>
						<div class="post-content-entry">
							<h3><a href="#">How To Keep Your Furniture Clean</a></h3>
							<div class="meta">
								<span>by <a href="#">Robert Fox</a></span> <span>on <a href="#">Dec 15, 2021</a></span>
							</div>
						</div>
					</div>
				</div>

				<div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0">
					<div class="post-entry">
						<a href="#" class="post-thumbnail"><img src="images/post-3.jpg" alt="Image" class="img-fluid"></a>
						<div class="post-content-entry">
							<h3><a href="#">Small Space Furniture Apartment Ideas</a></h3>
							<div class="meta">
								<span>by <a href="#">Kristin Watson</a></span> <span>on <a href="#">Dec 12, 2021</a></span>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div> -->
	<!-- End Blog Section -->


	<?php include 'app/views/partials/footer.php'; ?>