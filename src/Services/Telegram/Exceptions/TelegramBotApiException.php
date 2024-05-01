<?php

namespace Services\Telegram\Exceptions;


use Illuminate\Http\Request;

class TelegramBotApiException extends \Exception
{
    public function render(Request $request)
    {
        return response()->json([]);
    }
}
