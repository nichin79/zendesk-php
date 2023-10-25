<?php
include('conf.php');

use Nichin79\Zendesk\Zendesk;

$zendesk = new Zendesk($config['zendesk']);

// Export/query users where email is test@test.com
$users = $zendesk->search->export([
  'page[size]' => 100,
  'filter[type]' => 'user',
  'query' => 'test@test.com',
  'page[after]' => '',
]);

// Loop through each user
foreach ($users->response('json')->results as $user) {
  echo "userId: " . $user->id . "\r\n"
    . "userName: " . $user->name . "\r\n";

  // Retrieve user identities
  $identities = $zendesk->users->identities->list_user_identities($user->id);

  // Loop through each identity and check for email that contains @test.se
  foreach ($identities->response('json')->identities as $identity) {
    if (
      $identity->type === 'email' &&
      str_contains($identity->value, '@test.se') &&
      $identity->primary === false
    ) {
      echo "->identityId: " . $identity->id . "\r\n"
        . "->identityEmail: " . $identity->value . "\r\n";
    }
  }

  // Retrieve and loop through tickets for the user
  $tickets = $zendesk->tickets->list_user_requested($user->id);
  foreach ($tickets->response('json')->tickets as $ticket) {
    echo "\r\n" . "ticket: " . $ticket->id . " - " . $ticket->subject . "\r\n";
  }
}