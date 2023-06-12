<?php
include('conf.php');

use Nichin79\Zendesk\Zendesk;

$zendesk = new Zendesk($config['zendesk']);
// $request = $zendesk->users();
// $request = $zendesk->tickets->show(6199);
// $request = $zendesk->users->compliance_deletion_statuses(374834345140, 'chat');

// $request = $zendesk->users->me();

// echo json_encode($request->response());
echo json_encode($request->response());
// echo json_encode($request->response(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
echo "\r\n";
echo $request->httpcode();