import axios from "axios";

class PayPalService {

        constructor(accessToken, baseURL) {
            this.baseURL = baseURL
            this.api = axios.create({
                baseURL: baseURL,
                headers: {

                    'content-type': 'application/json',
                    'X-WP-Nonce': rcPluginSiteData.nonceX,
                    'Authentication' : `Bearer ${accessToken}`,
                    'PayPal-Request-Id' : Math.random()
                }
            });

        }

        async getOrders(){

            //const response = await this.api.get(this.baseURL + '/v1/billing/plans?page_size=10&page=1&total_required=true')
            try{
                console.log("Trying");
                const response = await this.api.get('https://api-m.paypal.com/v1/billing/plans?page_size=10&page=1&total_required=true');

            }catch (error){
                console.log("Failed")
                return error;

            }


        }

}

export default PayPalService;
