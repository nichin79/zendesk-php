<?php
namespace Nichin79\Zendesk;

use Nichin79\Curl\BasicCurl;
use Nichin79\Zendesk\Tickets\Comments;

class Tickets
{
  protected array $data = [];

  public Tickets\Comments $comments;

  public function __construct(array $data)
  {
    $this->data = $data;

    foreach ($this->data['modules']['tickets'] as $key => $value) {
      if (gettype($this->data['modules']['tickets'][$key]) === 'array') {
        $class = ucfirst(strtolower($key));
      }
      if (gettype($this->data['modules']['tickets'][$key]) === 'string') {
        $class = ucfirst(strtolower($value));
      }

      switch ($class) {
        case 'Comments';
          $this->comments = new Comments($this->data);
          break;
      }
    }

  }

  public function list()
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/tickets', $data['baseurl']);
    return new BasicCurl($data);
  }

  public function list_recent()
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/tickets/recent', $data['baseurl']);
    return new BasicCurl($data);
  }

  public function list_deleted()
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/deleted_tickets', $data['baseurl']);
    return new BasicCurl($data);
  }

  public function count()
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/tickets/count', $data['baseurl']);
    return new BasicCurl($data);
  }

  public function show(int $ticketId)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/tickets/%s.json', $data['baseurl'], $ticketId);
    return new BasicCurl($data);
  }

  public function show_many(array $ticketIds)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/tickets/show_many.json?ids%s', $data['baseurl'], implode(',', $ticketIds));
    return new BasicCurl($data);
  }

  public function create(string $body)
  {
    $data = $this->data;
    $data['method'] = 'POST';
    $data['url'] = sprintf('%s/tickets.json', $data['baseurl']);
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  public function create_many(string $body)
  {
    $data = $this->data;
    $data['method'] = 'POST';
    $data['url'] = sprintf('%s/tickets/create_many.json', $data['baseurl']);
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  public function update(int $ticketId, string $body)
  {
    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = sprintf('%s/tickets/%s.json', $data['baseurl'], $ticketId);
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  public function update_many(array $ticketIds, string $body)
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
    $data['url'] = sprintf('%s/tickets/update_many.json%s', $data['baseurl'], $ids);
    $data['data'] = $body;

    return new BasicCurl($this->data);
  }

  public function delete(int $ticketId)
  {
    $data = $this->data;
    $data['method'] = 'DELETE';
    $data['url'] = sprintf('%s/tickets/%s.json', $data['baseurl'], $ticketId);
    return new BasicCurl($data);
  }

  public function delete_many(array $ticketIds)
  {
    $data = $this->data;
    $data['method'] = 'DELETE';
    $data['url'] = sprintf('%s/tickets/destroy_many?ids=%s', $data['baseurl'], implode(',', $ticketIds));
    return new BasicCurl($data);
  }

  public function restore(int $ticketId)
  {
    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = sprintf('%s/deleted_tickets/%s/restore.json', $data['baseurl'], $ticketId);
    return new BasicCurl($data);
  }

  public function restore_many(array $ticketIds)
  {
    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = sprintf('%s/deleted_tickets/restore_many?ids=%s', $data['baseurl'], implode(',', $ticketIds));
    return new BasicCurl($data);
  }

  public function delete_permanently(int $ticketId)
  {
    $data = $this->data;
    $data['method'] = 'DELETE';
    $data['url'] = sprintf('%s/deleted_tickets/%s.json', $data['baseurl'], $ticketId);
    return new BasicCurl($data);
  }

  public function delete_many_permanently(array $ticketIds)
  {
    $data = $this->data;
    $data['method'] = 'DELETE';
    $data['url'] = sprintf('%s/deleted_tickets/destroy_many?ids=%s', $data['baseurl'], implode(',', $ticketIds));
    return new BasicCurl($data);
  }

  /*
   * ALIAS FUNCTIONS
   */
  public function recent()
  {
    return $this->list_recent();
  }

  public function deleted()
  {
    return $this->list_deleted();
  }

  public function comments(int $ticketId)
  {
    return $this->comments->list($ticketId);
  }
}