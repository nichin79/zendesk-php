<?php
include('conf.php');

$output = '';

use Nichin79\Zendesk\Zendesk;
$zendesk = new Zendesk($config['zendesk']);

// $output = $zendesk->tickets();
// $output = $zendesk->tickets->listTickets();
// $output = $zendesk->tickets->listRecent();
// $output = $zendesk->tickets->count();

$output = $zendesk->tickets->showTicket(6201);
// $output = $zendesk->tickets->showMany([6201,6202]);

// $output = $zendesk->tickets->createTicket('
// {"ticket": {
//     "comment": { "body": "The smoke is very colorful."},
//     "priority": "urgent",
//     "subject": "My printer is on fire!"
// }}');

// $output = $zendesk->tickets->createMany('
// {"tickets": [
//     { "comment": { "body": "Create many tickets 1" }, "priority": "urgent", "subject": "Create many tickets 1" },
//     { "comment": { "body": "Create many tickets 2" }, "priority": "urgent", "subject": "Create many tickets 2"}
// ]}');

// $output = $zendesk->tickets->updateTicket(6202, '
// {"ticket": {
//   "tags": [ "driftkund", "station_4218", "test" ]
// }}');

// $output = $zendesk->tickets->updateMany([],'
// {"tickets": [
//     { "id": 6201, "tags": [ "update_many_1", "test_1" ] },
//     { "id": 6202, "tags": [ "update_many_2", "test_2", "test_3" ] }
// ]}');

// $output = $zendesk->export->tickets([
//   'page[size]' => 1000,
//   'query' => 'created>20230528 tags:fas_1 status:open'
// ]);
echo json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);