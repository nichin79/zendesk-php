<?php
include('conf.php');

use Nichin79\Zendesk\Zendesk;

$zendesk = new Zendesk($config['zendesk']);

// $query = [
//   'query' => 'type:ticket status:open',
//   'include' => 'tickets(users)'
// ];
// $output = $zendesk->search->search($search);
// $output = $zendesk->search->count($search);

$query = [
  'page[size]' => 1,
  'filter[type]' => 'ticket',
  'query' => 'created>"2022-05-31"',
  'page[after]' => '',
];
$request = $zendesk->search->export($query);

echo $request->httpcode();
echo json_encode($request->response());
// echo json_encode($request, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
// echo $output->response->results[0]->id . "\r\n";
// echo $output->response->meta->after_cursor;