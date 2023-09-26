<?php
include('conf.php');

use Nichin79\Zendesk\Zendesk;

$zendesk = new Zendesk($config['zendesk']);

$users = $zendesk->search->export([
  'page[size]' => 100,
  'filter[type]' => 'user',
  'query' => 'nicklas.hintze@theservicecorporation.com',
  'page[after]' => '',
]);

foreach ($users->response()['results'] as $user) {
  echo "UserId:" . $user['id'] . "\r\n";

  $identities = $zendesk->users->identities->list_user_identities($user['id']);

  foreach ($identities->response()['identities'] as $identity) {
    if (
      $identity['type'] === 'email' &&
      str_contains($identity['value'], '@imagineit.nu') &&
      $identity['primary'] === false
    ) {
      echo "IdentityId:" . $identity['id'] . "\r\n";
    }

    // if ($identity['type'] === 'email' && str_contains($identity['value'], '@theservicecorporation.com')) {
    //   echo "IdentityId:" . $identity['id'] . "\r\n";

    //   $setPrimary = $zendesk->users->identities->make_user_identity_primary($user['id'], $identity['id']);
    // }

    // if ($identity['type'] === 'email' && str_contains($identity['value'], '@imagineit.nu')) {
    //   echo "IdentityId:" . $identity['id'] . "\r\n";

    //   $delete = $zendesk->users->identities->delete_user_identity($user['id'], $identity['id']);
    // }
  }
}