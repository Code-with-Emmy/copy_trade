<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Settings;
use App\Models\Deposit;
use App\Models\TpTransaction;
use App\Mail\DepositStatus;
use App\Traits\PingServer;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ManageDepositController extends Controller
{
    use PingServer;

    protected function depositProofMeta(?string $proof): array
    {
        $proof = trim((string) $proof);

        if ($proof === '') {
            return [
                'kind' => 'missing',
                'url' => null,
                'label' => null,
            ];
        }

        if (Storage::disk('public')->exists($proof)) {
            $extension = strtolower(pathinfo($proof, PATHINFO_EXTENSION));
            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];

            return [
                'kind' => in_array($extension, $imageExtensions, true) ? 'image' : 'file',
                'url' => asset('storage/' . ltrim($proof, '/')),
                'label' => basename($proof),
            ];
        }

        if (Str::startsWith($proof, ['http://', 'https://'])) {
            return [
                'kind' => 'remote',
                'url' => $proof,
                'label' => $proof,
            ];
        }

        return [
            'kind' => 'reference',
            'url' => null,
            'label' => $proof,
        ];
    }

    //Delete deposit
    public function deldeposit($id)
    {
        $deposit = Deposit::where('id', $id)->first();
        Storage::disk('public')->delete($deposit->proof);
        Deposit::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Deposit history has been deleted!');
    }

    //process deposits
    public function pdeposit($id)
    {
        //confirm the users plan
        $deposit = Deposit::where('id', $id)->first();
        $user = User::where('id', $deposit->user)->first();
        //get settings
        $settings = Settings::where('id', '=', '1')->first();
               //update deposits
        Deposit::where('id',$id)
        ->update([
        'status' => 'Processed',
    ]);


        $response = $this->callServer('earnings', '/process-deposit', [
            'referral_commission' => $settings->referral_commission,
            'amount' => $deposit->amount,
            'account_bal' => $user->account_bal,
            'depositBonus' => $settings->deposit_bonus,
        ]);

        if($deposit->user==$user->id){
            //add funds to user's account
            if( $deposit->signals == Null){
            $attributes = User::filterSchemaAttributes([
                'account_bal' => $user->account_bal + $deposit->amount,
                'cstatus' => 'Customer',
            ]);

            if (!empty($attributes)) {
                User::where('id', $user->id)->update($attributes);
            }



        }


        $attributes = User::filterSchemaAttributes([
            'cstatus' => 'Customer',
            'signals' => $deposit->signals ?? ($user->signals ?? null),
            'signal_status' => 'off',
            'plan_status' => 'off',
        ]);

        if (!empty($attributes)) {
            User::where('id', $user->id)->update($attributes);
        }
            //get settings
            $settings=Settings::where('id', '=', '1')->first();
            $earnings=$settings->referral_commission*$deposit->amount/100;

          if (!empty($user->ref_by)) {
                //get agent
                $agent = User::where('id', $user->ref_by)->first();
                User::where('id', $user->ref_by)
                    ->update([
                        'account_bal' => $agent->account_bal + $earnings,
                        'ref_bonus' => $agent->ref_bonus + $earnings,
                    ]);

                //create history
                TpTransaction::create([
                    'user' => $user->ref_by,
                    'plan' => "Credit",
                    'amount'=>$earnings,
                    'type'=>"Ref_bonus",
                ]);

                //credit commission to ancestors
                $deposit_amount = $deposit->amount;
                $array=User::all();
                $parent=$user->id;
                $this->getAncestors($array, $deposit_amount, $parent);
            }

     $deposit = Deposit::where('id', $id)->first();
            //Send confirmation email to user regarding his deposit and it's successful.
            try {
                Mail::to($user->email)->send(new DepositStatus($deposit, $user,'Your Deposit have been Confirmed', false));
            } catch (\Throwable $e) {
                \Log::error('Failed to send deposit confirmation email to user from admin. User: ' . $user->name . ' (' . $user->email . '), Deposit ID: ' . $deposit->id . ', Amount: ' . $deposit->amount . '. Error: ' . $e->getMessage());
            }

        }


        return redirect()->back()->with('success', 'Action Sucessful!');
    }


    public function viewdepositimage($id)
    {
        $deposit = Deposit::where('id', $id)->first();
        $proofMeta = $this->depositProofMeta((string) data_get($deposit, 'proof'));

        return view('admin.Deposits.depositimg', [
            'deposit' => $deposit,
            'proofMeta' => $proofMeta,
            'title' => 'View Deposit Screenshot',
            'settings' => Settings::where('id', '=', '1')->first(),
        ]);
    }


    //Get uplines
    function getAncestors($array, $deposit_amount, $parent = 0, $level = 0)
    {
        $referedMembers = '';
        $parent = User::where('id', $parent)->first();

        foreach ($array as $entry) {
            if ($entry->id == $parent->ref_by) {
                //get settings
                $settings = Settings::where('id', '=', '1')->first();

                if ($level == 1) {
                    $earnings = $settings->referral_commission1 * $deposit_amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $entry->id)
                        ->update([
                            'account_bal' => $entry->account_bal + $earnings,
                            'ref_bonus' => $entry->ref_bonus + $earnings,
                        ]);

                    //create history
                    TpTransaction::create([
                        'user' => $entry->id,
                        'plan' => "Credit",
                        'amount' => $earnings,
                        'type' => "Ref_bonus",
                    ]);
                } elseif ($level == 2) {
                    $earnings = $settings->referral_commission2 * $deposit_amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $entry->id)
                        ->update([
                            'account_bal' => $entry->account_bal + $earnings,
                            'ref_bonus' => $entry->ref_bonus + $earnings,
                        ]);

                    //create history
                    TpTransaction::create([
                        'user' => $entry->id,
                        'plan' => "Credit",
                        'amount' => $earnings,
                        'type' => "Ref_bonus",
                    ]);
                } elseif ($level == 3) {
                    $earnings = $settings->referral_commission3 * $deposit_amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $entry->id)
                        ->update([
                            'account_bal' => $entry->account_bal + $earnings,
                            'ref_bonus' => $entry->ref_bonus + $earnings,
                        ]);

                    //create history
                    TpTransaction::create([
                        'user' => $entry->id,
                        'plan' => "Credit",
                        'amount' => $earnings,
                        'type' => "Ref_bonus",
                    ]);
                } elseif ($level == 4) {
                    $earnings = $settings->referral_commission4 * $deposit_amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $entry->id)
                        ->update([
                            'account_bal' => $entry->account_bal + $earnings,
                            'ref_bonus' => $entry->ref_bonus + $earnings,
                        ]);

                    //create history
                    TpTransaction::create([
                        'user' => $entry->id,
                        'plan' => "Credit",
                        'amount' => $earnings,
                        'type' => "Ref_bonus",
                    ]);
                } elseif ($level == 5) {
                    $earnings = $settings->referral_commission5 * $deposit_amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $entry->id)
                        ->update([
                            'account_bal' => $entry->account_bal + $earnings,
                            'ref_bonus' => $entry->ref_bonus + $earnings,
                        ]);

                    //create history
                    TpTransaction::create([
                        'user' => $entry->id,
                        'plan' => "Credit",
                        'amount' => $earnings,
                        'type' => "Ref_bonus",
                    ]);
                }

                if ($level == 6) {
                    break;
                }

                //$referedMembers .= '- ' . $entry->name . '- Level: '. $level. '- Commission: '.$earnings.'<br/>';
                $referedMembers .= $this->getAncestors($array, $deposit_amount, $entry->id, $level + 1);
            }
        }
        return $referedMembers;
    }

    // for front end content management
    function RandomStringGenerator($n)
    {
        $generated_string = "";
        $domain = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        $len = strlen($domain);
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, $len - 1);
            $generated_string = $generated_string . $domain[$index];
        }
        // Return the random generated string
        return $generated_string;
    }
}
