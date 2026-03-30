@extends('layouts.public')

@section('title', 'About BitCloven')
@section('meta_description', 'Learn about BitCloven, the social copy trading platform built for transparency, confidence, and elite strategy replication.')

@section('content')
    <!-- About Hero -->
    <section class="about-hero">
        <div class="container about-hero-grid">
            <div class="about-hero-content">
                <h1>Built for investors who want confidence in every copied trade.</h1>
                <p>We launched BitCloven to bridge elite strategy and everyday investors. Our platform gives you deep
                    transparency, responsive automation, and risk controls that keep your capital aligned with your goals.
                </p>
                <div class="about-hero-actions">
                    <a href="{{ route('register') }}" class="btn-primary">Explore Strategies</a>
                    <a href="{{ route('login') }}" class="btn-secondary">Explore Lead Traders</a>
                </div>
            </div>
            <div class="about-hero-metrics">
                <div class="about-metric-card">
                    <span>18,000+</span>
                    <p>Active investors copying professionals across 72 countries.</p>
                </div>
                <div class="about-metric-card">
                    <span>$250M+</span>
                    <p>Capital mirrored with precision risk guardrails and live controls.</p>
                </div>
                <div class="about-metric-card">
                    <span>92%</span>
                    <p>Customer satisfaction score from ongoing platform surveys.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Story -->
    <section class="about-story">
        <div class="container about-story-grid">
            <div class="about-story-text">
                <h2>Where strategy automation meets human insight.</h2>
                <p>Copy trading works best when investors can see the reasons behind every execution. That’s why we built a
                    transparent layer that combines detailed analytics, risk auditing, and live trader commentary. You
                    always know who you are following, why a position is opening, and how it is protected.</p>
                <div class="about-story-highlights">
                    <div class="about-story-highlight">
                        <h3>Trusted traders</h3>
                        <p>Every lead trader is vetted, monitored, and scored on consistency, drawdown, and discipline.</p>
                    </div>
                    <div class="about-story-highlight">
                        <h3>Automation with guardrails</h3>
                        <p>Clone entries instantly, set personal limits, and enable circuit breakers that pause high-risk
                            environments.</p>
                    </div>
                    <div class="about-story-highlight">
                        <h3>Community intelligence</h3>
                        <p>Access weekly debriefs, strategy chat, and analytics that tell the story behind performance.</p>
                    </div>
                </div>
            </div>
            <div class="about-story-image">
                <img src="{{ asset('images/Copy-Trading.png') }}" alt="Copy trading collaboration illustration">
            </div>
        </div>
    </section>

    <!-- Pillars -->
    <section class="about-pillars">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Our platform pillars</h2>
                <p>We combine resilient infrastructure with human-led service so you can copy confidently in every market
                    condition.</p>
            </div>
            <div class="about-pillars-grid">
                <div class="about-pillar-card">
                    <h3>Transparency first</h3>
                    <p>Detailed trade logs, performance snapshots, and live risk scores keep your strategies grounded in
                        data. Nothing is hidden, ever.</p>
                </div>
                <div class="about-pillar-card">
                    <h3>Personalized controls</h3>
                    <p>Set allocation rules, max drawdowns, asset filters, and trading hours that sync directly to your
                        comfort level.</p>
                </div>
                <div class="about-pillar-card">
                    <h3>Human support</h3>
                    <p>Trader success specialists are on-call to help configure portfolios, decipher analytics, and align
                        strategies with your goals.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Values -->
    <section class="about-values">
        <div class="container">
            <div class="about-values-grid">
                <div class="about-value-card">
                    <h4>Regulated execution partners</h4>
                    <p>We only route orders through regulated brokers and custodians, giving every copier robust safeguards
                        and segregation of funds.</p>
                </div>
                <div class="about-value-card">
                    <h4>Security and privacy</h4>
                    <p>Two-factor authentication, session monitoring, and encrypted data protocols protect your account
                        activity end to end.</p>
                </div>
                <div class="about-value-card">
                    <h4>Performance alignment</h4>
                    <p>Lead traders earn success fees only when you profit, ensuring incentives stay aligned with your
                        outcomes.</p>
                </div>
                <div class="about-value-card">
                    <h4>Global reach, local insight</h4>
                    <p>From forex to crypto and equities, our strategist network spans every time zone, offering diversified
                        expertise 24/7.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="about-cta">
        <div class="container">
            <h2>Ready to mirror strategies with confidence?</h2>
            <p>Create your portfolio, pick top performers, and copy trades with instant execution that respects your risk
                limits.</p>
            <div class="cta-actions">
                <a href="{{ route('register') }}" class="btn-primary">Discover Strategies</a>
                <a href="{{ route('home') }}#explore" class="btn-secondary">Browse Trader Leaderboard</a>
            </div>
        </div>
    </section>
@endsection