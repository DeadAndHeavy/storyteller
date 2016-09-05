<?php
require __DIR__.'/../../bootstrap/autoload.php';
$app = require_once __DIR__.'/../../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$websocket = new Hoa\Websocket\Server(
    new Hoa\Socket\Server('ws://'. config('websocket.server_ip') . ':' . config('websocket.server_port'))
);
$websocket->on('open', function (Hoa\Event\Bucket $bucket) {
    //echo 'new connection', "\n";

    return;
});
$websocket->on('message', function (Hoa\Event\Bucket $bucket) {
    $data = $bucket->getData();
    echo '> message ', $data['message'], "\n";
    $bucket->getSource()->broadcast($data['message']);
    echo '< echo', "\n";

    return;
});
$websocket->on('close', function (Hoa\Event\Bucket $bucket) {
    //echo 'connection closed', "\n";

    return;
});
$websocket->run();