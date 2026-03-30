<?php if(!empty($rows)): ?>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="summary-card">
    <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $label = $row['label'] ?? null;
            $value = $row['value'] ?? null;
        ?>
        <?php if($label !== null && $value !== null && $value !== ''): ?>
            <tr>
                <td class="summary-label"><?php echo e($label); ?></td>
                <td class="summary-value"><?php echo $value; ?></td>
            </tr>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>
<?php endif; ?>
<?php /**PATH /Users/aierthinc/Desktop/CopyTrader/resources/views/emails/partials/summary-table.blade.php ENDPATH**/ ?>