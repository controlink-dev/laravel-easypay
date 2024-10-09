<?php

namespace Controlink\LaravelEasypay\Http\Controllers;

use Controlink\LaravelEasypay\Models\EasypayConfiguration;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class EasypayConfigurationController extends Controller
{
    use ValidatesRequests;

    /**
     *  Create a new Easypay configuration
     * @param string $url
     * @param string $api_key
     * @param string $account_id
     * @param bool $verify_ssl
     * @param string|null $tenant_id
     * @return JsonResponse
     */
    public function create(string $url, string $api_key, string $account_id, bool $verify_ssl, string $tenant_id = null){

        $configuration = new EasypayConfiguration();
        $configuration->url = $url;
        $configuration->api_key = $api_key;
        $configuration->account_id = $account_id;
        $configuration->verify_ssl = $verify_ssl;

        if(config('easypay.multi_tenant', false)){
            $configuration->${config("easypay.tenant_column_name")} = $tenant_id;
        }

        $configuration->save();

        return response()->json($configuration);
    }

    /**
     * Update an existing Easypay configuration
     *
     * @param EasypayConfiguration $configuration
     * @param string $url
     * @param string $api_key
     * @param string $account_id
     * @param bool $verify_ssl
     * @param string|null $tenant_id
     * @return JsonResponse
     */
    public function update(EasypayConfiguration $configuration, string $url, string $api_key, string $account_id, bool $verify_ssl, string $tenant_id = null){
        $configuration->url = $url;
        $configuration->api_key = $api_key;
        $configuration->account_id = $account_id;
        $configuration->verify_ssl = $verify_ssl;
        $configuration->save();

        return response()->json($configuration);
    }

    /**
     * Delete an existing Easypay configuration
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id){
        $configuration = $this->get($id);
        $configuration->delete();

        return response()->json(['message' => 'Configuration deleted']);
    }

    /**
     * Get an existing Easypay configuration
     *
     * @param int $id
     * @return EasypayConfiguration
     */
    public function get($id){
        return EasypayConfiguration::findOrFail($id);
    }
}