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

  public function listTickets()
  {
    $payload = $this->payload;
    $payload['method'] = 'GET';
    $payload['url'] = 'https://' . $payload['subdomain'] . '.zendesk.com/api/v2/tickets';
    return Curl::exec($payload);
  }

  public function listRecent()
  {
    $payload = $this->payload;
    $payload['method'] = 'GET';
    $payload['url'] = 'https://' . $payload['subdomain'] . '.zendesk.com/api/v2/tickets/recent';
    return Curl::exec($payload);
  }

  public function count()
  {
    $payload = $this->payload;
    $payload['method'] = 'GET';
    $payload['url'] = 'https://' . $payload['subdomain'] . '.zendesk.com/api/v2/tickets/count';
    return Curl::exec($payload);
  }

  public function showTicket(int $ticketId)
  {
    $payload = $this->payload;
    $payload['method'] = 'GET';
    $payload['url'] = 'https://' . $payload['subdomain'] . '.zendesk.com/api/v2/tickets/' . $ticketId . '.json';
    return Curl::exec($payload);
  }

  public function showMany(array $ticketIds)
  {
    $ticketIds = implode(',',$ticketIds);
    $payload = $this->payload;
    $payload['method'] = 'GET';
    $payload['url'] = 'https://' . $payload['subdomain'] . ".zendesk.com/api/v2/tickets/show_many.json?ids=$ticketIds";
    return Curl::exec($payload);
  }

  public function createTicket(string $data)
  {
    $payload = $this->payload;
    $payload['method'] = 'POST';
    $payload['url'] = 'https://' . $payload['subdomain'] . '.zendesk.com/api/v2/tickets.json';
    $payload['headers'] = ["Content-Type: application/json"];
    $payload['data'] = $data;
    return Curl::exec($payload);
  }

  public function createMany(string $data)
  {
    $payload = $this->payload;
    $payload['method'] = 'POST';
    $payload['url'] = 'https://' . $payload['subdomain'] . '.zendesk.com/api/v2/tickets/create_many.json';
    $payload['headers'] = ["Content-Type: application/json"];
    $payload['data'] = $data;
    return Curl::exec($payload);
  }

  public function updateTicket(int $ticketId, string $data)
  {
    $payload = $this->payload;
    $payload['method'] = 'PUT';
    $payload['url'] = 'https://' . $payload['subdomain'] . '.zendesk.com/api/v2/tickets/' . $ticketId . '.json';
    $payload['headers'] = ["Content-Type: application/json"];
    $payload['data'] = $data;
    return Curl::exec($payload);
  }

  public function updateMany(array $ticketIds, string $data)
  {
    // IMPORTANT NOTE!
    // The ticket id's should only be specified in either $ticketIds or in $data, not a combination of both
    // Specifying id's in $data will have higher priority than $ticketIds
    
    if (count($ticketIds) > 0) {
      $ticketIds = '?ids=' . implode(',',$ticketIds);
    } else {
      $ticketIds = '';
    }

    $payload = $this->payload;
    $payload['method'] = 'PUT';
    $payload['url'] = 'https://' . $payload['subdomain'] . ".zendesk.com/api/v2/tickets/update_many.json$ticketIds";
    $payload['headers'] = ["Content-Type: application/json"];
    $payload['data'] = $data;

    var_dump($payload);
    return Curl::exec($payload);
  }
}