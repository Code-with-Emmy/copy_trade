<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\InitiateDepositRequest;
use App\Models\Settings;
use App\Services\DepositService;
use App\Services\WalletService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WalletController extends Controller
{
    private WalletService $walletService;
    private DepositService $depositService;

    public function __construct(WalletService $walletService, DepositService $depositService)
    {
        $this->walletService = $walletService;
        $this->depositService = $depositService;
    }

    public function index(): View
    {
        $user = Auth::user();
        $wallet = $this->walletService->syncLegacyBalance($user);

        return view('user.wallet.index', [
            'title' => 'Wallet & Transactions',
            'settings' => Settings::query()->find(1),
            'wallet' => $wallet->load(['ledgers' => fn ($query) => $query->latest()->limit(20), 'transactions' => fn ($query) => $query->latest()->limit(20)]),
        ]);
    }

    public function initiateDeposit(InitiateDepositRequest $request): RedirectResponse
    {
        $result = $this->depositService->initiate(
            Auth::user(),
            $request->float('amount'),
            $request->string('gateway')->toString()
        );

        return back()->with('success', 'Deposit initiated with reference ' . $result['transaction']->reference . '.');
    }
}
