<?php
    $brandName = optional($settings)->site_name ?: config('app.name');
    $brandLogo = optional($settings)->logo
        ? asset('storage/' . $settings->logo)
        : asset('images/logo.png');
?>

<header class="site-header">
    <div class="container nav-wrapper">
        <a href="<?php echo e(route('home')); ?>" class="nav-brand" aria-label="<?php echo e($brandName); ?>">
            <img src="<?php echo e($brandLogo); ?>" alt="<?php echo e($brandName); ?> logo" class="nav-logo">
        </a>
        <nav class="nav-desktop">
            <a class="nav-link" href="<?php echo e(route('about')); ?>">About</a>
            <a class="nav-link" href="<?php echo e(route('home')); ?>#features">Features</a>
            <a class="nav-link" href="<?php echo e(route('home')); ?>#copy-features">Copy</a>
            <a class="nav-link" href="<?php echo e(route('home')); ?>#explore">Explore</a>
            <a class="nav-link" href="<?php echo e(route('home')); ?>#faq">FAQ</a>
        </nav>
        <div class="nav-cta">
            <a class="nav-link nav-login-link" href="<?php echo e(route('login')); ?>">Log In</a>
            <a class="nav-btn btn-nav-primary" href="<?php echo e(route('register')); ?>">Get Started</a>
        </div>
        <button class="nav-toggle" aria-expanded="false" aria-label="Toggle navigation">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
    <div class="mobile-menu" aria-hidden="true">
        <nav class="mobile-nav-links">
            <a class="nav-link" href="<?php echo e(route('about')); ?>">About</a>
            <a class="nav-link" href="<?php echo e(route('home')); ?>#features">Features</a>
            <a class="nav-link" href="<?php echo e(route('home')); ?>#copy-features">Copy</a>
            <a class="nav-link" href="<?php echo e(route('home')); ?>#explore">Explore</a>
            <a class="nav-link" href="<?php echo e(route('home')); ?>#faq">FAQ</a>
        </nav>
        <div class="mobile-nav-cta">
            <a class="nav-btn btn-nav-outline" href="<?php echo e(route('login')); ?>">Log In</a>
            <a class="nav-btn btn-nav-primary" href="<?php echo e(route('register')); ?>">Get Started</a>
        </div>
    </div>
</header>
<?php /**PATH C:\Users\hp\Downloads\CopyTrader\resources\views/components/landing/navbar.blade.php ENDPATH**/ ?>