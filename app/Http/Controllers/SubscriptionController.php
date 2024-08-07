<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\ServicePlan;
use App\Models\SystemSetting;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Stripe\WebhookEndpoint;

class SubscriptionController extends Controller
{
    public function redirectUserToStripe(Request $request) {
        $id = $request->id;

// Check if the string is at least 20 characters long to ensure it has enough characters to remove
if (strlen($id) >= 20) {
    // Remove the first ten characters and the last ten characters
    $trimmed_id = substr($id, 10, -10);
    // $trimmedId now contains the string with the first ten and last ten characters removed
}
else {
    throw new Exception("invalid id");
}
        $business = Business::findOrFail($trimmed_id);
        $user = User::findOrFail($business->owner_id);
        Auth::login($user);

        $systemSetting = SystemSetting::first();

        if(!$systemSetting && !$systemSetting->self_registration_enabled) {
            return response()->json([
                "message" => "self registration is not supported"
            ],403);
        }

        Stripe::setApiKey($systemSetting->STRIPE_SECRET);
        Stripe::setClientId($systemSetting->STRIPE_KEY);

        // Retrieve all webhook endpoints from Stripe
$webhookEndpoints = WebhookEndpoint::all();

// Check if a webhook endpoint with the desired URL already exists
$existingEndpoint = collect($webhookEndpoints->data)->first(function ($endpoint) {
    return $endpoint->url === route('stripe.webhook'); // Replace with your actual endpoint URL
});
if (!$existingEndpoint) {
// Create the webhook endpoint
$webhookEndpoint = WebhookEndpoint::create([
    'url' => route('stripe.webhook'),
    'enabled_events' => ['checkout.session.completed'], // Specify the events you want to listen to
]);

}





        $service_plan = ServicePlan::where([
            "id" => $business->service_plan_id
        ])
        ->first();


        if(!$service_plan) {
            return response()->json([
                "message" => "no service plan found"
            ],404);
        }




        if (empty($user->stripe_id)) {
            $stripe_customer = \Stripe\Customer::create([
                'email' => $user->email,
            ]);

            $user->stripe_id = $stripe_customer->id;
            $user->save();
        }



        $session_data = [
            'payment_method_types' => ['card'],
            'metadata' => [
                'our_url' => route('stripe.webhook'),

            ],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'GBP',
                        'product_data' => [
                            'name' => 'Your Service set up amount',
                        ],
                        'unit_amount' => $service_plan->set_up_amount * 100 , // Amount in cents
                    ],
                    'quantity' => 1,
                ],
                [
                    'price_data' => [
                        'currency' => 'GBP',
                        'product_data' => [
                            'name' => 'Your Service monthly amount',
                        ],
                        'unit_amount' => $service_plan->price * 100, // Amount in cents
                        'recurring' => [
                            'interval' => 'month', // Recur monthly
                            'interval_count' => $service_plan->duration_months, // Adjusted duration
                        ],
                    ],
                    'quantity' => 1,
                ],
            ],

            'customer' => $user->stripe_id  ?? null,

            'mode' => 'subscription',
            'success_url' => env("FRONT_END_URL")."/verify/business",
            'cancel_url' => env("FRONT_END_URL")."/verify/business",
        ];





        // Add discount line item only if discount amount is greater than 0 and not null
if (!empty($business->service_plan_discount_amount) && $business->service_plan_discount_amount > 0) {

    // try {
    //     $coupon = \Stripe\Coupon::retrieve($business->service_plan_discount_code, []);
    //     $coupon->amount_off = $business->service_plan_discount_amount * 100;
    //     $coupon->save();
    // } catch (\Stripe\Exception\InvalidRequestException $e) {
    //    return $e->getMessage();
    //     $coupon = \Stripe\Coupon::create([
    //         'amount_off' => $business->service_plan_discount_amount * 100, // Amount in cents
    //         'currency' => 'GBP', // The currency
    //         'duration' => 'once', // Can be once, forever, or repeating
    //         'name' => $business->service_plan_discount_code, // Coupon name
    //         'id' => $business->service_plan_discount_code, // Coupon code
    //     ]);
    // }

    $coupon = \Stripe\Coupon::create([
        'amount_off' => $business->service_plan_discount_amount * 100, // Amount in cents
        'currency' => 'GBP', // The currency
        'duration' => 'once', // Can be once, forever, or repeating
        'name' => $business->service_plan_discount_code, // Coupon name
    ]);

$session_data["discounts"] =  [ // Add the discount information here
    [
        'coupon' => $coupon, // Use coupon ID if created
    ],
];
}

        $session = Session::create($session_data);

        return redirect()->to($session->url);
    }



    public function stripePaymentSuccess (Request $request) {
        return redirect()->away(env("FRONT_END_URL") . '/auth/login');
    }


    public function stripePaymentFailed (Request $request) {
        return redirect()->away(env("FRONT_END_URL") . '/auth/login');
    }




}
