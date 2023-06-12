<?php
include('conf.php');

use Nichin79\Zendesk\Zendesk;

$zendesk = new Zendesk($config['zendesk']);

$query = [
  'page[size]' => 5,
  'filter[type]' => 'ticket',
  'query' => 'created>"2022-05-31"',
  'page[after]' => '',
];
$tickets = $zendesk->search->export($query);

$requesterArr = [];
foreach ($tickets->response()['results'] as $ticket) {
  $requesterArr[] = $ticket['requester_id'];
}

$users = $zendesk->users->show_many($requesterArr);
foreach ($users->response()['users'] as $user) {
  echo json_encode($user) . "\r\n\r\n";
}