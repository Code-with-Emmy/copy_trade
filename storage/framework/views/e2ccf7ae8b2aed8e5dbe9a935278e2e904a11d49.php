<!doctype html>
<html lang="en">

<?php
    $siteName = data_get($settings ?? null, 'site_name', config('app.name', 'BitCloven'));
    $siteDescription = data_get($settings ?? null, 'site_description', 'Premium copy trading platform.');
    $favicon = data_get($settings ?? null, 'favicon') ? asset('storage/' . data_get($settings, 'favicon')) : asset('images/favicon.png');
    $brandLogo = data_get($settings ?? null, 'logo') ? asset('storage/' . data_get($settings, 'logo')) : asset('images/logo.png');
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo e($siteDescription); ?>">
    <meta name="theme-color" content="#0b0f17">
    <title><?php echo $__env->yieldContent('code'); ?> · <?php echo $__env->yieldContent('title'); ?> | <?php echo e($siteName); ?></title>
    <link rel="icon" href="<?php echo e($favicon); ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo e(asset('styles.css')); ?>">
    <style>
        .error-shell {
            min-height: calc(100vh - 64px);
            display: grid;
            place-items: center;
            padding: 2.5rem 0 3.5rem;
            background: radial-gradient(circle at 10% 10%, rgba(77, 212, 172, .14), transparent 35%),
                radial-gradient(circle at 95% 0, rgba(240, 185, 10, .12), transparent 35%),
                linear-gradient(180deg, #06090f 0%, #090f18 100%);
        }

        .error-card {
            width: min(980px, 100%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 28px;
            background: linear-gradient(145deg, rgba(13, 19, 32, 0.94), rgba(8, 13, 23, 0.95));
            box-shadow: 0 18px 60px -35px rgba(0, 0, 0, 0.9);
            overflow: hidden;
        }

        .error-grid {
            display: grid;
            grid-template-columns: 1.05fr .95fr;
        }

        .error-code-panel {
            position: relative;
            padding: 3rem 2rem;
            border-right: 1px solid rgba(255, 255, 255, 0.08);
            background: linear-gradient(180deg, rgba(255, 255, 255, .02), transparent);
        }

        .error-code-panel::before {
            content: "";
            position: absolute;
            right: -44px;
            top: -44px;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: rgba(77, 212, 172, .13);
            filter: blur(34px);
        }

        .error-code {
            font-size: clamp(3rem, 10vw, 6rem);
            line-height: .9;
            font-weight: 800;
            letter-spacing: .02em;
            color: #f0b90a;
        }

        .error-meta {
            margin-top: 1rem;
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            border: 1px solid rgba(77, 212, 172, .3);
            background: rgba(77, 212, 172, .1);
            color: #9be9d2;
            border-radius: 999px;
            padding: .45rem .9rem;
            font-size: .7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .2em;
        }

        .error-copy {
            padding: 3rem 2rem;
        }

        .error-title {
            font-size: clamp(1.5rem, 4vw, 2.25rem);
            line-height: 1.1;
            margin-bottom: .9rem;
            color: #fff;
        }

        .error-message {
            color: #b3bfd1;
            font-size: 1rem;
            line-height: 1.75;
            max-width: 42ch;
        }

        .error-actions {
            margin-top: 1.75rem;
            display: flex;
            flex-wrap: wrap;
            gap: .75rem;
        }

        .error-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            font-size: .82rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            text-decoration: none;
            transition: all .2s ease;
            padding: .8rem 1.2rem;
        }

        .error-btn-primary {
            color: #06090f;
            background: linear-gradient(90deg, #f0b90a, #f5ce46);
        }

        .error-btn-primary:hover {
            filter: brightness(1.08);
            transform: translateY(-1px);
        }

        .error-btn-secondary {
            color: #e8edf7;
            border: 1px solid rgba(255, 255, 255, .18);
            background: rgba(255, 255, 255, .03);
        }

        .error-btn-secondary:hover {
            border-color: rgba(255, 255, 255, .34);
            background: rgba(255, 255, 255, .06);
        }

        .error-footnote {
            margin-top: 1.2rem;
            font-size: .8rem;
            color: #71809a;
            max-width: 48ch;
        }

        .error-image {
            margin-top: 1.5rem;
            width: 100%;
            max-width: 350px;
            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, .12);
            opacity: .88;
        }

        .error-footer {
            border-top: 1px solid rgba(255, 255, 255, .08);
            padding: .9rem 1.25rem;
            color: #7a879b;
            font-size: .72rem;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        @media (max-width: 900px) {
            .error-grid {
                grid-template-columns: 1fr;
            }

            .error-code-panel {
                border-right: 0;
                border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            }
        }
    </style>
</head>

<body>
    <header class="site-header">
        <div class="container nav-wrapper">
            <a href="<?php echo e(url('/')); ?>" class="nav-brand" aria-label="<?php echo e($siteName); ?>">
                <img src="<?php echo e($brandLogo); ?>" alt="<?php echo e($siteName); ?> logo" class="nav-logo">
            </a>
            <nav class="nav-desktop">
                <a class="nav-link" href="<?php echo e(url('/')); ?>">Home</a>
                <a class="nav-link" href="<?php echo e(url('/traders')); ?>">Traders</a>
                <a class="nav-link" href="<?php echo e(url('/pricing')); ?>">Pricing</a>
                <a class="nav-link" href="<?php echo e(url('/about')); ?>">About</a>
            </nav>
            <div class="nav-cta">
                <a class="nav-link nav-login-link" href="<?php echo e(url('/login')); ?>">Log In</a>
                <a class="nav-btn btn-nav-primary" href="<?php echo e(url('/register')); ?>">Get Started</a>
            </div>
            <button class="nav-toggle" aria-expanded="false" aria-label="Toggle navigation">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
        <div class="mobile-menu" aria-hidden="true">
            <nav class="mobile-nav-links">
                <a class="nav-link" href="<?php echo e(url('/')); ?>">Home</a>
                <a class="nav-link" href="<?php echo e(url('/traders')); ?>">Traders</a>
                <a class="nav-link" href="<?php echo e(url('/pricing')); ?>">Pricing</a>
                <a class="nav-link" href="<?php echo e(url('/about')); ?>">About</a>
            </nav>
            <div class="mobile-nav-cta">
                <a class="nav-btn btn-nav-outline" href="<?php echo e(url('/login')); ?>">Log In</a>
                <a class="nav-btn btn-nav-primary" href="<?php echo e(url('/register')); ?>">Get Started</a>
            </div>
        </div>
    </header>

    <main class="error-shell">
        <div class="container">
            <article class="error-card">
                <div class="error-grid">
                    <div class="error-code-panel">
                        <p class="error-code"><?php echo $__env->yieldContent('code'); ?></p>
                        <span class="error-meta">Platform Response</span>
                        <img src="<?php echo e(asset('images/Copy-Trading.png')); ?>" alt="Trading dashboard preview" class="error-image" loading="lazy">
                    </div>

                    <div class="error-copy">
                        <h1 class="error-title"><?php echo $__env->yieldContent('title'); ?></h1>
                        <p class="error-message"><?php echo $__env->yieldContent('message'); ?></p>

                        <div class="error-actions">
                            <a href="<?php echo e(url()->previous()); ?>" class="error-btn error-btn-secondary">Go Back</a>
                            <a href="<?php echo e(url('/')); ?>" class="error-btn error-btn-primary">Back To Homepage</a>
                        </div>

                        <p class="error-footnote">
                            If this issue persists, contact support with error code
                            <strong><?php echo $__env->yieldContent('code'); ?></strong> so our team can investigate quickly.
                        </p>
                    </div>
                </div>
                <div class="error-footer">
                    <?php echo e($siteName); ?> · Secure Copy Trading Infrastructure
                </div>
            </article>
        </div>
    </main>

    <script src="<?php echo e(asset('script.js')); ?>"></script>
</body>

</html>
<?php /**PATH /Users/aierthinc/Desktop/CopyTrader/resources/views/errors/minimal.blade.php ENDPATH**/ ?>