<?php

namespace App\Providers;

use League\Flysystem\Filesystem;
// use League\Flysystem\Sftp\SftpAdapter;
use Illuminate\Support\Facades\View;
use App\Models\Settings;
use App\Models\SettingsCont;
use App\Models\TermsPrivacy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage as FacadesStorage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // FacadesStorage::extend('sftp', function ($app, $config) {
        //     return new Filesystem(new SftpAdapter($config));
        // });

        $defaultMailer = config('mail.default');
        $smtpHost = config('mail.mailers.smtp.host');

        if ($defaultMailer === 'smtp' && blank($smtpHost)) {
            Config::set('mail.default', 'array');
            Log::warning('MAIL_HOST is not configured. Falling back to the array mailer for this request.');
        }

        Paginator::defaultView('vendor.pagination.fintech');
        Paginator::defaultSimpleView('vendor.pagination.fintech-simple');

        // Sharing settings with all view
        try {
            $settings = Settings::where('id', '1')->first();
            $terms = Schema::hasTable((new TermsPrivacy())->getTable())
                ? TermsPrivacy::current()
                : null;
            $moreset = SettingsCont::find(1);

            View::share('settings', $settings);
            View::share('terms', $terms);
            View::share('moresettings', $moreset);
            View::share('unreadNotifications', collect());
            View::share('notifications', collect());
            View::share('count', 0);

            if ($settings) {
                View::share('mod', $settings->modules);
            }
        } catch (\Exception $e) {
            // Database tables might not exist yet
        }
    }
}
