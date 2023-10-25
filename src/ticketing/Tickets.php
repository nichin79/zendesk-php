<?php
namespace Nichin79\Zendesk\Ticketing;

use Nichin79\Curl\BasicCurl;
use Nichin79\Zendesk\Ticketing\Tickets\Attachments;
use Nichin79\Zendesk\Ticketing\Tickets\Comments;
use Nichin79\Zendesk\Ticketing\Tickets\Forms;
use Nichin79\Zendesk\Ticketing\Tickets\Fields;
use Nichin79\Zendesk\Ticketing\Tickets\Metrics;
use Nichin79\Zendesk\Ticketing\Tickets\Requests;

class Tickets
{
  protected array $data = [];

  public Tickets\Attachments $attachments;
  public Tickets\Comments $comments;
  public Tickets\Forms $forms;
  public Tickets\Fields $fields;
  public Tickets\Metrics $metrics;
  public Tickets\Requests $requests;

  public function __construct(array $data)
  {
    $this->data = $data;

    foreach (\Nichin79\Zendesk\Zendesk::get_modules($this->data['modules']['ticketing']['tickets']) as $module) {
      switch ($module) {
        case 'attachments';
          $this->attachments = new Attachments($this->data);
          break;
        case 'comments';
          $this->comments = new Comments($this->data);
          break;
        case 'forms';
          $this->forms = new Forms($this->data);
          break;
        case 'fields';
          $this->fields = new Fields($this->data);
          break;
        case 'metrics';
          $this->metrics = new Metrics($this->data);
          break;
        case 'requests';
          $this->requests = new Requests($this->data);
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

  public function list_user_requested(int $userId)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/users/%s/tickets/requested', $data['baseurl'], $userId);
    return new BasicCurl($data);
  }

  public function list_user_ccd(int $userId)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/users/%s/tickets/ccd', $data['baseurl'], $userId);
    return new BasicCurl($data);
  }

  public function list_user_followed(int $userId)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/users/%s/tickets/followed', $data['baseurl'], $userId);
    return new BasicCurl($data);
  }

  public function list_user_assigned(int $userId)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/users/%s/tickets/assigned', $data['baseurl'], $userId);
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

  public function count_organization(int $orgId)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/organizations/%s/tickets/count', $data['baseurl'], $orgId);
    return new BasicCurl($data);
  }

  public function count_user_ccd(int $userId)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/users/%s/tickets/ccd/count', $data['baseurl'], $userId);
    return new BasicCurl($data);
  }

  public function count_user_assigned(int $userId)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/users/%s/tickets/assigned/count', $data['baseurl'], $userId);
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

  public function metrics(int $ticketId)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/tickets/%s/metrics', $data['baseurl'], $ticketId);
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

  public function forms(array $params = [])
  {
    return $this->forms->list($params);
  }

  public function fields(array $params = [])
  {
    return $this->fields->list($params);
  }
}