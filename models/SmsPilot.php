<?php

namespace app\models;
class SmsPilot
{
    public static function send($phone, $text)
    {
        $sender = 'INFORM'; //  имя отправителя из списка https://smspilot.ru/my-sender.php
        $apikey = 'XXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZXXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZ';
        $url = 'https://smspilot.ru/api.php'
            . '?send=' . urlencode($text)
            . '&to=' . urlencode($phone)
            . '&from=' . $sender
            . '&apikey=' . $apikey
            . '&format=json';

        $json = file_get_contents($url);

        $j = json_decode($json);
        if (!isset($j->error)) {
            return $j->send[0]->server_id;
        } else {
            throw new \Exception($j->error->description_ru);
        }
    }
}