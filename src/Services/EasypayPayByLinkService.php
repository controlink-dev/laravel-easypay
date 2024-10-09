<?php

namespace Controlink\LaravelEasypay\Services;

use Controlink\LaravelEasypay\Models\EasypayConfiguration;
use Controlink\LaravelEasypay\Models\EasypayCustomer;
use Controlink\LaravelEasypay\Models\EasypayPayByLink;
use Controlink\LaravelEasypay\Models\EasypayPaymentPayByLink;
use Controlink\LaravelEasypay\Http\Controllers\EasypayConfigurationController;
use GuzzleHttp\Client;

class EasypayPayByLinkService
{
    protected $client;

    public function __construct($tenantId = null)
    {
        //Check if the Easypay configuration is set
        if (!config('easypay.pay_by_link')) {
            throw new \Exception('The "pay by link" feature is not enabled. Please enable it in the configuration file.');
        }

        if(config('easypay.multi_tenant')) {
            $configuration = EasypayConfiguration::where(config('easypay.tenant_column_name'), $tenantId)->first();

            if (!$configuration) {
                throw new \Exception('The Easypay configuration for the tenant was not found.');
            }

            // Get the tenant identifier
            $this->client = new Client([
                'base_uri' => $configuration->url,
                'headers' => [
                    'AccountId' => $configuration->account_id,
                    'ApiKey' => $configuration->api_key,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
            ]);
        }else{
            if(!config('easypay.url') || !config('easypay.account_id') || !config('easypay.api_key')){
                throw new \Exception('The Easypay configuration is not set. Please set it in the configuration file.');
            }

            // Initialize Guzzle with the base URL and necessary headers
            $this->client = new Client([
                'base_uri' => config('easypay.url'),
                'headers' => [
                    'AccountId' => config('easypay.account_id'),
                    'ApiKey' => config('easypay.api_key'),
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
            ]);
        }
    }

    /**
     * Create a payment link.
     *
     * @property string $expiration_time The expiration date and time for the payment, in ISO 8601 format (e.g., 2024-10-08T23:59:59.999Z).
     * @property string $type The type of payment (e.g., "SINGLE" for a one-time payment).
     *
     * @property array $customer The customer details for the payment.
     * @property string $customer['name'] The customer's full name (e.g., "João Ribeiro").
     * @property string $customer['email'] The customer's email address (e.g., "joao.ribeiro@controlink.pt").
     * @property string $customer['phone'] The customer's phone number (e.g., "+351926478423").
     * @property string $customer['language'] The customer's preferred language (e.g., "PT" for Portuguese) in ISO 639-1 format.
     *
     * @property array $payment The payment details.
     * @property array $payment['capture'] Capture details for the payment.
     * @property string $payment['capture']['descriptive'] A description for the payment (e.g., "20 SMS's adicionais").
     * @property string $payment['capture']['key'] The unique key for identifying the payment item (e.g., "20_sms").
     * @property array $payment['single'] Information about the single payment.
     * @property string $payment['single']['requested_amount'] The amount requested for payment (e.g., "15.00").
 */
    public function createPaymentLink($expiration_time, $type, $customer, $payment)
    {
        // Prepare the request body
        $payment['methods'] = config('easypay.pay_by_link_payment_methods');

        $body = [
            'expiration_time' => $expiration_time,
            'type' => $type,
            'customer' => $customer,
            'payment' => $payment
        ];

        if(config('easypay.notify_client')){
            $body['communication_channels'] = config('easypay.notification_channels');
        }

        // Send the request to the Easypay API
        $response = $this->client->post('2.0/link', [
            'json' => $body,
        ]);

        if ($response->getStatusCode() !== 201) {
            throw new \Exception('Failed to create the payment link.');
        }

        $easypayResponse = json_decode($response->getBody()->getContents());

        $payByLink = new EasypayPayByLink([
            'id' => $easypayResponse->id,
            'status' => $easypayResponse->status,
            'expiration_time' => $easypayResponse->expiration_time,
            'type' => $easypayResponse->type,
            'url' => $easypayResponse->url,
            'image_url' => $easypayResponse->image,
        ]);

        if(is_null($easypayResponse->customer->language)){
            $easypayResponse->customer->language = 'PT';
        }

        $customer = EasypayCustomer::create((array)$easypayResponse->customer);
        $payment = EasypayPaymentPayByLink::create([
            'methods' => serialize($easypayResponse->payment->methods),
            'capture_descriptive' => $easypayResponse->payment->capture->descriptive,
            'capture_key' => $easypayResponse->payment->capture->key,
            'single_requested_amount' => $easypayResponse->payment->single->requested_amount,
        ]);

        $payByLink->customer()->associate($customer);
        $payByLink->payment()->associate($payment);
        $payByLink->save();

        foreach($easypayResponse->communication_channels as $channel){
            $payByLink->communicationChannels()->create([
                'type' => $channel->type,
                'value' => $channel->value,
            ]);
        }
        // Return the response from the Easypay API
        return json_decode($response->getBody()->getContents());

    }

    /**
     * Get a payment link.
     *
     * @param $id
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPaymentLink($id)
    {
        // Send the request to the Easypay API
        $response = $this->client->get('2.0/link/' . $id);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Failed to get the payment link.');
        }

        // Return the response from the Easypay API
        return json_decode($response->getBody()->getContents());
    }

    /**
     * Change the expiration date of a payment link.
     *
     * @param $id
     * @param $expiration_time
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function changeExpirationDate($id, $expiration_time)
    {
        // Send the request to the Easypay API
        $response = $this->client->patch('2.0/link/' . $id, [
            'json' => [
                'expiration_time' => $expiration_time,
            ],
        ]);

        if ($response->getStatusCode() !== 204) {
            throw new \Exception('Failed to change the expiration date of the payment link.');
        }

        // Return the response from the Easypay API
        return json_decode($response->getBody()->getContents());
    }
}
