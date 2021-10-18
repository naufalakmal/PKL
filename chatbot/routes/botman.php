<?php

use App\Http\Controllers\BotManController;

$botman = resolve('botman');

$botman->hears('Hi', function ($bot) {
    $bot->reply('Halo');
    $bot->reply('kalau boleh tau siapa namamu?');
});
$botman->hears('saya {name}', function ($bot, $name) {
    $bot->reply('Halo ' . $name . ' senang berkenalan denganmu aku Udin');
});

$botman->fallback(function ($bot) {
    $bot->reply('Maaf saya tidak mengerti apa yang anda maksud. . .');
});
$botman->hears('Start conversation', BotManController::class . '@startConversation');
