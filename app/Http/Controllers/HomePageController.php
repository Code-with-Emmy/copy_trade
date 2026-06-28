<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactInquiryRequest;
use App\Models\User;
use App\Models\Settings;
use App\Models\Plans;
use App\Models\Agent;
use App\Models\UserPlan;
use App\Models\Admin;
use App\Models\Faq;
use App\Models\Images;
use App\Models\Testimony;
use App\Models\Content;
use App\Models\Asset;
use Illuminate\Support\Facades\Validator;
use App\Models\Mt4Details;
use App\Models\Deposit;
use App\Models\Wdmethod;
use App\Models\Withdrawal;
use App\Models\CpTransaction;
use App\Models\TermsPrivacy;
use App\Models\TpTransaction;
use App\Models\Trader;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Mail\NewNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Services\LeaderboardService;
use App\Services\TraderMarketplaceService;

class HomePageController extends Controller
{
    private TraderMarketplaceService $marketplaceService;
    private LeaderboardService $leaderboardService;

    public function __construct(
        TraderMarketplaceService $marketplaceService,
        LeaderboardService $leaderboardService
    ) {
        $this->marketplaceService = $marketplaceService;
        $this->leaderboardService = $leaderboardService;
    }

    public function index()
    {
        $settings = Settings::where('id', '=', '1')->first();

        //sum total deposited
        $total_deposits = DB::table('deposits')->select(DB::raw("SUM(amount) as total"))->
            where('status', 'Processed')->get();

        //sum total withdrawals
        $total_withdrawals = DB::table('withdrawals')->select(DB::raw("SUM(amount) as total"))->
            where('status', 'Processed')->get();

        $btcStats = $this->getBitcoinStats();

        // Safely load trader data — tables may not exist yet on a fresh deployment
        try {
            $featuredTraders    = Trader::query()->active()->with('metric')->where('is_featured', true)->limit(3)->get();
            $marketplaceSections = $this->marketplaceService->sections();
            $leaderboards       = $this->leaderboardService->boards();
            $platformStats      = $this->platformStats();
        } catch (\Throwable $e) {
            \Log::warning('HomePageController: Could not load trader data — ' . $e->getMessage());
            $featuredTraders    = collect();
            $marketplaceSections = ['featured' => collect(), 'top_ranked' => collect(), 'trending' => collect(), 'recent' => collect(), 'watchlist_ids' => []];
            $leaderboards       = ['top_roi' => collect(), 'lowest_drawdown' => collect(), 'most_copied' => collect(), 'trending' => collect()];
            $platformStats      = ['active_investors' => 0, 'assets_copied' => 0, 'average_monthly_returns' => 0, 'verified_traders' => 0, 'executed_trades' => 0, 'active_subscriptions' => 0];
        }

        return view('home.index')->with(array(
            'settings'           => $settings,
            'total_users'        => User::count(),
            'plans'              => Plans::all(),
            'total_deposits'     => $total_deposits,
            'total_withdrawals'  => $total_withdrawals,
            'faqs'               => Faq::orderby('id', 'desc')->get(),
            'test'               => Testimony::orderby('id', 'desc')->get(),
            'withdrawals'        => Withdrawal::orderby('id', 'DESC')->take(7)->get(),
            'deposits'           => Deposit::orderby('id', 'DESC')->take(7)->get(),
            'title'              => $settings->site_title,
            'btcStats'           => $btcStats,
            'mplans'             => Plans::where('type', 'Main')->get(),
            'pplans'             => Plans::where('type', 'Promo')->get(),
            'featuredTraders'    => $featuredTraders,
            'marketplaceSections' => $marketplaceSections,
            'leaderboards'       => $leaderboards,
            'platformStats'      => $platformStats,
        ));
    }

    //Licensing and registration route
    public function licensing()
    {

        return view('home.licensing')
            ->with(array(
                'mplans' => Plans::where('type', 'Main')->get(),
                'pplans' => Plans::where('type', 'Promo')->get(),
                'title' => 'Licensing, regulation and registration',
                'settings' => Settings::where('id', '=', '1')->first(),
            ));
    }

    //Terms of service route
    public function terms()
    {
        return view('home.terms')
            ->with(array(
                'mplans' => Plans::where('type', 'Main')->get(),
                'title' => 'Terms of Service',
                'settings' => Settings::where('id', '=', '1')->first(),
                'terms' => TermsPrivacy::current(),
            ));
    }

    //Privacy policy route
    public function privacy()
    {
        return view('home.privacy')
            ->with(array(
                'mplans' => Plans::where('type', 'Main')->get(),
                'title' => 'Privacy Policy',
                'settings' => Settings::where('id', '=', '1')->first(),
                'terms' => TermsPrivacy::current(),
            ));
    }

    //FAQ route
    public function faq()
    {

        return view('home.faq')
            ->with(array(
                'title' => 'FAQs',
                'faqs' => Faq::orderby('id', 'desc')->get(),
                'settings' => Settings::where('id', '=', '1')->first(),
            ));
    }

    //why-us
    public function whyus()
    {

        return view('home.whyus')
            ->with(array(
                'title' => 'why-us',

                'settings' => Settings::where('id', '=', '1')->first(),
            ));
    }
    //ETFS
    public function etfs()
    {

        return view('home.etfs')
            ->with(array(
                'title' => 'ETFS',

                'settings' => Settings::where('id', '=', '1')->first(),
            ));
    }


    public function copy()
    {

        return view('home.copy')
            ->with(array(
                'title' => 'copy',

                'settings' => Settings::where('id', '=', '1')->first(),
            ));
    }

    public function trade()
    {

        return view('home.trade')
            ->with(array(
                'title' => 'trade',

                'settings' => Settings::where('id', '=', '1')->first(),
            ));
    }

    public function automate()
    {

        return view('home.automate')
            ->with(array(
                'title' => 'automate',

                'settings' => Settings::where('id', '=', '1')->first(),
            ));
    }

    //ETFS
    public function indices()
    {

        return view('home.indices')
            ->with(array(
                'title' => 'Indices',

                'settings' => Settings::where('id', '=', '1')->first(),
            ));
    }

    //Nfts
    public function nfts()
    {

        return view('home.nfts')
            ->with(array(
                'title' => 'NFTS',

                'settings' => Settings::where('id', '=', '1')->first(),
            ));
    }

    public function shares()
    {

        return view('home.shares')
            ->with(array(
                'title' => 'Shares',

                'settings' => Settings::where('id', '=', '1')->first(),
            ));
    }


    //Forex
    public function forex()
    {

        return view('home.forex')
            ->with(array(
                'title' => 'Forex',

                'settings' => Settings::where('id', '=', '1')->first(),
            ));
    }

    public function regulation()
    {

        return view('home.regulation')
            ->with(array(
                'title' => ' regulation',

                'settings' => Settings::where('id', '=', '1')->first(),
            ));
    }


    //fortrader route
    public function fortrader()
    {

        return view('home.fortrader')
            ->with(array(
                'title' => 'for-trader',

                'settings' => Settings::where('id', '=', '1')->first(),
            ));
    }
    ///cryptocurrencies



    public function cryptocurrencies()
    {

        return view('home.cryptocurrencies')
            ->with(array(
                'title' => 'cryptocurrencies',

                'settings' => Settings::where('id', '=', '1')->first(),
            ));
    }
    ///trading-conditions
    public function trading_conditions()
    {

        return view('home.trading-conditions')
            ->with(array(
                'title' => 'trading conditions',

                'settings' => Settings::where('id', '=', '1')->first(),
            ));
    }
    //about route
    public function about()
    {

        return view('home.about')
            ->with(array(
                'mplans' => Plans::where('type', 'Main')->get(),

                'title' => 'About',
                'settings' => Settings::where('id', '=', '1')->first(),
            ));
    }

    //Contact route
    public function contact()
    {
        return view('home.contact')
            ->with(array(
                'mplans' => Plans::where('type', 'Main')->get(),
                'pplans' => Plans::where('type', 'Promo')->get(),

                'title' => 'Contact',
                'settings' => Settings::where('id', '=', '1')->first(),
            ));
    }

    public function pricing()
    {
        return view('home.pricing', [
            'title' => 'Pricing',
            'plans' => Plans::query()->orderBy('min_price')->get(),
            'settings' => Settings::query()->find(1),
            'faqs' => Faq::query()->latest()->take(6)->get(),
        ]);
    }

    public function riskDisclosure()
    {
        return view('home.risk-disclosure', [
            'title' => 'Risk Disclosure',
            'settings' => Settings::query()->find(1),
            'terms' => TermsPrivacy::current(),
        ]);
    }



    //send contact message to admin email
    public function sendcontact(ContactInquiryRequest $request)
    {
        $settings = Settings::where('id', '1')->first();
        $objDemo = new \stdClass();
        $payload = $request->validated();

        $objDemo->message = substr(wordwrap($payload['message'], 70), 0, 350);
        $objDemo->sender = "$settings->site_name";
        $objDemo->date = \Carbon\Carbon::Now();
        $objDemo->subject = "{$payload['subject']}, my email {$payload['email']}";

        try {
            Mail::bcc($settings->contact_email)->send(new NewNotification($objDemo->message, $objDemo->subject, 'Admin'));
        } catch (\Exception $e) {
            \Log::error('Failed to send contact email notification. Subject: ' . $payload['subject'] . ', Email: ' . $payload['email'] . '. Error: ' . $e->getMessage());
        }

        return redirect()->back()
            ->with('success', ' Your message was sent successfully!');
    }

    /**
     * Fetch Bitcoin statistics from CoinGecko API
     *
     * @return array
     */
    private function getBitcoinStats()
    {
        try {
            $response = Http::get('https://api.coingecko.com/api/v3/coins/bitcoin');

            if ($response->successful()) {
                $data = $response->json();

                return [
                    'price' => $data['market_data']['current_price']['usd'],
                    'volume_24h' => $data['market_data']['total_volume']['usd'],
                    'ath' => $data['market_data']['ath']['usd'],
                    'circulating_supply' => $data['market_data']['circulating_supply'],
                    'change_24h_percent' => $data['market_data']['price_change_percentage_24h'],
                    'market_cap' => $data['market_data']['market_cap']['usd'],
                ];
            }
        } catch (\Exception $e) {
            // Log error or handle as needed
            \Log::error('Failed to fetch Bitcoin stats: ' . $e->getMessage());
        }

        // Return default values if API call fails
        return [
            'price' => 0,
            'volume_24h' => 0,
            'ath' => 0,
            'circulating_supply' => 0,
            'change_24h_percent' => 0,
            'market_cap' => 0,
        ];
    }

    /**
     * Fetch live market data for ticker and market list widgets
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMarketData(Request $request)
    {
        try {
            // Fetch popular assets from CryptoCompare
            $symbols = 'BTC,ETH,XRP,ADA,SOL,DOT,DOGE,LTC,LINK,MATIC';
            $response = Http::get("https://min-api.cryptocompare.com/data/pricemultifull?fsyms={$symbols}&tsyms=USD");

            if ($response->successful()) {
                $rawData = $response->json();
                $displayData = $rawData['DISPLAY'] ?? [];
                $data = [];

                foreach ($displayData as $symbol => $values) {
                    $usd = $values['USD'];
                    $data[] = [
                        'name' => $symbol . " / USD",
                        'subName' => $rawData['RAW'][$symbol]['USD']['FROMSYMBOL'] ?? $symbol,
                        'current' => str_replace('$', '', $usd['PRICE']),
                        'change' => str_replace('$', '', $usd['CHANGE24HOUR']),
                        'percentage' => $usd['CHANGEPCT24HOUR'] . '%',
                        'logo' => "https://www.cryptocompare.com" . ($rawData['RAW'][$symbol]['USD']['IMAGEURL'] ?? '')
                    ];
                }

                return response()->json($data);
            }
        } catch (\Exception $e) {
            \Log::error('Failed to fetch Market Data: ' . $e->getMessage());
        }

        // Fallback or empty response
        return response()->json([]);
    }

    private function platformStats(): array
    {
        $processedDeposits = (float) DB::table('deposits')
            ->where('status', 'Processed')
            ->sum('amount');

        $activeSubscriptions = DB::table('user_copytradings')
            ->whereIn('status', ['active', 'paused'])
            ->count();

        $verifiedTraders = Trader::query()->where('verification_status', 'verified')->count();
        $avgMonthlyReturn = round((float) Trader::query()->avg('monthly_roi'), 2);
        $executedTrades = DB::table('copied_trades')->count();

        return [
            'active_investors' => User::count(),
            'assets_copied' => $processedDeposits,
            'average_monthly_returns' => $avgMonthlyReturn,
            'verified_traders' => $verifiedTraders,
            'executed_trades' => $executedTrades,
            'active_subscriptions' => $activeSubscriptions,
        ];
    }
}
