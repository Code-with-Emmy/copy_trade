<?php $__env->startComponent('mail::layout'); ?>

<?php $__env->slot('header'); ?>
<?php $__env->startComponent('mail::header', ['url' => config('app.url')]); ?>
<?php if(isset($settings) && !empty($settings->logo)): ?>
<img src="<?php echo e(asset('storage/' . $settings->logo)); ?>" alt="<?php echo e(config('app.name')); ?>" class="logo">
<?php else: ?>
<span class="wordmark"><?php echo e(config('app.name')); ?></span>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php $__env->endSlot(); ?>


<?php echo e($slot); ?>



<?php if(isset($subcopy)): ?>
<?php $__env->slot('subcopy'); ?>
<?php $__env->startComponent('mail::subcopy'); ?>
<?php echo e($subcopy); ?>

<?php echo $__env->renderComponent(); ?>
<?php $__env->endSlot(); ?>
<?php endif; ?>


<?php $__env->slot('footer'); ?>
<?php $__env->startComponent('mail::footer'); ?>
© <?php echo e(date('Y')); ?> <?php echo e(isset($settings) && !empty($settings->site_name) ? $settings->site_name : config('app.name')); ?>. <?php echo app('translator')->get('All rights reserved.'); ?><br>
Operational updates, account alerts, and security notices from <?php echo e(isset($settings) && !empty($settings->site_name) ? $settings->site_name : config('app.name')); ?>.<br>
<?php if(isset($settings) && !empty($settings->contact_email)): ?>
Support: <a href="mailto:<?php echo e($settings->contact_email); ?>"><?php echo e($settings->contact_email); ?></a><br>
<?php endif; ?>
<a href="<?php echo e(rtrim(config('app.url'), '/')); ?>/terms">Terms</a> •
<a href="<?php echo e(rtrim(config('app.url'), '/')); ?>/privacy">Privacy</a> •
<a href="<?php echo e(rtrim(config('app.url'), '/')); ?>/risk-disclosure">Risk Disclosure</a>
<?php echo $__env->renderComponent(); ?>
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH /Users/aierthinc/Desktop/CopyTrader/resources/views/vendor/mail/html/message.blade.php ENDPATH**/ ?>