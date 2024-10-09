<?php

return [

    // The base URL of the Easypay API. This should point to the appropriate version of the API you're using.
    // You can override it via the .env file with the variable EASYPAY_URL.
    'url' => env('EASYPAY_URL', "https://api.test.easypay.pt/"),

    // The API key for authenticating requests to the Easypay API.
    // This must be set in your .env file using the EASYPAY_API_KEY variable.
    'api_key' => env('EASYPAY_API_KEY', "eae4aa59-8e5b-4ec2-887d-b02768481a92"),

    // The ID of the account in Easypay that is sending the SMS messages.
    // It should be set in your .env file using the EASYPAY_ACCOUNT_ID variable.
    'account_id' => env('EASYPAY_ACCOUNT_ID', "2b0f63e2-9fb5-4e52-aca0-b4bf0339bbe6"),

    // If true, SSL certificates will be verified when sending requests to the API.
    // This is a security feature to ensure that the API connection is secure.
    'verify_ssl' => true,

    // If true, the package will migrate a database table to store the configuration settings.
    // This is useful if you want to store the configuration settings in the database to make them dynamic, or multi-tenant.
    'multi_tenant' => false,

    // The tenant model to use for multi-tenant applications. (e.g., App\Models\User)
    // This is only used if the multi_tenant option is set to true.
    'tenant_model' => '',

    // If true, "pay by link" will be enabled.
    // This feature allows you to generate a link that customers can use to pay for their orders.
    'pay_by_link' => true,

    // Payment methods to be enabled in the "pay by link" feature.
    // Possible values:
    //  'MB' - Multibanco
    //  'MBW' - MB Way
    //  'DD' - Direct Debit
    //  'CC' - Credit Card
    //  'SC' - Santander Consumer
    //  'UF' - Universo Flex
    //  'VI' - Virtual IBAN
    // After configure this option, if the payment method is not appearing in the checkout, make sure it is enabled in the Easypay backoffice.
    'pay_by_link_payment_methods' => [
        'MB',
        'MBW',
    ],

    //If true, the clients will receive notification about the payment created.
    //This feature allows the easypay system to send a notification to the client whem a payment is created and if any change is made in the payment.
    'notify_client' => true,

    // Notifications channels to be enabled.
    // Possible values:
    //  'SMS' - SMS
    //  'EMAIL' - Email

    'notification_channels' => [
        'SMS',
        'EMAIL',
    ]
];