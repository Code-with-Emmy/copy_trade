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
	<title>Education - Theramanuel Brokerage</title>
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
					<h1 class="mt-0 mb-1">Education</h1>
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
				<div class="row gy-md-3 gx-0 gx-md-3 gx-lg-5">
					<div class="col-md-12 col-lg-7">
						<h1 class="mb-2"><span class="text-highlight">Knowledge</span> is a investment</h1>
						<p class="lead text-muted">By combining easy-to-understand information with actionable insights, Theramanuel helps make the market seem less daunting—and more approachable.</p>
						<div class="d-flex align-items-center mt-2 mb-4 mb-md-0 mb-lg-0">
							<span class="badge bg-primary mb-0"><i class="fas fa-book fa-sm me-1"></i>Learn</span>
							<i class="fas fa-long-arrow-alt-right fa-sm mx-1 mb-0"></i>
							<span class="badge bg-primary mb-0"><i class="fas fa-lightbulb fa-sm me-1"></i>Understand</span>
							<i class="fas fa-long-arrow-alt-right fa-sm mx-1 mb-0"></i>
							<span class="badge bg-primary mb-0"><i class="fas fa-chart-area fa-sm me-1"></i>Trade</span>
						</div>
					</div>
					<div class="col-md-12 col-lg-5">
						<div class="card">
							<div class="card-body">
								<div class="d-flex align-items-start text-dark">
									<div class="flex-md-fill">
										<h3 class="fw-bold">Trading Academy</h3>
										<p>Reprehenderit in voluptate velit esse cillum dolore laboris aute irure.</p>
										<a class="btn btn-primary rounded-pill" href="{{ route('register') }}">Start Learning<i class="fas fa-arrow-right fa-sm ms-1"></i></a>
									</div>
									<div>
										<i class="fas fa-user-graduate fa-5x text-secondary mt-1"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- section content end -->
		<!-- section content begin -->
		<section class="py-4">
			<div class="container">
				<div class="row justify-content-center mt-n3">
					<div class="col-12">
						<div class="border-bottom py-3">
							<div class="row align-content-center gy-1 gy-md-1">
								<div class="col-md-12 col-lg-4 d-flex align-items-center">
									<div class="d-flex align-items-center">
										<div class="icon-wrap bg-primary rounded-circle flex-shrink-0 me-2">
											<i class="fas fa-users fa-lg text-primary"></i>
										</div>
										<h4 class="fw-bold mb-0">Beginner Course</h4>
									</div>
								</div>
								<div class="col-md-12 col-lg-5 d-flex align-items-center">
									<p class="mb-0">Learn the basic concepts of forex trading, what this market is all about, and why you should be a part of it.</p>
								</div>
								<div class="col-md-12 col-lg-3 d-flex align-items-center justify-content-lg-end">
									<a class="btn btn-link link-primary text-decoration-none p-0 mt-1 mt-md-0 mt-lg-0" href="#">Enter Course<i class="fas fa-arrow-right fa-sm ms-1"></i></a>
								</div>
							</div>
						</div>
						<div class="border-bottom py-3">
							<div class="row align-content-center gy-1 gy-md-1">
								<div class="col-md-12 col-lg-4 d-flex align-items-center">
									<div class="d-flex align-items-center">
										<div class="icon-wrap bg-primary rounded-circle flex-shrink-0 me-2">
											<i class="fas fa-tools fa-lg text-primary"></i>
										</div>
										<h4 class="fw-bold mb-0">Trading Tools</h4>
									</div>
								</div>
								<div class="col-md-12 col-lg-5 d-flex align-items-center">
									<p class="mb-0">Familiarize yourself with advanced strategies and Btrade's trading toolset. Take your trading to the next level.</p>
								</div>
								<div class="col-md-12 col-lg-3 d-flex align-items-center justify-content-lg-end">
									<a class="btn btn-link link-primary text-decoration-none p-0 mt-1 mt-md-0 mt-lg-0" href="#">Enter Course<i class="fas fa-arrow-right fa-sm ms-1"></i></a>
								</div>
							</div>
						</div>
						<div class="py-3">
							<div class="row align-content-center gy-1 gy-md-1">
								<div class="col-md-12 col-lg-4 d-flex align-items-center">
									<div class="d-flex align-items-center">
										<div class="icon-wrap bg-primary rounded-circle flex-shrink-0 me-2">
											<i class="fas fa-chart-area fa-lg text-primary"></i>
										</div>
										<h4 class="fw-bold mb-0">Stocks and CFDs</h4>
									</div>
								</div>
								<div class="col-md-12 col-lg-5 d-flex align-items-center">
									<p class="mb-0">Discover the world of CFD trading: The ins & outs of the CFD market, relevant information and market dynamics.</p>
								</div>
								<div class="col-md-12 col-lg-3 d-flex align-items-center justify-content-lg-end">
									<a class="btn btn-link link-primary text-decoration-none p-0 mt-1 mt-md-0 mt-lg-0" href="#">Enter Course<i class="fas fa-arrow-right fa-sm ms-1"></i></a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 col-lg-9 mt-2 mt-md-3 mt-lg-3">
						<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 gy-1 g-md-1 g-lg-1">
							<div class="d-grid col">
								<a class="btn btn-outline-secondary" href="#">Fast Academy</a>
							</div>
							<div class="d-grid col">
								<a class="btn btn-outline-secondary" href="#">Video Tutorials</a>
							</div>
							<div class="d-grid col">
								<a class="btn btn-outline-secondary" href="#">Course</a>
							</div>
							<div class="d-grid col">
								<a class="btn btn-outline-secondary" href="#">E-Books</a>
							</div>
							<div class="d-grid col">
								<a class="btn btn-outline-secondary" href="#">Glossary</a>
							</div>
							<div class="d-grid col">
								<a class="btn btn-outline-secondary" href="#">Trading Info</a>
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
				<div class="row">
					<div class="col-12">
						<div class="card border-0" style="background-image: url({{ asset('img/blockit/in-card-background-1.jpg') }}); background-repeat: no-repeat;">
							<div class="card-body p-4">
								<h2 class="text-white mb-1">Free Demo Account</h2>
								<p class="lead text-white text-opacity-50 my-1">Practice Stocks and CFDs trading in a risk-free environment.</p>
								<a class="btn btn-light rounded-pill mt-1" href="#">Open an Account<i class="fas fa-arrow-right fa-sm ms-1"></i></a>
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
						<h6 class="mb-1"><span><i class="fas fa-triangle-exclamation fa-sm"></i>Risk warning</span></h6>
						<p class="mb-0">The prices of securities fluctuate, sometimes dramatically. The price of a security may move up or down, and may become valueless. It is as likely that losses will be incurred rather than profit made as a result of buying and selling securities.</p>
					</div>
					<p class="copyright-text">Copyright ©2023 Theramanuel Ltd. All Rights Reserved.</p>
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