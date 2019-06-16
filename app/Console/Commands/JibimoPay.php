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
use puresoft\jibimo\payment\values\JibimoTransactionStatus;

class JibimoPay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jibimo:pay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Normal pay.';

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
        $response = $jibimo->pay("09366061280", 2000, JibimoPrivacyLevel::PERSONAL,
            'live-test',"Aleyke Salam");

        $this->info($response->getRawResponse());

        if(JibimoTransactionStatus::ACCEPTED === $response->getStatus()) {
            // Money was paid immediately
            $this->info('Paid immediately.');
            $this->info('Transaction ID: ' . $response->getTransactionId());
            $this->info('Status: ' . $response->getStatus());
            $this->info('Tracker ID: ' . $response->getTrackerId());
        } else if(JibimoTransactionStatus::PENDING === $response->getStatus()) {
            // The user was not registered in Jibimo, so it will be pending until user being registered in Jibimo
            $this->info('Pending registration. The user was not registered in Jibimo, so it will be pending until user being registered in Jibimo.');
        } else {
            $this->warn('Something went wrong!');
        }
    }
}
