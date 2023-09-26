<?php
include('conf.php');

use Nichin79\Zendesk\Zendesk;

$zendesk = new Zendesk($config['zendesk']);
// $request = $zendesk->tickets();
// $output = $zendesk->tickets->list();
// $output = $zendesk->tickets->list_recent();
// $output = $zendesk->tickets->count();

// $output = $zendesk->tickets->show(6201);
// $output = $zendesk->tickets->show_many([6201,6202]);

// $request = $zendesk->tickets->create('
// {"ticket": {
//     "comment": { "body": "The smoke is very colorful."},
//     "priority": "urgent",
//     "subject": "My printer is on fire!"
// }}');

// $output = $zendesk->tickets->create_many('
// {"tickets": [
//     { "comment": { "body": "Create many tickets 1" }, "priority": "urgent", "subject": "Create many tickets 1" },
//     { "comment": { "body": "Create many tickets 2" }, "priority": "urgent", "subject": "Create many tickets 2"}
// ]}');

// $output = $zendesk->tickets->update(6202, '
// {"ticket": {
//   "tags": [ "driftkund", "station_4218", "test" ]
// }}');

// $output = $zendesk->tickets->update_many([],'
// {"tickets": [
//     { "id": 6201, "tags": [ "update_many_1", "test_1" ] },
//     { "id": 6202, "tags": [ "update_many_2", "test_2", "test_3" ] }
// ]}');

// $output = $zendesk->export->tickets([
//   'page[size]' => 1000,
//   'query' => 'created>20230528 tags:fas_1 status:open'
// ]);

// $output = $zendesk->tickets->delete(6200);
// $output = $zendesk->tickets->delete_many([6201, 6202]);
// $output = $zendesk->tickets->list_deleted();
// $output = $zendesk->tickets->restore(6200);
// $output = $zendesk->tickets->restore_many([6201, 6202]);
// $output = $zendesk->tickets->delete_permanently(6200);
// $output = $zendesk->tickets->delete_many_permanently([6201, 6202]);


// $request = $zendesk->tickets->metrics(6211);

$request = $zendesk->tickets->show(6332);

if (in_array($request->httpcode(), $okStatus)) {
  $request->jsonPrint(1);
}

// $request = $zendesk->tickets->comments->list(6199);
// $request = $zendesk->tickets->comments->count(6199);
// $request = $zendesk->tickets->comments->make_private(6211, 11925100328850);
// $request = $zendesk->tickets->comments->comment_redactions(11925100328850, '{"html_body":"<div class=\"zd-comment\" dir=\"auto\"><p dir=\"auto\">The <redact>smoke</redact> is very colorful.</p>\n<p dir=\"auto\">2700kelvin</p></div>", "ticket_id": 6211 }');
// $request = $zendesk->tickets->comments->redact_string(6211, 11925100328850, '{"text": "2700"}');

// echo json_encode($request->response());
// echo json_encode($request->response(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
// echo "\r\n";
// echo $request->httpcode();