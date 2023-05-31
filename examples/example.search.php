<?php
include('conf.php');

$output = '';

use Nichin79\Zendesk\Zendesk;
$zendesk = new Zendesk($config['zendesk']);

// $search = [
//   'query' => 'type:ticket status:open',
//   'include' => 'tickets(users)'
// ];
// $output = $zendesk->search->search($search);
// $output = $zendesk->search->count($search);

// $output = $zendesk->search->export([
//   'page[size]' => 1,
//   'filter[type]' => 'ticket',
//   'query' => 'created>"2022-05-28"'
// ]);


echo json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);