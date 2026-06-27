<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="description"
        content="<?php echo $__env->yieldContent('meta_description', $settings->site_name . ' is a premium copy trading platform where investors follow verified traders with transparent risk controls.'); ?>">
    <title><?php echo $__env->yieldContent('title', config('app.name')); ?> | <?php echo e($settings->site_name); ?></title>

    
    <link rel="stylesheet" href="<?php echo e(asset('styles.css')); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js@1.12.0/src/toastify.min.css">
    <link rel="icon" href="<?php echo e(asset('images/favicon.png')); ?>" type="image/x-icon">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <?php echo $__env->yieldPushContent('head'); ?>
</head>

<body class="bg-black text-white antialiased">

    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.landing.navbar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('landing.navbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

    <main class="min-h-screen">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    

    <?php echo $__env->yieldPushContent('scripts'); ?>

    
    <script src="<?php echo e(asset('script.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js@1.12.0/src/toastify.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function showToast(message, type = 'info') {
                if (!message) return;

                const backgroundColors = {
                    success: 'linear-gradient(to right, #16a34a, #059669)',
                    error: 'linear-gradient(to right, #dc2626, #ef4444)',
                    info: 'linear-gradient(to right, #334155, #475569)',
                };

                Toastify({
                    text: message,
                    duration: 6000,
                    close: true,
                    gravity: 'top',
                    position: 'right',
                    stopOnFocus: true,
                    backgroundColor: backgroundColors[type] || backgroundColors.info,
                    className: 'toastify',
                }).showToast();
            }

            const messages = [];
            <?php if(session('success')): ?>
                messages.push({ message: <?php echo json_encode(session('success'), 15, 512) ?>, type: 'success' });
            <?php endif; ?>
            <?php if(session('status')): ?>
                messages.push({ message: <?php echo json_encode(session('status'), 15, 512) ?>, type: 'success' });
            <?php endif; ?>
            <?php if(session('error')): ?>
                messages.push({ message: <?php echo json_encode(session('error'), 15, 512) ?>, type: 'error' });
            <?php endif; ?>
            <?php if(session('message')): ?>
                messages.push({ message: <?php echo json_encode(session('message'), 15, 512) ?>, type: 'info' });
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    messages.push({ message: <?php echo json_encode($error, 15, 512) ?>, type: 'error' });
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

            messages.forEach((toast, index) => {
                setTimeout(() => showToast(toast.message, toast.type), index * 250);
            });
        });
    </script>
</body>

</html><?php /**PATH C:\Users\hp\Downloads\CopyTrader\resources\views/layouts/public.blade.php ENDPATH**/ ?>