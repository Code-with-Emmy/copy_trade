<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <h4>Platform</h4>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('about') }}">About</a></li>
                    <li><a href="{{ route('home') }}#features">Features</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Explore</h4>
                <ul>
                    <li><a href="{{ route('traders.index') }}">Leaderboard</a></li>
                    <li><a href="{{ route('login') }}">Copy Portfolios</a></li>
                    <li><a href="{{ route('login') }}">Risk Engine</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Contact us</h4>
                <ul>
                    <li><a href="{{ route('login') }}">Help Center</a></li>
                    <li><a href="mailto:{{ $settings->contact_email ?? 'support@' . (parse_url(config('app.url', ''), PHP_URL_HOST) ?? 'example.com') }}">{{ $settings->contact_email ?? 'support@' . (parse_url(config('app.url', ''), PHP_URL_HOST) ?? 'example.com') }}</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <span>{{ date('Y') }}</span> {{ $settings->site_name ?? config('app.name') }}. All rights reserved.</p>
            <a href="{{ route('register') }}" target="_blank" class="btn-footer">Copy Now</a>
        </div>
    </div>
</footer>