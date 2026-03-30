<?php
    $siteUrl = rtrim(config('app.url'), '/');
    $supportEmail = optional($settings)->contact_email ?: config('mail.from.address');
?>
<?php $__env->startComponent('mail::message'); ?>
<p class="eyebrow">Account Notification</p>
# <?php echo e($salutaion ?: 'Hello'); ?> <?php echo e($recipient); ?>,

<p class="lead">A new update is available for your account.</p>

<?php echo $__env->make('emails.partials.summary-table', [
    'rows' => [
        ['label' => 'Notice type', 'value' => e($subject)],
        ['label' => 'Sent at', 'value' => now()->format('M d, Y g:i A')],
        ['label' => 'Recipient', 'value' => e($recipient)],
    ],
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $body; ?>


<?php if($attachment): ?>
<div class="divider"></div>
<p class="eyebrow">Attachment</p>
<div class="info-card text-center">
    <p class="muted">Review the attached reference below.</p>
    <img src="<?php echo e($message->embed(asset('storage/' . $attachment))); ?>" alt="Attachment" style="max-width: 100%; border-radius: 12px;">
</div>
<?php endif; ?>

<?php $__env->startComponent('mail::panel'); ?>
Need help with this update? Reply to this email or contact the support desk and include the notice subject for faster handling.
<?php echo $__env->renderComponent(); ?>

<?php if($url): ?>
<?php $__env->startComponent('mail::button', ['url' => $url]); ?>
Open Related Page
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

<?php $__env->startComponent('mail::button', ['url' => $siteUrl . '/support', 'color' => 'success']); ?>
Contact Support
<?php echo $__env->renderComponent(); ?>

<?php $__env->startComponent('mail::subcopy'); ?>
<?php echo e(config('app.name')); ?> will never ask for your password or recovery code by email. If this message looks suspicious, contact <?php echo e($supportEmail ?: 'support'); ?> before taking any action.
<?php echo $__env->renderComponent(); ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH /Users/aierthinc/Desktop/CopyTrader/resources/views/emails/NewNotification.blade.php ENDPATH**/ ?>