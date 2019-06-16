<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use puresoft\jibimo\exceptions\CurlResultFailedException;
use puresoft\jibimo\exceptions\InvalidJibimoPrivacyLevelException;
use puresoft\jibimo\exceptions\InvalidJibimoResponseException;
use puresoft\jibimo\exceptions\InvalidJibimoTransactionStatusException;
use puresoft\jibimo\exceptions\InvalidMobileNumberException;
use puresoft\jibimo\laravel\Jibimo;
use puresoft\jibimo\payment\values\JibimoPrivacyLevel;

class JibimoRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jibimo:request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Request money.';

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
     * @param Jibimo $jibimo
     * @return mixed
     * @throws CurlResultFailedException
     * @throws InvalidJibimoPrivacyLevelException
     * @throws InvalidJibimoResponseException
     * @throws InvalidJibimoTransactionStatusException
     * @throws InvalidMobileNumberException
     */
    public function handle(Jibimo $jibimo)
    {
        $response = $jibimo->request("09366061280", 2000, JibimoPrivacyLevel::PERSONAL,
            'live-test',"Salam");

        $this->info($response->getRedirectUrl());

        $this->info('Transaction ID: ' . $response->getTransactionId());
        $this->info('Transaction status: ' . $response->getStatus());
    }
}
