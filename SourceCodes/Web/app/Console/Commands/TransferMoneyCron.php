<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Admin\Event;
use Illuminate\Support\Facades\Config;
use App\Models\Admin\Order;
use App\Models\TransferPayment;
use App\Models\Admin\StripeAccount;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;
use Prophecy\Doubler\Generator\Node\ReturnTypeNode;

class TransferMoneyCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfer:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transfer money to promoter after 5 day`s of completion of event';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $collection = Event::where('status', 1)->get();
            $events = $collection->map(function ($event, $key) {
                if (date('Y-m-d', strtotime($event->end_date . ' + 5 days')) == date('Y-m-d')) {
                    $orders = Order::where('event_id', $event->id)
                        ->where('sender_id', '!=', Config::get('constants.ADMIN_TYPE'))
                        ->selectRaw("SUM(total_price) as total_price, sender_id")
                        ->groupBy('sender_id')
                        ->get();
                    \Stripe\Stripe::setApiKey(config('constants.STRIPE_SECRET'));
                    foreach ($orders as $order) {
                        $user_data = User::select('id', 'email')->findOrFail($order->sender_id);
                        $promoter_stripe_id = StripeAccount::where('email', $user_data->email)->first()->stripe_accountid;
                        if (!empty($promoter_stripe_id)) {
                            // Create a Transfer to a connected account (later):
                            $transfer = \Stripe\Transfer::create([
                                'amount' => $order->total_price * 100,
                                'currency' => 'usd',
                                'destination' => $promoter_stripe_id,
                                'description' => $order->total_price . ' USD transferred to this promoter id ' . $promoter_stripe_id,
                                'transfer_group' => '{ORDER10}',
                            ]);
                            if (!empty($transfer)) {
                                $payment_response = $this->successResponse($transfer);
                                TransferPayment::create([
                                    'event_id' => $event->id,
                                    'admin_id' => Config::get('constants.ADMIN_TYPE'),
                                    'promoter_id' => $order->sender_id,
                                    'payment_status' => 'succeeded',
                                    'payment_response' => json_encode($payment_response),
                                    'total_price' => $order->total_price,
                                ]);
                                Log::channel('stripetransferpaymentlog')->info($payment_response);
                            }
                        }
                    }
                }
            });
            dd("Payment transferred successfully!");
        } catch (\Stripe\Exception\CardException $e) {
            Log::channel('stripetransferpaymentlog')->info($e);
        } catch (\Exception $exception) {
            Log::channel('stripetransferpaymentlog')->info($exception);
        }
    }

    public function successResponse($transfer)
    {
        $payment_response = [
            'id' => $transfer->id,
            'object' => $transfer->object,
            'amount' => $transfer->amount / 100,
            'amount_reversed' => $transfer->amount_reversed / 100,
            'balance_transaction' => $transfer->balance_transaction,
            'created' => $transfer->created,
            'currency' => $transfer->currency,
            'description' => $transfer->description,
            'destination' => $transfer->destination,
            'destination_payment' => $transfer->destination_payment,
            'livemode' => $transfer->livemode,
            'metadata' => $transfer->metadata,
            'reversals' => $transfer->reversals,
            'reversed' => $transfer->reversed,
            'source_transaction' => $transfer->source_transaction,
            'source_type' => $transfer->source_type,
            'transfer_group' => $transfer->transfer_group,
        ];
        return $payment_response;
    }
}
