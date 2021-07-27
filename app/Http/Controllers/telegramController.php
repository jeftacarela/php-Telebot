<?php

namespace App\Http\Controllers;

use App\Traits\MakeComponents;
use App\Traits\RequestTrait;
use Illuminate\Http\Request;

class telegramController extends Controller
{
    use RequestTrait;
    use MakeComponents;

    public function webhook()
    {
        return $this->apiRequest(method:'setWebhook',[
            'url' => url(route(name: 'webhook')),
        ]) ? ['success']:['something went wrong'];
    }

    public function index()
    {
        $result = json_decode(file_get_contents(filename: 'php://input'));
        $action = $result->message->text;
        $userID = $result->message->from->id;
        if($action == '/start'){
            $text = 'Choose ur city';
            $option =[
                ['Jakarta Barat', 'Jakarta Timur'],
                ['Jakarta Selatan','Tangerang']
            ];
            $this->apiRequest(method:'sendMessage',[
                'chat_id' => $userId,
                'text' => $text,
                'reply_markup' => $this->keyboardBtn($option)
            ]);
        }
    }
}
