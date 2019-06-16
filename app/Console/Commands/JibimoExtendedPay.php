<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use puresoft\jibimo\exceptions\CurlResultFailedException;
use puresoft\jibimo\exceptions\InvalidIbanException;
use puresoft\jibimo\exceptions\InvalidJibimoPrivacyLevelException;
use puresoft\jibimo\exceptions\InvalidJibimoResponseException;
use puresoft\jibimo\exceptions\InvalidJibimoTransactionStatusException;
use puresoft\jibimo\exceptions\InvalidMobileNumberException;
use puresoft\jibimo\laravel\Jibimo;
use puresoft\jibimo\payment\values\JibimoPrivacyLevel;
use puresoft\jibimo\payment\values\JibimoTransactionStatus;

class JibimoExtendedPay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jibimo:extendedPay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Extended pay.';

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
     * @throws InvalidIbanException
     * @throws InvalidJibimoPrivacyLevelException
     * @throws InvalidJibimoResponseException
     * @throws InvalidJibimoTransactionStatusException
     * @throws InvalidMobileNumberException
     */
    public function handle(Jibimo $jibimo)
    {
        $response = $jibimo->extendedPay("09366061280", 2000, JibimoPrivacyLevel::PERSONAL,
            'IR140570028870010133089001', 'live-test',"Hi there!", "حسام", "غلامی");

        $this->info($response->getRawResponse());

        if(JibimoTransactionStatus::ACCEPTED === $response->getStatus()) {
            // Money was paid successfully
            $this->info('Paid successfully.');
        } else {
            // Invalid result
            $this->warn('Something went wrong!');
        }
    }
}
