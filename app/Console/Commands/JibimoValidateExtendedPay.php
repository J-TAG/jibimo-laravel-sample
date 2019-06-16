<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use puresoft\jibimo\exceptions\CurlResultFailedException;
use puresoft\jibimo\exceptions\InvalidJibimoPrivacyLevelException;
use puresoft\jibimo\exceptions\InvalidJibimoResponseException;
use puresoft\jibimo\exceptions\InvalidJibimoTransactionStatusException;
use puresoft\jibimo\exceptions\InvalidMobileNumberException;
use puresoft\jibimo\laravel\Jibimo;

class JibimoValidateExtendedPay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jibimo:validateExtendedPay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Validate extended pay transaction.';

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
        $response = $jibimo->validateExtendedPay(124980, "09366061280", 2000,
            'live-test');

        $this->info($response->getRawResponse());

        if($response->isAccepted()) {
            $this->info("Transaction was successfully validated.");
        } else {
            $this->warn("Transaction is invalid.");
        }
    }
}
