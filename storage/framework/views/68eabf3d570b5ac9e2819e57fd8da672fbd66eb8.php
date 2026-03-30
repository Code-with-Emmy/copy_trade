<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <h4>Platform</h4>
                <ul>
                    <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
                    <li><a href="<?php echo e(route('about')); ?>">About</a></li>
                    <li><a href="<?php echo e(route('home')); ?>#features">Features</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Explore</h4>
                <ul>
                    <li><a href="<?php echo e(route('traders.index')); ?>">Leaderboard</a></li>
                    <li><a href="<?php echo e(route('login')); ?>">Copy Portfolios</a></li>
                    <li><a href="<?php echo e(route('login')); ?>">Risk Engine</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Contact us</h4>
                <ul>
                    <li><a href="<?php echo e(route('login')); ?>">Help Center</a></li>
                    <li><a href="mailto:support@BitCloven.com">support@BitCloven.com</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <span><?php echo e(date('Y')); ?></span> BitCloven. All rights reserved.</p>
            <a href="<?php echo e(route('register')); ?>" target="_blank" class="btn-footer">Copy Now</a>
        </div>
    </div>
</footer><?php /**PATH /Users/aierthinc/Desktop/CopyTrader/resources/views/components/landing/footer.blade.php ENDPATH**/ ?>