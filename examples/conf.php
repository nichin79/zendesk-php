<?php
require_once __DIR__ . '/../vendor/autoload.php';

(new Nichin79\DotEnv\DotEnv(__DIR__ . '/../.env'))->load();
$config = [
  'zendesk' => [
    'subdomain' => $_ENV['ZENDESK_SUBDOMAIN'],
    'user' => $_ENV['ZENDESK_USER'],
    'token' => $_ENV['ZENDESK_TOKEN'],
    'modules' => [
      'tickets' => ['attachments', 'comments', 'forms', 'fields', 'metrics'],
      'search',
      'users'
    ]
  ]
];

$okStatus = [200, 201, 204];