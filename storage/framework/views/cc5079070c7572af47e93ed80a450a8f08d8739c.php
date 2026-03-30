<table class="panel panel-<?php echo e($color ?? 'primary'); ?>" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td class="panel-content">
<table width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td class="panel-item">
<?php echo e(Illuminate\Mail\Markdown::parse($slot)); ?>

</td>
</tr>
</table>
</td>
</tr>
</table>
<?php /**PATH /Users/aierthinc/Desktop/CopyTrader/resources/views/vendor/mail/html/panel.blade.php ENDPATH**/ ?>