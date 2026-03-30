<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CopySubscription;
use App\Models\PlatformTransaction;
use App\Models\Trader;
use App\Models\UserCopytrading;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CopyTradingAdminController extends Controller
{
    /**
     * Display all expert traders
     */
    public function index()
    {
        $experts = Trader::query()
            ->with('metric')
            ->withCount(['copiers', 'activeCopiers as active_copiers_count'])
            ->orderByDesc('is_featured')
            ->orderByDesc('monthly_roi')
            ->paginate(20);
        $title = 'Manage Expert Traders';
        
        return view('admin.copy.index', compact('experts', 'title'));
    }

    /**
     * Show form to create new expert trader
     */
    public function create()
    {
        $title = 'Add New Expert Trader';
        return view('admin.copy.create', compact('title'));
    }

    /**
     * Store new expert trader
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'required|integer|min:1|max:5',
            'equity' => 'required|numeric|min:0',
            'total_profit' => 'required|numeric|min:0',
            'win_rate' => 'required|integer|min:0|max:100',
            'total_trades' => 'required|integer|min:0',
            'price' => 'required|numeric|min:1',
            'followers' => 'nullable|integer|min:0',
            'tag' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'bio' => 'nullable|string',
            'strategy_type' => 'nullable|string|max:255',
            'trading_style' => 'nullable|string|max:255',
            'risk_level' => 'nullable|string|max:32',
            'monthly_roi' => 'nullable|numeric',
            'yearly_roi' => 'nullable|numeric',
            'max_drawdown' => 'nullable|numeric|min:0',
            'aum' => 'nullable|numeric|min:0',
            'minimum_allocation' => 'nullable|numeric|min:0',
            'maximum_allocation' => 'nullable|numeric|min:0',
            'management_fee_percent' => 'nullable|numeric|min:0|max:100',
            'performance_fee_percent' => 'nullable|numeric|min:0|max:100',
            'verification_status' => 'nullable|in:pending,verified,rejected',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->except('photo');
            
            // Handle photo upload
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $filename = time() . '_' . $photo->getClientOriginalName();
                $path = $photo->storeAs('copy-experts', $filename, 'public');
                $data['photo'] = $path;
            }

            Trader::query()->create($data);

            return redirect()->route('admin.copy.index')
                           ->with('success', 'Expert trader added successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add expert trader. Please try again.');
        }
    }

    /**
     * Show form to edit expert trader
     */
    public function edit($id)
    {
        $expert = Trader::query()->findOrFail($id);
        $title = 'Edit Expert Trader';
        
        return view('admin.copy.edit', compact('expert', 'title'));
    }

    /**
     * Update expert trader
     */
    public function update(Request $request, $id)
    {
        $expert = Trader::query()->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'required|integer|min:1|max:5',
            'equity' => 'required|numeric|min:0',
            'total_profit' => 'required|numeric|min:0',
            'win_rate' => 'required|integer|min:0|max:100',
            'total_trades' => 'required|integer|min:0',
            'price' => 'required|numeric|min:1',
            'followers' => 'nullable|integer|min:0',
            'tag' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'bio' => 'nullable|string',
            'strategy_type' => 'nullable|string|max:255',
            'trading_style' => 'nullable|string|max:255',
            'risk_level' => 'nullable|string|max:32',
            'monthly_roi' => 'nullable|numeric',
            'yearly_roi' => 'nullable|numeric',
            'max_drawdown' => 'nullable|numeric|min:0',
            'aum' => 'nullable|numeric|min:0',
            'minimum_allocation' => 'nullable|numeric|min:0',
            'maximum_allocation' => 'nullable|numeric|min:0',
            'management_fee_percent' => 'nullable|numeric|min:0|max:100',
            'performance_fee_percent' => 'nullable|numeric|min:0|max:100',
            'verification_status' => 'nullable|in:pending,verified,rejected',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->except('photo');
            
            // Handle photo upload
            if ($request->hasFile('photo')) {
                // Delete old photo
                $currentPhoto = $expert->photo;
                if ($currentPhoto && Storage::disk('public')->exists($currentPhoto)) {
                    Storage::disk('public')->delete($currentPhoto);
                }

                $photo = $request->file('photo');
                $filename = time() . '_' . $photo->getClientOriginalName();
                $path = $photo->storeAs('copy-experts', $filename, 'public');
                $data['photo'] = $path;
            }

            $expert->update($data);

            return redirect()->route('admin.copy.index')
                           ->with('success', 'Expert trader updated successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update expert trader. Please try again.');
        }
    }

    /**
     * Delete expert trader
     */
    public function destroy($id)
    {
        try {
            $expert = Trader::query()->findOrFail($id);

            // Check if expert has active copiers
            $activeCopiers = UserCopytrading::where('cptrading', $id)
                                             ->where('active', 'yes')
                                             ->count();

            if ($activeCopiers > 0) {
                return back()->with('error', 'Cannot delete expert trader with active copiers.');
            }

            // Delete photo if exists
            $currentPhoto = $expert->photo;
            if ($currentPhoto && Storage::disk('public')->exists($currentPhoto)) {
                Storage::disk('public')->delete($currentPhoto);
            }

            $expert->delete();

            return redirect()->route('admin.copy.index')
                           ->with('success', 'Expert trader deleted successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete expert trader. Please try again.');
        }
    }

    /**
     * View active copy trades
     */
    public function activeTrades()
    {
        $activeTrades = CopySubscription::query()
            ->with(['investor', 'trader'])
            ->where(function ($query) {
                $query->where('status', 'active')
                    ->orWhere('active', 'yes');
            })
            ->latest('created_at')
            ->get();

        $title = 'Active Copy Trades';

        return view('admin.copy.active-trades', compact('activeTrades', 'title'));
    }

    /**
     * View copy trading statistics
     */
    public function statistics()
    {
        $stats = [
            'total_experts' => Trader::query()->count(),
            'active_experts' => Trader::query()->where('status', 'active')->count(),
            'verified_experts' => Trader::query()->where('verification_status', 'verified')->count(),
            'featured_experts' => Trader::query()->where('is_featured', true)->count(),
            'total_copy_trades' => CopySubscription::query()->count(),
            'active_copy_trades' => CopySubscription::query()->where('status', 'active')->count(),
            'paused_copy_trades' => CopySubscription::query()->where('status', 'paused')->count(),
            'total_invested' => CopySubscription::query()->where('status', 'active')->sum('allocation_amount'),
            'total_profit' => CopySubscription::query()->sum('total_profit'),
            'platform_fees' => PlatformTransaction::query()->sum('fee_amount'),
            'total_users_copying' => CopySubscription::query()->where('status', 'active')->distinct('user')->count(),
        ];

        $title = 'Copy Trading Statistics';

        $topExperts = Trader::query()
            ->withCount(['activeCopiers'])
            ->orderByDesc('monthly_roi')
            ->orderByDesc('total_profit')
            ->limit(5)
            ->get();

        $popularExperts = Trader::query()
            ->withCount(['activeCopiers'])
            ->orderByDesc('active_copiers_count')
            ->orderByDesc('followers')
            ->limit(5)
            ->get();

        $recentActivity = CopySubscription::query()
            ->with(['investor', 'trader'])
            ->latest('created_at')
            ->limit(8)
            ->get();

        return view('admin.copy.statistics', compact('stats', 'title', 'topExperts', 'popularExperts', 'recentActivity'));
    }
}
