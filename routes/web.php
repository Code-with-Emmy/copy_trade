<?php

use App\Http\Controllers\Admin\ClearCacheController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Models\Settings;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use App\Http\Controllers\AutoTaskController;
use App\Http\Controllers\AutoRoiController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PublicTraderController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__ . '/admin/web.php';
require __DIR__ . '/admin/notification.php';
require __DIR__ . '/user/web.php';
require __DIR__ . '/user/plan-routes.php';
require __DIR__ . '/botman.php';

// Language Routes
Route::post('/change-language', [LanguageController::class, 'changeLanguage'])->name('change.language');
Route::get('/language/{locale}', [LanguageController::class, 'switchLanguage'])->name('language.switch');
Route::get('/current-language', [LanguageController::class, 'getCurrentLanguage'])->name('current.language');

//new plan system cron url
Route::get('/cron/roi', [AutoRoiController::class, 'processAutomaticRoi'])->name('cron.roi');

//Front Pages Route
Route::get('/', [HomePageController::class, 'index'])->name('home');

// Account Blocked Page
Route::get('/account-blocked', function () {
    $settings = \App\Models\Settings::first();
    return view('auth.account-blocked', compact('settings'));
})->name('account.blocked');

Route::get('terms', [HomePageController::class, 'terms'])->name('terms');
Route::get('privacy', [HomePageController::class, 'privacy'])->name('privacy');
Route::get('pricing', [HomePageController::class, 'pricing'])->name('pricing');
Route::get('risk-disclosure', [HomePageController::class, 'riskDisclosure'])->name('risk.disclosure');
Route::get('about', [HomePageController::class, 'about'])->name('about');
Route::get('contact', [HomePageController::class, 'contact'])->name('contact');
Route::post('contact', [HomePageController::class, 'sendcontact'])->name('contact.send');
Route::get('faq', [HomePageController::class, 'faq'])->name('faq');
Route::get('traders', [PublicTraderController::class, 'index'])->name('traders.index');
Route::get('traders/{slug}', [PublicTraderController::class, 'show'])->name('traders.show');
Route::get('why-us', [HomePageController::class, 'whyus'])->name('why-us');
Route::get('regulation', [HomePageController::class, 'regulation'])->name('regulation');
Route::get('etfs', [HomePageController::class, 'etfs'])->name('etfs');
Route::get('forex', [HomePageController::class, 'forex'])->name('forex');
Route::get('for-traders', [HomePageController::class, 'fortrader'])->name('fortrader');
Route::get('trading-conditions', [HomePageController::class, 'terms'])->name('trading_conditions');
Route::get('cryptocurrencies', [HomePageController::class, 'cryptocurrencies'])->name('cryptocurrencies');
Route::get('indices', [HomePageController::class, 'indices'])->name('indices');
Route::get('shares', [HomePageController::class, 'shares'])->name('shares');
Route::get('nfts', [HomePageController::class, 'nfts'])->name('nfts');
Route::get('trade', [HomePageController::class, 'trade'])->name('trade');
Route::get('automate', [HomePageController::class, 'automate'])->name('automate');
Route::get('copy', [HomePageController::class, 'copy'])->name('copy');

// New Frontend Routes
Route::get('markets', function () {
    return view('home.markets');
})->name('markets');
Route::get('blog', function () {
    return view('home.blog');
})->name('blog');
Route::get('careers', function () {
    return view('home.careers');
})->name('careers');
Route::get('customers', function () {
    return view('home.customers');
})->name('customers');
Route::get('education', function () {
    return view('home.education');
})->name('education');
Route::get('roadmap', function () {
    return view('home.roadmap');
})->name('roadmap');

Route::get('api/market-data', [HomePageController::class, 'getMarketData'])->name('api.market_data');

// Auth routes are handled by Laravel Fortify


Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return "Cache Cleared";
});

Route::get('/add-ssn-column', function () {
    try {
        $messages = [];

        if (!\Illuminate\Support\Facades\Schema::hasColumn('kycs', 'ssn')) {
            \Illuminate\Support\Facades\Schema::table('kycs', function (\Illuminate\Database\Schema\Blueprint $table) {
                $table->string('ssn')->nullable()->after('dob');
            });
            $messages[] = "SSN column added.";
        } else {
            $messages[] = "SSN column already exists.";
        }

        if (!\Illuminate\Support\Facades\Schema::hasColumn('kycs', 'face_img')) {
            \Illuminate\Support\Facades\Schema::table('kycs', function (\Illuminate\Database\Schema\Blueprint $table) {
                $table->string('face_img')->nullable()->after('backimg');
            });
            $messages[] = "Face Img column added.";
        } else {
            $messages[] = "Face Img column already exists.";
        }

        return implode(" ", $messages);
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});
