<?php

require_once plugin_dir_path(__FILE__) . 'PayPalTokens.php';
require_once plugin_dir_path(__FILE__) . 'PayPalService.php';

$BASE_URL        =   PAYPAL_BASE_URL;   // defined in wp-config.php


// TODO: Customize head
get_header();
echo "<p>PayPay Sandbox</p><p></p>";


// Get Client Token for cookie
$tokenGenerator =   new PayPalTokens($BASE_URL);
$tokenResponse  =   json_decode($tokenGenerator->generateClientToken());

// Get Service
$payPalService = new PayPalService($BASE_URL);

// Get Plans
$payload = $payPalService->listPlans();
echo esc_html__('Showing ' . count($payload->plans)  . ' plans.') ;

// CREATE PRODUCTS AND PLANS
//$newProduct = $payPalService->createProduct(uniqid("PRODUCT-"));
//var_dump($newProduct);
//$newPlan = $payPalService->createPlan(uniqid("PlanId"));
//var_dump($newPlan);


// Initialize cookie name
$cookie_name = "paypal_client_token";
$cookie_value = $tokenResponse->client_token;

// Set cookie
setcookie($cookie_name, $cookie_value);
setcookie('clientID', PAYPAL_CLIENT_ID);

// Create Plan Table
?>

<!--Paypal-->

    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- To be replaced with your own stylesheet -->
        <link rel="stylesheet" type="text/css" href="https://www.paypalobjects.com/webstatic/en_US/developer/docs/css/cardfields.css"/>
        <!-- Express fills in the clientId and clientToken variables -->
        <script
                src="https://www.paypal.com/sdk/js?client-id=<?php echo PAYPAL_CLIENT_ID ?>&vault=true&intent=subscription&disable-funding=credit";
                data-client-token="<?php echo $tokenResponse->client_token?>"
        ></script>
    </head>
    <body>
    <div class="pay-tabs">
        <?php

        foreach ($payload->plans as $plan){
            // Parent Node
            $plan_details   =   $payPalService->getPlanById($plan->id);

            // Children Nodes
            $id                 =   $plan_details->id;
            $name               =   $plan_details->name;
            $currency_symbol    =   $plan_details->billing_cycles[0]->pricing_scheme->fixed_price->currency_code == 'USD' ? '$' : '' ;
            $value              =   round($plan_details->billing_cycles[0]->pricing_scheme->fixed_price->value);

            echo    "<div id=\"{$id}\" class=\"rc_paypal_btn " . strtolower($name) . "\">";
            echo        "<div>{$name}</div><div>{$currency_symbol}{$value}</div>";
            echo    "</div>";
        }

        ?>
    </div>

        <?php

        foreach ($payload->plans as $plan){
            // Parent Node
            $plan_details   =   $payPalService->getPlanById($plan->id);

            // Children Nodes
            $id                 =   $plan_details->id;
            $name               =   $plan_details->name;
            $currency_symbol    =   $plan_details->billing_cycles[0]->pricing_scheme->fixed_price->currency_code == 'USD' ? '$' : '' ;
            $value              =   round($plan_details->billing_cycles[0]->pricing_scheme->fixed_price->value);

            echo    "<div data-id=\"{$id}\" class=\"pay-box " .  strtolower($name) . "\">";
            echo        "<div><h3>{$name} Plan {$value}/month</h3></div>";
            echo        "<div id=\"paypal-button-container-" . strtolower($name) . "\" class=\"paypal-button-container ". strtolower($name) . "\"></div>";
            echo    "</div>";

        } ?>


    <script>
        plans = [
            { id: 'P-3KA04903P1415325DMPUBHLQ',class: 'bronze' },
            { id: 'P-31G49173TF2715432MPUR75I',class: 'silver' },
            { id: 'P-9S763715CX3189722MPVEPWQ',class: 'gold' }
        ]
        plans.forEach(plan=>{
            paypal.Buttons({
                createSubscription: function(data, actions) {
                    return actions.subscription.create({
                        'plan_id': plan.id // Creates the subscription
                    });
                },
                onApprove: function(data, actions) {
                    alert('You have successfully created subscription ' + data.subscriptionID); // Optional message given to subscriber
                },
                style: {
                    layout: 'vertical',         /* horizontal, vertical         */
                    color:  'white',            /* white, blue, silver, black   */
                    shape:  'pill',             /* pill, rect                   */
                    label:  'paypal',           /* TODO: find these fields      */

                }
            })
                .render(`#paypal-button-container-${plan.class}`);
        })

    </script>
<?php


/* Verification that the cookie was created                         */
//if (!isset($_COOKIES[$cookie_name])) print("Cookie created | ");

get_footer();

//curl -X POST https://api-m.sandbox.paypal.com/v1/identity/generate-token -H 'Content-Type: application/json' -H 'Authorization: Bearer <ACCESS-TOKEN>' -H 'Accept-Language: en_US'