<?php
require __DIR__.'/../bootstrap/autoload.php';

$websocket = new Hoa\Websocket\Server(
    new Hoa\Socket\Server('ws://192.168.58.63:8889')
);
$websocket->on('open', function (Hoa\Event\Bucket $bucket) {
    echo 'new connection', "\n";

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
    echo 'connection closed', "\n";

    return;
});
$websocket->run();