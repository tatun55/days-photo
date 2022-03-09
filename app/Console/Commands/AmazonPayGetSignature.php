<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AmazonPayGetSignature extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:amazonPayGetSignature';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        // dd(config('services.amazon_pay.public_key_id'));
        $amazonpay_config = array(
            'public_key_id' => config('services.amazon_pay.public_key_id'),
            'private_key'   => storage_path('AmazonPay_SANDBOX-AGD5WXBVODNZLYLNPJJEQBUU.pem'),
            'region'        => 'JP',
            'sandbox'       => true
        );

        $client = new \Amazon\Pay\API\Client($amazonpay_config);
        $payload = '{"scopes": ["name", "email", "phoneNumber", "billingAddress"],"storeId":"amzn1.application-oa2-client.9f751aa7eed74bcaab087e055526b188","webCheckoutDetails":{"checkoutReviewReturnUrl":"https://days.photo/order/review"}}';
        $signature = $client->generateButtonSignature($payload);
        echo $signature . "\n";
    }
}