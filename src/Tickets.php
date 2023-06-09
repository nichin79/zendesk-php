<?php
namespace Nichin79\Zendesk;

use Nichin79\Curl\BasicCurl;

class Tickets
{
  protected array $data = [];
  public function __construct(array $data)
  {
    $this->data = $data;
  }

  public function list()
  {
    $data = $this->data;
    $data['method'] = 'GET';
    $data['url'] = 'https://' . $data['subdomain'] . '.zendesk.com/api/v2/tickets';
    return new BasicCurl($data);
  }

  public function list_recent()
  {
    $data = $this->data;
    $data['method'] = 'GET';
    $data['url'] = 'https://' . $data['subdomain'] . '.zendesk.com/api/v2/tickets/recent';
    return new BasicCurl($data);
  }

  public function list_deleted()
  {
    $data = $this->data;
    $data['method'] = 'GET';
    $data['url'] = 'https://' . $data['subdomain'] . '.zendesk.com/api/v2/deleted_tickets';
    return new BasicCurl($data);
  }

  public function count()
  {
    $data = $this->data;
    $data['method'] = 'GET';
    $data['url'] = 'https://' . $data['subdomain'] . '.zendesk.com/api/v2/tickets/count';
    return new BasicCurl($data);
  }

  public function show(int $ticketId)
  {
    $data = $this->data;
    $data['method'] = 'GET';
    $data['url'] = 'https://' . $data['subdomain'] . '.zendesk.com/api/v2/tickets/' . $ticketId . '.json';
    return new BasicCurl($data);
  }

  public function show_many(array $ticketIds)
  {
    $ticketIds = implode(',', $ticketIds);
    $data = $this->data;
    $data['method'] = 'GET';
    $data['url'] = 'https://' . $data['subdomain'] . ".zendesk.com/api/v2/tickets/show_many.json?ids=$ticketIds";
    return new BasicCurl($data);
  }

  public function create(string $data)
  {
    $data = $this->data;
    $data['method'] = 'POST';
    $data['url'] = 'https://' . $data['subdomain'] . '.zendesk.com/api/v2/tickets.json';
    $data['headers'] = ["Content-Type: application/json"];
    $data['data'] = $data;
    return new BasicCurl($data);
  }

  public function create_many(string $data)
  {
    $data = $this->data;
    $data['method'] = 'POST';
    $data['url'] = 'https://' . $data['subdomain'] . '.zendesk.com/api/v2/tickets/create_many.json';
    $data['headers'] = ["Content-Type: application/json"];
    $data['data'] = $data;
    return new BasicCurl($data);
  }

  public function update(int $ticketId, string $data)
  {
    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = 'https://' . $data['subdomain'] . '.zendesk.com/api/v2/tickets/' . $ticketId . '.json';
    $data['headers'] = ["Content-Type: application/json"];
    $data['data'] = $data;
    return new BasicCurl($data);
  }

  public function update_many(array $ticketIds, string $data)
  {
    // IMPORTANT NOTE!
    // The ticket id's should only be specified in either $ticketIds or in $data, not a combination of both
    // Specifying id's in $data will have higher priority than $ticketIds

    $ids = '';
    if (count($ticketIds) > 0) {
      $ids = '?ids=' . implode(',', $ticketIds);
    }

    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = 'https://' . $data['subdomain'] . ".zendesk.com/api/v2/tickets/update_many.json$ids";
    $data['headers'] = ["Content-Type: application/json"];
    $data['data'] = $data;

    var_dump($data);
    return new BasicCurl($data);
  }

  public function delete(int $ticketId)
  {
    $data = $this->data;
    $data['method'] = 'DELETE';
    $data['url'] = 'https://' . $data['subdomain'] . ".zendesk.com/api/v2/tickets/$ticketId.json";
    return new BasicCurl($data);
  }

  public function delete_many(array $ticketIds)
  {
    $ticketIds = implode(',', $ticketIds);
    $data = $this->data;
    $data['method'] = 'DELETE';
    $data['url'] = 'https://' . $data['subdomain'] . ".zendesk.com/api/v2/tickets/destroy_many?ids=$ticketIds";
    return new BasicCurl($data);
  }

  public function restore(int $ticketId)
  {
    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = 'https://' . $data['subdomain'] . ".zendesk.com/api/v2/deleted_tickets/$ticketId/restore.json";
    return new BasicCurl($data);
  }

  public function restore_many(array $ticketIds)
  {
    $ticketIds = implode(',', $ticketIds);
    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = 'https://' . $data['subdomain'] . ".zendesk.com/api/v2/deleted_tickets/restore_many?ids=$ticketIds";
    return new BasicCurl($data);
  }

  public function delete_permanently(int $ticketId)
  {
    $data = $this->data;
    $data['method'] = 'DELETE';
    $data['url'] = 'https://' . $data['subdomain'] . ".zendesk.com/api/v2/deleted_tickets/$ticketId.json";
    return new BasicCurl($data);
  }

  public function delete_many_permanently(array $ticketIds)
  {
    $ticketIds = implode(',', $ticketIds);
    $data = $this->data;
    $data['method'] = 'DELETE';
    $data['url'] = 'https://' . $data['subdomain'] . ".zendesk.com/api/v2/deleted_tickets/destroy_many?ids=$ticketIds";
    return new BasicCurl($data);
  }
}