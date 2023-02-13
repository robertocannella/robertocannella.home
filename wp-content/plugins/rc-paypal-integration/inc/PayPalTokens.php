<?php

class PayPalTokens
{
    protected   string          $app_secret;        /* the App's key, loaded from wp-config                          */
    private     string          $base;              /* the base url of the API endpoint                              */
    protected   string          $client_id;         /* the App's client id, loaded from wp-config                    */
    public      string          $client_token;      /* the client token, used to authenticate the current session    */


    public function __construct($base)
    {
        $this->base = $base; // base URL will need to change for production applications
        If(wp_get_environment_type() === 'development') {
            echo "<p>Development Environment</p>";
            echo "<br>Check your app API Keys";

        } else {
            $this->app_secret   = PAYPAL_APP_SECRET; // Defined in wp-config.php
            $this->client_id    = PAYPAL_CLIENT_ID;  // Defined in wp-config.php
        }

    }
    // Implement this function to clean up this class.
    public function curlQuery($url, $headers) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

        $json = curl_exec($ch);

        curl_close($ch);

        $array = json_decode($json);
        return var_dump($array);
    }
    public function generateClientToken():string{
        /* TODO: add check for expiration of token */
        $access_token = $this->generateAccessToken();
        if(!$access_token)die("Error: No access token.");

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->base . '/v1/identity/generate-token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer ' . $access_token;
        $headers[] = 'Accept-Language: en_US';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }

        $this->client_token = $result;
        curl_close($ch);
        return $this->client_token;
    }
    public function generateAccessToken(): string{
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->base . "/v1/oauth2/token");
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSLVERSION , 6); //NEW ADDITION
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->client_id.":".$this->app_secret);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

        $result = curl_exec($ch);

        if(empty($result))die("Error: No response.");
        else {
            $json = json_decode($result);
            return $json->access_token;
        }
        curl_close($ch);
    }
}
