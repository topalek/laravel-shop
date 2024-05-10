<?php

namespace Tests\Unit\Sevices\Telegram;

use Illuminate\Support\Facades\Http;
use Services\Telegram\TelegramBotApi;
use Tests\TestCase;

class TelegramBotApiTest extends TestCase
{
    public function test_send_message_success()
    {
        Http::fake([
            TelegramBotApi::HOST . "*" => Http::response(['ok' => true], 200),
        ]);

        $result = TelegramBotApi::sendMessage('', 1, 'Testing');
        $this->assertTrue($result);
    }
}
