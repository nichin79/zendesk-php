<?php
namespace Nichin79\Zendesk;

use Nichin79\Curl\BasicCurl;


class Users
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
    $data['url'] = 'https://' . $data['subdomain'] . '.zendesk.com/api/v2/users';
    return new BasicCurl($data);
  }

  public function tickets_requested(int $userId)
  {
    $data = $this->data;
    $data['method'] = 'GET';
    $data['url'] = 'https://' . $data['subdomain'] . '.zendesk.com/api/v2/users/' . $userId . '/tickets/requested';
    return new BasicCurl($data);
  }

  public function tickets_ccd(int $userId)
  {
    $data = $this->data;
    $data['method'] = 'GET';
    $data['url'] = 'https://' . $data['subdomain'] . '.zendesk.com/api/v2/users/' . $userId . '/tickets/ccd';
    return new BasicCurl($data);
  }

  public function tickets_followed(int $userId)
  {
    $data = $this->data;
    $data['method'] = 'GET';
    $data['url'] = 'https://' . $data['subdomain'] . '.zendesk.com/api/v2/users/' . $userId . '/tickets/followed';
    return new BasicCurl($data);
  }

  public function tickets_assigned(int $userId)
  {
    $data = $this->data;
    $data['method'] = 'GET';
    $data['url'] = 'https://' . $data['subdomain'] . '.zendesk.com/api/v2/users/' . $userId . '/tickets/assigned';
    return new BasicCurl($data);
  }

  public function count()
  {
    $data = $this->data;
    $data['method'] = 'GET';
    $data['url'] = 'https://' . $data['subdomain'] . '.zendesk.com/api/v2/users/count';
    return new BasicCurl($data);
  }

  public function show(int $userId)
  {
    $data = $this->data;
    $data['method'] = 'GET';
    $data['url'] = 'https://' . $data['subdomain'] . '.zendesk.com/api/v2/users/' . $userId . '.json';
    return new BasicCurl($data);
  }

  public function show_many(array $userIds)
  {
    $userIds = implode(',', $userIds);
    $data = $this->data;
    $data['method'] = 'GET';
    $data['url'] = 'https://' . $data['subdomain'] . ".zendesk.com/api/v2/users/show_many.json?ids=$userIds";
    return new BasicCurl($data);
  }

  public function related(int $userId)
  {
    $data = $this->data;
    $data['method'] = 'GET';
    $data['url'] = 'https://' . $data['subdomain'] . '.zendesk.com/api/v2/users/' . $userId . '/related.json';
    return new BasicCurl($data);
  }

  public function me()
  {
    $data = $this->data;
    $data['method'] = 'GET';
    $data['url'] = 'https://' . $data['subdomain'] . '.zendesk.com/api/v2/users/me';
    return new BasicCurl($data);
  }

  public function create(string $data)
  {
    $data = $this->data;
    $data['method'] = 'POST';
    $data['url'] = 'https://' . $data['subdomain'] . '.zendesk.com/api/v2/users.json';
    $data['headers'] = ["Content-Type: application/json"];
    $data['data'] = $data;
    return new BasicCurl($data);
  }

  public function create_many(string $data)
  {
    $data = $this->data;
    $data['method'] = 'POST';
    $data['url'] = 'https://' . $data['subdomain'] . '.zendesk.com/api/v2/users/create_many.json';
    $data['headers'] = ["Content-Type: application/json"];
    $data['data'] = $data;
    return new BasicCurl($data);
  }

  public function create_or_update(string $data)
  {
    $data = $this->data;
    $data['method'] = 'POST';
    $data['url'] = 'https://' . $data['subdomain'] . '.zendesk.com/api/v2/users/create_or_update.json';
    $data['headers'] = ["Content-Type: application/json"];
    $data['data'] = $data;
    return new BasicCurl($data);
  }

  public function create_or_update_many(string $data)
  {
    $data = $this->data;
    $data['method'] = 'POST';
    $data['url'] = 'https://' . $data['subdomain'] . '.zendesk.com/api/v2/users/create_or_update_many.json';
    $data['headers'] = ["Content-Type: application/json"];
    $data['data'] = $data;
    return new BasicCurl($data);
  }

  public function request_create(string $data)
  {
    $data = $this->data;
    $data['method'] = 'POST';
    $data['url'] = 'https://' . $data['subdomain'] . '.zendesk.com/api/v2/users/request_create.json';
    $data['headers'] = ["Content-Type: application/json"];
    $data['data'] = $data;
    return new BasicCurl($data);
  }

  public function update(int $userId, string $data)
  {
    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = 'https://' . $data['subdomain'] . '.zendesk.com/api/v2/users/' . $userId . '.json';
    $data['headers'] = ["Content-Type: application/json"];
    $data['data'] = $data;
    return new BasicCurl($data);
  }

  public function update_many(array $userIds, string $data)
  {
    $ids = '';
    if ((isset($userIds['external_ids'])) && (count($userIds['external_ids']) > 0)) {
      $ids = '?external_ids=' . implode(',', $userIds['external_ids']);
    }

    if ((isset($userIds['ids'])) && (count($userIds['ids']) > 0)) {
      $ids = '?ids=' . implode(',', $userIds['ids']);
    }

    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = 'https://' . $data['subdomain'] . ".zendesk.com/api/v2/users/update_many.json$ids";
    $data['headers'] = ["Content-Type: application/json"];
    $data['data'] = $data;
    return new BasicCurl($data);
  }
}