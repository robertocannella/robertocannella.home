<?php

//*******************************************************
//
// PayPal API - Subscription Service
//
// Name: Roberto Cannella
//
// Date: 02-13-2022
//
// Description: This contains PayPal API CRUD
// implementations for PayPal Subscriptions.
//
//********************************************************

require_once plugin_dir_path(__FILE__) . 'PayPalTokens.php';

class PayPalService
{
    private     string          $base;              /* the base url of the API endpoint                         */
    public      string          $access_token;      /* the access token, to authenticate the current session    */
    private     PayPalTokens    $payPalTokens;      /* access tokens                                            */

    public function __construct($base)
    {
        $this->base = $base; // base URL will need to change for production applications
        $this->payPalTokens = new PayPalTokens($base);
        $this->access_token = $this->payPalTokens->generateAccessToken();

    }
    public function getPlanById(string $id) : stdClass{
        $url = "/v1/billing/plans/{$id}";
        return $this->curlQuery($url);
    }
    public function createProduct($product_id):stdClass{
        $url = "/v1/catalogs/products";

        // This API call takes additional headers
        $headers = [];
        $headers[] = 'Accept: application/json';
        $headers[] = "Paypal-Request-Id: {$product_id}";

        // TODO: This is the POST Field - should be set dynamically
        $post_fields = "{\n  \"name\": \"Audio Streaming Service\",\n  \"description\": \"A video streaming service\",\n  \"type\": \"SERVICE\",\n  \"category\": \"SOFTWARE\",\n  \"image_url\": \"https://example.com/streaming.jpg\",\n  \"home_url\": \"https://example.com/home\"\n}";

        return $this->curlQuery($url,$post_fields,$headers);

    }
    public function createPlan($plan_id): stdClass {
        $url = "/v1/billing/plans";

        // This API call takes additional headers
        $headers = [];
        $headers[] = 'Accept: application/json';
        $headers[] = "Paypal-Request-Id: {$plan_id}";

        // TODO: This is the POST Field - should be set dynamically
        // PROD-89W43873RS2839202
        // PROD-61K43994NA594104X
        $post_fields = "{\n      \"product_id\": \"PROD-89W43873RS2839202\",\n      \"name\": \"Basic Plan\",\n      \"description\": \"Basic plan\",\n      \"billing_cycles\": [\n        {\n          \"frequency\": {\n            \"interval_unit\": \"MONTH\",\n            \"interval_count\": 1\n          },\n          \"tenure_type\": \"TRIAL\",\n          \"sequence\": 1,\n          \"total_cycles\": 1\n        },\n        {\n          \"frequency\": {\n            \"interval_unit\": \"MONTH\",\n            \"interval_count\": 1\n          },\n          \"tenure_type\": \"REGULAR\",\n          \"sequence\": 2,\n          \"total_cycles\": 12,\n          \"pricing_scheme\": {\n            \"fixed_price\": {\n              \"value\": \"10\",\n              \"currency_code\": \"USD\"\n            }\n          }\n        }\n      ],\n      \"payment_preferences\": {\n        \"auto_bill_outstanding\": true,\n        \"setup_fee\": {\n          \"value\": \"10\",\n          \"currency_code\": \"USD\"\n        },\n        \"setup_fee_failure_action\": \"CONTINUE\",\n        \"payment_failure_threshold\": 3\n      },\n      \"taxes\": {\n        \"percentage\": \"10\",\n        \"inclusive\": false\n      }\n    }";

        return $this->curlQuery($url,$post_fields,$headers);
    }
    public function listPlans():stdClass{
        $url = "/v1/billing/plans?page_size=10&page=1&total_required=true";
        return $this->curlQuery($url);
    }

    /**
     * Base CURL query, can be augmented by passing additional parameters
     *
     * @Param   string       $url            The API Endpoint
     * @param   string|null  $post_fields    Post Fields Pass a stringified JSON Object
     * @Param   array        $headers        Additional Headers
     * @return  stdClass
     * @Author  Roberto Cannella
     */
    public function curlQuery(string $url , string $post_fields = null, array $headers = []):stdClass {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->base . $url);
        if ($post_fields){
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer ' . $this->access_token;
        $headers[] = 'Accept-Language: en_US';

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $json = curl_exec($ch);

        curl_close($ch);
        return json_decode($json);
    }
}