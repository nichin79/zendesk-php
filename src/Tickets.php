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

  public function update(int $ticketId, string $data)
  {
    $payload = $this->payload;
    $payload['method'] = 'PUT';
    $payload['url'] = 'https://' . $payload['subdomain'] . '.zendesk.com/api/v2/tickets/' . $ticketId . '.json';
    $payload['headers'] = ["Content-Type: application/json"];
    $payload['data'] = $data;
    return Curl::exec($payload);
  }
}