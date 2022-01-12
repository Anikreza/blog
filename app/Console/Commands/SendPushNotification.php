<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SendPushNotification extends Command
{
    /**
     * if specific device tokens passed as parameter then send notification to those specific devices
     *
     * @var string
     */
    protected $signature = 'send:notification {notificationData} {deviceTokens=all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command sends web/mobile push notification with firebase';

    /**
     * @var array
     */
    protected array $headers;

    /**
     * @var string
     */
    protected string $requestUri = 'https://fcm.googleapis.com/fcm/send';

    /**
     * Firebase Configuration Data
     * @var array
     */
    protected array $data;

    /**
     * @var array
     */
    protected array $deviceTokens;

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
     * @return void
     */
    public function handle(): void
    {
        $this->info('notification sending to mobile...');
        try {
            $this->verifyNotificationData();
            $this->setDeviceTokens();
            $this->prepareData();
            $this->send();
            $this->info('Notification sent successfully!');

        } catch (Exception $exception) {
            $this->info($exception->getMessage());
            \Log::info($exception->getMessage());
        }
    }

    /**
     * Checks if notification data is an and it has title and body index
     * @return bool
     */

    private function verifyNotificationData(): bool
    {
        $data = $this->argument('notificationData');

        if (!is_array($data) && (is_string($data['title']) && strlen($data['title']) < 3 && is_string($data['body']) && strlen($data['body']) < 10)) return false;

        return true;
    }

    /**
     * @return void
     * @throws Exception
     */
    private function setDeviceTokens(): void
    {
        if ($this->argument('deviceTokens') == 'all') {
            $tokens = []; // @todo query on database to pluck all the valid device token
        } else {
            if (!is_array($this->argument('deviceTokens'))) throw new Exception('DeviceTokens should pass as array');

            $tokens = (array)$this->argument('deviceTokens');
        }

        $this->deviceTokens = $tokens;
    }

    /**
     * @return void
     */
    private function prepareData(): void
    {
        $this->headers = [
            'Authorization' => "key=" . env('FIREBASE_SERVER_KEY'),
            'Content-Type' => 'application/json',
        ];

        $this->data = [
            "registration_ids" => (array)$this->deviceTokens,
            "notification" => (array)$this->argument('notificationData')
        ];
    }

    private function send()
    {
        Http::withHeaders($this->headers)->post($this->requestUri, $this->data);
    }
}
