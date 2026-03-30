<?php $__env->startSection('title', __('Not Found')); ?>
<?php $__env->startSection('code', '404'); ?>
<?php $__env->startSection('message', __("The page you're looking for doesn't exist, or was loaded incorrectly.")); ?>

<?php echo $__env->make('errors::minimal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/aierthinc/Desktop/CopyTrader/resources/views/errors/404.blade.php ENDPATH**/ ?>