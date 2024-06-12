<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payment extends CI_Controller
{

    private $server_key;
    private $api_url;

    public function __construct()
    {
        parent::__construct();

        // Set your server key (Note: Server key for sandbox and production mode are different)
        $this->server_key = 'SB-Mid-server-d6Y8GDKsSkjqp_0W0kIujYDQ';
        // Set true for production, set false for sandbox
        $is_production = false;

        $this->api_url = $is_production ?
            'https://app.midtrans.com/snap/v1/transactions' :
            'https://app.sandbox.midtrans.com/snap/v1/transactions';
    }

    public function charge()
    {
        // Check if method is not HTTP POST, display 404
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            show_404();
            return;
        }

        // get the HTTP POST body of the request
        $request_body = file_get_contents('php://input');

        // call charge API using request body passed by mobile SDK
        $charge_result = $this->chargeAPI($this->api_url, $this->server_key, $request_body);

        // set the response http status code
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($charge_result['http_code'])
            ->set_output($charge_result['body']);
    }

    /**
     * call charge API using Curl
     * @param string $api_url
     * @param string $server_key
     * @param string $request_body
     */
    private function chargeAPI($api_url, $server_key, $request_body)
    {
        $ch = curl_init();
        $curl_options = array(
            CURLOPT_URL => $api_url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            // Add header to the request, including Authorization generated from server key
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Basic ' . base64_encode($server_key . ':')
            ),
            CURLOPT_POSTFIELDS => $request_body
        );
        curl_setopt_array($ch, $curl_options);
        $result = array(
            'body' => curl_exec($ch),
            'http_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
        );
        curl_close($ch);
        return $result;
    }
}
