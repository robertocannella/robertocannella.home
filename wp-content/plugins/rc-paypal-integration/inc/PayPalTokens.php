<?php

class PayPalTokens
{
    private string $base;
    public CurlHandle $ch;
    protected string $APP_SECRET;
    protected string $CLIENT_ID;// { CLIENT_ID, APP_SECRET } = process.env; // pull from environment variables
    protected string $ACCESS_TOKEN;
    public function __construct($base)
    {
        $this->base = $base; // base URL will need to change for production applications


        If(wp_get_environment_type() === 'development') {
            print "<p>Development Environment</p>";

            // do something
        } else {
            // do something
            print "<p>PRODUCTION</p>";
            $this->APP_SECRET = PAYPAL_APP_SECRET;
            $this->CLIENT_ID = PAYPAL_CLIENT_ID;
        }
        $this->generateAccessToken();

    }
    public function curlQuery($url) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

        $json = curl_exec($ch);

        curl_close($ch);

        $array = json_decode($json);
        return var_dump($array);
    }
    public function generateClientToken():void{

    }
    public function generateAccessToken(): void{
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->base . "/v1/oauth2/token");
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSLVERSION , 6); //NEW ADDITION
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->CLIENT_ID.":".$this->APP_SECRET);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

        $result = curl_exec($ch);

        if(empty($result))die("Error: No response.");
        else
        {
            echo "SUCCESS!\n";
            $json = json_decode($result);
            $this->ACCESS_TOKEN = $json->access_token;
        }

        curl_close($ch); //THIS CODE IS NOW WORKING!

    }
    public function dumpThis(): void{
        var_dump($this);
    }

}
