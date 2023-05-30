<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Nichin79\Zendesk\Zendesk;

(new Nichin79\DotEnv\DotEnv(__DIR__ . '/../.env'))->load();
$config = [
  'zendesk' => [
    'subdomain' => $_ENV['ZENDESK_SUBDOMAIN'],
    'user' => $_ENV['ZENDESK_USER'],
    'token' => $_ENV['ZENDESK_TOKEN'],
  ]
];

$zendesk = new Zendesk($config['zendesk']);

// $ticket = $zendesk->tickets->getTicket(4859);

// $ticket = $zendesk->tickets();

// $export = $zendesk->export->tickets([
//   'page[size]' => 1000,
//   'query' => 'created>20230528 tags:fas_1'
// ]);

// echo json_encode($export, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

$update = $zendesk->tickets->update(5793, '{"ticket": {"tags": ["driftkund","station_4218","test"]}}');
echo json_encode($update, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);