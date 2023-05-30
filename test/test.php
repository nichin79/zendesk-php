<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Nichin79\Zendesk\Zendesk;

$conf = [
  'subdomain' => '',
  'user' => '',
  'token' => '',
];

$zendesk = new Zendesk($conf);

// $ticket = $zendesk->tickets->getTicket(4859);

// $ticket = $zendesk->tickets();

$ticket = $zendesk->export->tickets([
  'page[size]' => 1000,
  'query' => 'created>20230528 tags:fas_1'
]);

echo json_encode($ticket, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);