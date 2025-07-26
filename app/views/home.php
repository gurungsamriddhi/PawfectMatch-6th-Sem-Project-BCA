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
					<p class="mb-4">We currently have <strong><?= $stats['total_available_pets'] ?> pets</strong> in shelters, waiting for a loving home. We ensure each pet is:
					<ul>
						<li>Medically examined and vaccinated</li>
						<li>Ready for adoption</li>
					</ul>
					</p>
					<p><a href="index.php?page=browse" class="btn">Explore All Pets</a></p>
				</div>
				<!-- End Column 1 -->

				<?php if (!empty($recentPets)): ?>
					<?php foreach ($recentPets as $pet): ?>
						<div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
							<a class="pet-item" href="index.php?page=browse">
								<img src="<?= htmlspecialchars($pet['image_path'] ?? 'public/assets/images/pets.png') ?>" class="img-fluid pet-thumbnail" alt="<?= htmlspecialchars($pet['name']) ?>">
								<h3 class="pet-title"><?= htmlspecialchars($pet['name']) ?></h3>
							</a>
						</div>
					<?php endforeach; ?>
				<?php else: ?>
					<!-- Fallback if no pets are available -->
					<div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
						<a class="pet-item" href="index.php?page=browse">
							<img src="public/assets/images/pets.png" class="img-fluid pet-thumbnail" alt="No pets available">
							<h3 class="pet-title">No pets available</h3>
						</a>
					</div>
					<div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
						<a class="pet-item" href="index.php?page=browse">
							<img src="public/assets/images/pets.png" class="img-fluid pet-thumbnail" alt="Browse pets">
							<h3 class="pet-title">Browse pets</h3>
						</a>
					</div>
					<div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
						<a class="pet-item" href="index.php?page=browse">
							<img src="public/assets/images/pets.png" class="img-fluid pet-thumbnail" alt="Find your match">
							<h3 class="pet-title">Find your match</h3>
						</a>
					</div>
				<?php endif; ?>

			</div>
		</div>
	</div>
	<!-- End pet Section -->

	<!-- Start Statistics Section -->
	<div class="statistics-section py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-top: 1px solid #dee2e6; border-bottom: 1px solid #dee2e6;">
		<div class="container">
			<div class="row text-center">
				<div class="col-md-4 mb-4">
					<div class="stat-item" style="background: white; border-radius: 15px; padding: 2rem; box-shadow: 0 8px 25px rgba(0,0,0,0.1); transition: all 0.3s ease; border: 1px solid #e9ecef;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 12px 35px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.1)'">
						<div class="stat-icon mb-3">
							<i class="fas fa-heart" style="font-size: 3rem; color: #436C5D; opacity: 0.8;"></i>
						</div>
						<div class="stat-number" style="font-size: 3.5rem; font-weight: 800; color: #436C5D; margin-bottom: 0.5rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.1);"><?= $stats['total_available_pets'] ?></div>
						<div class="stat-label" style="font-size: 1.3rem; color: #495057; font-weight: 600; margin-bottom: 0.5rem;">Pets Available</div>
						<div class="stat-description" style="font-size: 0.9rem; color: #6c757d; line-height: 1.4;">Ready to find their forever homes</div>
					</div>
				</div>
				<div class="col-md-4 mb-4">
					<div class="stat-item" style="background: white; border-radius: 15px; padding: 2rem; box-shadow: 0 8px 25px rgba(0,0,0,0.1); transition: all 0.3s ease; border: 1px solid #e9ecef;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 12px 35px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.1)'">
						<div class="stat-icon mb-3">
							<i class="fas fa-home" style="font-size: 3rem; color: #28a745; opacity: 0.8;"></i>
						</div>
						<div class="stat-number" style="font-size: 3.5rem; font-weight: 800; color: #28a745; margin-bottom: 0.5rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.1);"><?= $stats['total_adopted_pets'] ?></div>
						<div class="stat-label" style="font-size: 1.3rem; color: #495057; font-weight: 600; margin-bottom: 0.5rem;">Pets Adopted</div>
						<div class="stat-description" style="font-size: 0.9rem; color: #6c757d; line-height: 1.4;">Successfully placed in loving families</div>
					</div>
				</div>
				<div class="col-md-4 mb-4">
					<div class="stat-item" style="background: white; border-radius: 15px; padding: 2rem; box-shadow: 0 8px 25px rgba(0,0,0,0.1); transition: all 0.3s ease; border: 1px solid #e9ecef;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 12px 35px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.1)'">
						<div class="stat-icon mb-3">
							<i class="fas fa-paw" style="font-size: 3rem; color: #fd7e14; opacity: 0.8;"></i>
						</div>
						<div class="stat-number" style="font-size: 3.5rem; font-weight: 800; color: #fd7e14; margin-bottom: 0.5rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.1);"><?= $stats['total_pets'] ?></div>
						<div class="stat-label" style="font-size: 1.3rem; color: #495057; font-weight: 600; margin-bottom: 0.5rem;">Total Pets</div>
						<div class="stat-description" style="font-size: 0.9rem; color: #6c757d; line-height: 1.4;">Lives touched through our platform</div>
					</div>
				</div>
			</div>
			<div class="row mt-4">
				<div class="col-12 text-center">
					<div class="stats-cta" style="margin-top: 2rem;">
						<p style="font-size: 1.1rem; color: #6c757d; margin-bottom: 1rem;">Join us in making a difference in pets' lives</p>
						<a href="index.php?page=browse" class="btn" style="background: linear-gradient(135deg, #436C5D 0%, #2c5530 100%); color: white; border-radius: 25px; padding: 12px 30px; font-weight: 600; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(67, 108, 93, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(67, 108, 93, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(67, 108, 93, 0.3)'">
							<i class="fas fa-search me-2"></i>Browse All Pets
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Statistics Section -->

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
				<div class="col-lg-7 mb-5 mb-lg-0">
					
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

	<!-- Start Success Stories Section -->
	<div class="success-stories-section py-5">
		<div class="container">
			<div class="row">
				<div class="col-12 text-center mb-5">
					<h2 class="section-title">Success Stories</h2>
					<p class="testimonial-subtitle">Hear from families who found their perfect companions through PawfectMatch</p>
				</div>
			</div>
			
			<div class="row">
				<div class="col-12">
					<div class="testimonial-container">
						<!-- Testimonial 1 -->
						<div class="testimonial-slide" id="testimonial1" style="display: block;">
							<div class="testimonial-card">
								<div class="testimonial-image mb-4">
									<img src="public/assets/images/person_1.jpg" alt="Sarah & Max">
								</div>
								<div class="testimonial-text mb-4">
									<p>"Max has brought so much joy to our family! The adoption process was smooth and the team was incredibly supportive. He's now the happiest dog and we couldn't imagine life without him."</p>
								</div>
								<div class="testimonial-author">
									<h5>Sarah & Max</h5>
									<p>Adopted 6 months ago</p>
								</div>
							</div>
						</div>

						<!-- Testimonial 2 -->
						<div class="testimonial-slide" id="testimonial2" style="display: none;">
							<div class="testimonial-card">
								<div class="testimonial-image mb-4">
									<img src="public/assets/images/person_2.jpg" alt="Mike & Luna">
								</div>
								<div class="testimonial-text mb-4">
									<p>"Luna was the perfect addition to our home. The adoption center made sure we were a great match, and now she's the most loving cat. Thank you PawfectMatch for making this possible!"</p>
								</div>
								<div class="testimonial-author">
									<h5>Mike & Luna</h5>
									<p>Adopted 3 months ago</p>
								</div>
							</div>
						</div>

						<!-- Testimonial 3 -->
						<div class="testimonial-slide" id="testimonial3" style="display: none;">
							<div class="testimonial-card">
								<div class="testimonial-image mb-4">
									<img src="public/assets/images/person_3.jpg" alt="Emma & Buddy">
								</div>
								<div class="testimonial-text mb-4">
									<p>"Buddy has transformed our lives completely! The adoption process was professional and caring. He's now our best friend and we're so grateful to PawfectMatch for bringing us together."</p>
								</div>
								<div class="testimonial-author">
									<h5>Emma & Buddy</h5>
									<p>Adopted 1 year ago</p>
								</div>
							</div>
						</div>
						
						<!-- Navigation Arrows -->
						<button class="nav-btn prev-btn" onclick="changeTestimonial(-1)">
							<i class="fas fa-chevron-left"></i>
						</button>
						<button class="nav-btn next-btn" onclick="changeTestimonial(1)">
							<i class="fas fa-chevron-right"></i>
						</button>
						
						<!-- Dots Indicator -->
						<div class="testimonial-dots text-center mt-4">
							<span class="dot active" onclick="currentTestimonial(1)"></span>
							<span class="dot" onclick="currentTestimonial(2)"></span>
							<span class="dot" onclick="currentTestimonial(3)"></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Success Stories Section -->

	<!-- Testimonial Slider JavaScript -->
	<script>
		let currentTestimonialIndex = 0;
		const testimonials = document.querySelectorAll('.testimonial-slide');
		const dots = document.querySelectorAll('.dot');

		// Hide all testimonials except the first one
		function showTestimonial(index) {
			testimonials.forEach((testimonial, i) => {
				testimonial.style.display = i === index ? 'block' : 'none';
			});
			
			// Update dots
			dots.forEach((dot, i) => {
				dot.style.backgroundColor = i === index ? '#436C5D' : '#bbb';
			});
		}

		// Change testimonial
		function changeTestimonial(direction) {
			currentTestimonialIndex += direction;
			
			if (currentTestimonialIndex >= testimonials.length) {
				currentTestimonialIndex = 0;
			} else if (currentTestimonialIndex < 0) {
				currentTestimonialIndex = testimonials.length - 1;
			}
			
			showTestimonial(currentTestimonialIndex);
		}

		// Go to specific testimonial
		function currentTestimonial(index) {
			currentTestimonialIndex = index - 1;
			showTestimonial(currentTestimonialIndex);
		}

		// Auto-slide every 5 seconds
		setInterval(() => {
			changeTestimonial(1);
		}, 5000);

		// Initialize slider
		document.addEventListener('DOMContentLoaded', function() {
			showTestimonial(0);
		});
	</script>

	<?php include 'app/views/partials/footer.php'; ?>