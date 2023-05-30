<?php
namespace Nichin79\Zendesk;

use Nichin79\Curl\Curl;

class Zendesk
{
  protected array $payload = [];

  public Tickets $tickets;
  public Export $export;

  public function __construct(array $conf)
  {
    $this->payload['subdomain'] = $conf['subdomain'];
    if (isset($conf['user'])) {
      $this->payload['user'] = $conf['user'];
    }
    if (isset($conf['pass'])) {
      $this->payload['pass'] = $conf['pass'];
    }
    if (isset($conf['token'])) {
      $this->payload['token'] = $conf['token'];
    }

    $this->tickets = new Tickets($this->payload);
    $this->export = new Export($this->payload);
  }

  public function tickets()
  {
    $payload = $this->payload;
    $payload['method'] = 'GET';
    $payload['url'] = 'https://' . $payload['subdomain'] . '.zendesk.com/api/v2/tickets/';
    return Curl::exec($payload);
  }
}