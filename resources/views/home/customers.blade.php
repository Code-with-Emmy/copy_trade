<!doctype html>
<html lang="en">

<head>
	<!-- Meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Theramanuel Brokerage Copy Trade, Finance and Investment ">
	<meta name="keywords" content="Theramanuel, Brokerage, Copy, Trade, Finance, and, Investment">
	<meta name="author" content="Warren Wong">
	<meta name="theme-color" content="#E67300">
	<!-- critical preload -->
	<link rel="preload" href="{{ asset('js/vendors/bootstrap.bundle.min.js') }}" as="script">
	<link rel="preload" href="{{ asset('css/style.css') }}" as="style">
	<!-- icon preload -->
	<link rel="preload" href="{{ asset('fonts/fa-brands-400.woff2') }}" as="font" type="font/woff2" crossorigin>
	<link rel="preload" href="{{ asset('fonts/fa-solid-900.woff2') }}" as="font" type="font/woff2" crossorigin>
	<!-- font preload -->
	<link rel="preload" href="{{ asset('fonts/dm-sans-v11-latin-700.woff2') }}" as="font" type="font/woff2" crossorigin>
	<link rel="preload" href="{{ asset('fonts/dm-sans-v11-latin-regular.woff2') }}" as="font" type="font/woff2" crossorigin>
	<!-- stylesheet -->
	<link rel="stylesheet" href="{{ asset('css/style.css') }}">
	<!-- Favicon -->
	<link rel="shortcut icon" href="{{ asset('storage/' . $settings->favicon) }}" type="image/x-icon">
	<!-- Touch icon -->
	<link rel="apple-touch-icon-precomposed" href="{{ asset('storage/' . $settings->favicon) }}">
	<title>Customers - Theramanuel Brokerage</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
	<!-- page loader begin -->
	<div class="page-loader w-100 h-100 bg-white d-flex justify-content-center align-items-center position-fixed overflow-hidden">
		<div class="spinner-grow spinner-grow-sm text-primary"></div>
		<div class="spinner-grow spinner-grow-sm text-primary"></div>
		<div class="spinner-grow spinner-grow-sm text-primary"></div>
	</div>
	<!-- page loader end -->
	<!-- ticker content begin -->
	<section class="bg-primary">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<h1 class="d-none">Stock price ticker</h1>
					<ul class="ticker-tape"></ul>
				</div>
			</div>
		</div>
	</section>
	<!-- ticker content end -->
	<!-- header begin -->
	<header class="navbar navbar-expand-lg navbar-light">
		<div class="container">
			<a class="navbar-brand" href="{{ route('home') }}">
				<img src="{{ asset('storage/' . $settings->logo) }}" alt="logo" width="180" height="65" class="d-inline-block">
			</a>
			<div class="collapse navbar-collapse d-flex justify-content-between d-none d-xl-block" id="navbarNav">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="{{ route('home') }}">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('markets') }}">Markets</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="" id="dropdownCompany" data-bs-toggle="dropdown" aria-expanded="false">Company</a>
						<ul class="dropdown-menu">
							<li>
								<a class="dropdown-item" href="{{ route('about') }}">About</a>
							</li>
							<li>
								<a class="dropdown-item" href="{{ route('blog') }}">Blog</a>
							</li>
							<li>
								<a class="dropdown-item" href="{{ route('careers') }}">Careers</a>
							</li>
							<li>
								<a class="dropdown-item" href="{{ route('contact') }}">Contact</a>
							</li>
						</ul>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('education') }}">Education</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="" id="dropdownResources" data-bs-toggle="dropdown" aria-expanded="false">Resources</a>
						<ul class="dropdown-menu">
							<li>
								<a class="dropdown-item" href="https://getbootstrap.com/docs/5.3/getting-started/introduction/">Documentation<i class="fas fa-square-arrow-up-right fa-sm"></i></a>
							</li>
							<li>
								<a class="dropdown-item" href="{{ route('faq') }}">Help Center</a>
							</li>
							<li>
								<a class="dropdown-item" href="{{ route('customers') }}">Customers</a>
							</li>
							<li>
								<a class="dropdown-item" href="{{ route('roadmap') }}">Roadmap</a>
							</li>
							<li>
								<a class="dropdown-item" href="{{ route('terms') }}">Legal Docs<i class="fas fa-gavel fa-sm"></i></a>
							</li>
						</ul>
					</li>
				</ul>
				<div class="optional-link d-flex align-items-center ms-4 d-none d-xl-block">
					<a href="{{ route('login') }}" class="btn btn-link link-secondary text-decoration-none">Sign in</a>
					<a href="{{ route('register') }}" class="btn btn-outline-primary rounded-pill">Get started<i class="fas fa-arrow-right fa-sm ms-1"></i></a>
				</div>
			</div>
		</div>
	</header>
	<!-- header end -->
	<!-- breadcrumb content begin -->
	<section class="section-breadcrumb">
		<div class="container">
			<div class="row">
				<div class="col-12 position-relative text-center">
					<h1 class="mt-0 mb-1">Customers</h1>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb mb-0">
							<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
						</ol>
					</nav>
					<img class="position-absolute card-decor animate-5" src="{{ asset('img/in-theramanuel-4-decor-1.svg') }}" alt="decor" style="top: 25%; left: 5%;">
					<img class="position-absolute card-decor animate-6" src="{{ asset('img/in-theramanuel-4-decor-2.svg') }}" alt="decor" style="top: -22%; left: 30%;">
					<img class="position-absolute card-decor animate-7" src="{{ asset('img/in-theramanuel-4-decor-3.svg') }}" alt="decor" style="top: -16%; left: 72%;">
					<img class="position-absolute card-decor animate-6" src="{{ asset('img/in-theramanuel-4-decor-4.svg') }}" alt="decor" style="top: 89%; left: 94%;">
				</div>
			</div>
		</div>
	</section>
	<!-- breadcrumb content end -->
	<main>
		<!-- section content begin -->
		<section class="py-5">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-12 col-lg-9">
						<div class="row align-items-center gx-0 gx-md-3 gx-lg-3">
							<div class="col-12 col-md-8 col-lg-8">
								<h1><span class="text-highlight">Our Clients</span> Come First</h1>
								<p class="fs-4 text-muted">Empowering traders to reach their financial goals</p>
								<p>Our customers look to us as guides, and we weave our deep market experience into our platform and services to help them succeed.</p>
							</div>
							<div class="col-12 col-md-4 col-lg-4 mt-3 mt-md-0 mt-lg-0">
								<ul class="list-unstyled">
									<li class="border-bottom pb-2">
										<div class="d-flex align-items-start">
											<div class="me-2">
												<div class="icon-wrap bg-primary rounded-circle flex-shrink-0">
													<i class="fas fa-paper-plane fa-lg text-primary"></i>
												</div>
											</div>
											<div>
												<h3 class="mb-0">
													<span class="count" data-counter-end="35817">35,817</span>
												</h3>
												<div class="badge bg-primary mb-0">Business launch</div>
											</div>
										</div>
									</li>
									<li class="pt-2">
										<div class="d-flex align-items-start">
											<div class="me-2">
												<div class="icon-wrap bg-primary rounded-circle flex-shrink-0">
													<i class="fas fa-user-tie fa-lg text-primary"></i>
												</div>
											</div>
											<div>
												<h3 class="mb-0">
													<span class="count" data-counter-end="4400">4,400</span>
												</h3>
												<div class="badge bg-primary mb-0">Investor engaged</div>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- section content end -->
		<!-- section content begin -->
		<section class="pt-2 mb-n2">
			<div class="container">
				<div class="row row-cols-1 row-cols-md-1 row-cols-lg-2 gx-0 gx-md-0 gx-lg-3 gy-3 gy-md-3 gy-lg-0">
					<div class="col">
						<div class="card position-relative">
							<div class="card-body">
								<img class="position-absolute bottom-0 end-0" src="{{ asset('img/blockit/in-testimoni-2.png') }}" alt="client-testimoni" width="200">
								<blockquote class="blockquote text-muted">
									<p>The extension makes collecting feedback so much easier! Shipright then really helps us make decisions based on the data we collected.</p>
								</blockquote>
								<div class="mt-4">
									<img class="mb-2" src="{{ asset('img/blockit/in-client-testi-1.svg') }}" alt="client-logo" width="62" height="62">
									<h6 class="mb-0">Gabrielle Barger</h6>
									<span class="blockquote-footer">Help Desk at Pushbullet</span>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card position-relative">
							<div class="card-body">
								<img class="position-absolute bottom-0 end-0" src="{{ asset('img/blockit/in-testimoni-3.png') }}" alt="client-testimoni" width="200">
								<blockquote class="blockquote text-muted">
									<p>Quick, easy, and super helpful to collect and organise feedback from all kinds of channels we use to communicate with our customers.</p>
								</blockquote>
								<div class="mt-4">
									<img class="mb-2" src="{{ asset('img/blockit/in-client-testi-2.svg') }}" alt="client-logo" width="62" height="62">
									<h6 class="mb-0">Melvin Cortez</h6>
									<span class="blockquote-footer">Cloud Architect at Stormpath</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- section content end -->
		<!-- section content begin -->
		<section class="py-5">
			<div class="container">
				<div class="row row-cols-1 row-cols-md-1 row-cols-lg-3 gx-0 gx-md-0 gx-lg-3 gy-3 gy-md-3 gy-lg-0">
					<div class="col">
						<div class="card">
							<div class="card-body">
								<img src="{{ asset('img/blockit/in-client-testi-1.svg') }}" alt="client-logo" width="64" height="64">
								<blockquote class="blockquote text-muted my-4">
									<p>Really love the product! It saves so much time and helps a lot in organize our feedback. Very potential.</p>
								</blockquote>
								<h6 class="mb-0">Gabrielle Barger</h6>
								<span class="blockquote-footer">Help Desk at Pushbullet</span>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card">
							<div class="card-body">
								<img src="{{ asset('img/blockit/in-client-testi-2.svg') }}" alt="client-logo" width="64" height="64">
								<blockquote class="blockquote text-muted my-4">
									<p>This is my one stop shop for sending all Updates to investors, board of directors or even exec team members.</p>
								</blockquote>
								<h6 class="mb-0">Melvin Cortez</h6>
								<span class="blockquote-footer">Cloud Architect at Stormpath</span>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card">
							<div class="card-body">
								<img src="{{ asset('img/blockit/in-client-testi-3.svg') }}" alt="client-logo" width="64" height="64">
								<blockquote class="blockquote text-muted my-4">
									<p>Has been a great tool for me on monthly updates & helps to communicate the key issues/plan with our team.</p>
								</blockquote>
								<h6 class="mb-0">Franklin Clark</h6>
								<span class="blockquote-footer">Sales Analyst at Eventbrite</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- section content end -->
	</main>
	<!-- footer begin -->
	<footer class="bg-light pb-4 in-theramanuel-footer">
		<div class="container">
			<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 gy-4 gy-lg-0">
				<div class="col">
					<h5>Overview</h5>
					<ul class="list-unstyled">
						<li><a href="{{ route('register') }}">Open account</a></li>
						<li><a href="{{ route('about') }}">Our company</a></li>
						<li><a href="{{ route('login') }}">Login</a></li>
						<li><a href="{{ route('careers') }}">Careers</a></li>
					</ul>
				</div>
				<div class="col">
					<h5>Account</h5>
					<ul class="list-unstyled">
						<li><a href="#">Client services</a></li>
						<li><a href="#">VIP offering</a></li>
						<li><a href="#">Corporate account</a></li>
						<li><a href="{{ route('faq') }}">Support center</a></li>
						<li><a href="#">Refer a friend</a></li>
					</ul>
				</div>
				<div class="col">
					<h5>Others</h5>
					<ul class="list-unstyled">
						<li><a href="#">Trade inspirations</a></li>
						<li><a href="#">Outrageous predictions</a></li>
						<li><a href="#">Quarterly outlook</a></li>
						<li><a href="#">Margin information</a></li>
					</ul>
				</div>
				<div class="col">
					<h5>Get in Touch</h5>
					<p>Contact us any time for getting support.</p>
					<a class="footer-email" href="mailto:support@theramanuel.com">support@theramanuel.com</a>
					<!-- social media begin -->
					<div class="social-media-list small hstack">
						<div><a href="https://www.facebook.com/theramanuel" class="color-facebook text-decoration-none"><i class="fab fa-facebook"></i> Facebook</a></div>
						<div><a href="https://x.com/theramanuel" class="color-twitter text-decoration-none"><i class="fab fa-x-twitter"></i> X</a></div>
						<div><a href="https://www.instagram.com/theramanuel" class="color-instagram text-decoration-none"><i class="fab fa-instagram"></i> Instagram</a></div>
					</div>
					<!-- social media end -->
				</div>
				<div class="col-md-12 col-lg-12 text-center small mt-4">
					<div class="trade-warning">
						<h6 class="mb-1"><span><i class="fas fa-triangle-exclamation fa-sm"></i>Risk Warning</span></h6>
						<p class="mb-0">Trading derivatives and copy trading involves a high level of risk and may not be suitable for all investors. You could lose some or all of your invested capital. Past performance of a trader is not a reliable indicator of their future performance. Please ensure you fully understand the risks involved.</p>
					</div>
					<p class="copyright-text">Copyright ©2024 Theramanuel Brokerage Ltd. All Rights Reserved.</p>
				</div>
			</div>
		</div>
	</footer>
	<!-- footer end -->
	<!-- to top begin -->
	<div class="d-none d-md-block">
		<a href="#" class="to-top fas fa-arrow-up text-decoration-none text-white"></a>
	</div>
	<!-- to top end -->
	<!-- javascript -->
	<script src="{{ asset('js/vendors/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('js/vendors/vanilla-marquee.min.js') }}"></script>
	<script src="{{ asset('js/utilities.min.js') }}"></script>
	<script src="{{ asset('js/config-theme.js') }}"></script>
</body>

</html>