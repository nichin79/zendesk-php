<?php
namespace Nichin79\Zendesk;

use Nichin79\Curl\Curl;

class Tickets
{
  protected array $payload = [];
  public function __construct(array $payload)
  {
    $this->payload = $payload;
  }

  public function getTicket($ticketId)
  {
    $payload = $this->payload;
    $payload['method'] = 'GET';
    $payload['url'] = 'https://' . $payload['subdomain'] . '.zendesk.com/api/v2/tickets/' . $ticketId . '.json';
    return Curl::exec($payload);
  }
}