<?php
namespace Nichin79\Zendesk;

use Nichin79\Curl\BasicCurl;
use Nichin79\Zendesk\Users\Identities;

class Users
{
  protected array $data = [];
  public Users\Identities $identities;

  public function __construct(array $data)
  {
    $this->data = $data;

    foreach (Zendesk::get_modules($this->data['modules']['users']) as $module) {
      switch ($module) {
        case 'identities';
          $this->identities = new Identities($this->data);
          break;
      }
    }
  }

  public function list()
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/users', $data['baseurl']);
    return new BasicCurl($data);
  }

  public function list_group(int $groupId)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/groups/%s/users', $data['baseurl'], $groupId);
    return new BasicCurl($data);
  }

  public function list_organization(int $organizationId)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/organization/%s/users', $data['baseurl'], $organizationId);
    return new BasicCurl($data);
  }

  public function list_deleted()
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/deleted_users.json', $data['baseurl']);
    return new BasicCurl($data);
  }

  public function count()
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/users/count', $data['baseurl']);
    return new BasicCurl($data);
  }

  public function count_deleted()
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/deleted_users/count.json', $data['baseurl']);
    return new BasicCurl($data);
  }

  public function show(int $userId)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/users/%s.json', $data['baseurl'], $userId);
    return new BasicCurl($data);
  }

  public function show_many(array $userIds)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/users/show_many.json?ids=%s', $data['baseurl'], implode(',', $userIds));
    return new BasicCurl($data);
  }

  public function related(int $userId)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/users/%s/related.json', $data['baseurl'], $userId);
    return new BasicCurl($data);
  }

  public function me()
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/users/me', $data['baseurl']);
    return new BasicCurl($data);
  }

  public function create(string $body)
  {
    $data = $this->data;
    $data['method'] = 'POST';
    $data['url'] = sprintf('%s/users.json', $data['baseurl']);
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  public function create_many(string $body)
  {
    $data = $this->data;
    $data['method'] = 'POST';
    $data['url'] = sprintf('%s/users/create_many.json', $data['baseurl']);
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  public function create_or_update(string $body)
  {
    $data = $this->data;
    $data['method'] = 'POST';
    $data['url'] = sprintf('%s/users/create_or_update.json', $data['baseurl']);
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  public function create_or_update_many(string $body)
  {
    $data = $this->data;
    $data['method'] = 'POST';
    $data['url'] = sprintf('%s/users/create_or_update_many.json', $data['baseurl']);
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  public function request_create(string $body)
  {
    $data = $this->data;
    $data['method'] = 'POST';
    $data['url'] = sprintf('%s/users/request_create.json', $data['baseurl']);
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  public function update(int $userId, string $body)
  {
    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = sprintf('%s/users/%s.json', $data['baseurl'], $userId);
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  public function update_many(array $userIds, string $body)
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
    $data['url'] = sprintf('%s/users/update_many.json%s', $data['baseurl'], $ids);
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  public function merge(int $userId, string $body)
  {
    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = sprintf('%s/users/%s/merge.json', $data['baseurl'], $userId);
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  public function delete(int $userId)
  {
    $data = $this->data;
    $data['method'] = 'DELETE';
    $data['url'] = sprintf('%s/users/%s.json', $data['baseurl'], $userId);
    return new BasicCurl($data);
  }

  public function delete_many(array $userIds)
  {
    $ids = '';
    if ((isset($userIds['external_ids'])) && (count($userIds['external_ids']) > 0)) {
      $ids = '?external_ids=' . implode(',', $userIds['external_ids']);
    }

    if ((isset($userIds['ids'])) && (count($userIds['ids']) > 0)) {
      $ids = '?ids=' . implode(',', $userIds['ids']);
    }

    $data = $this->data;
    $data['method'] = 'DELETE';
    $data['url'] = sprintf('%s/users/destroy_many?ids=%s', $data['baseurl'], $ids);
    return new BasicCurl($data);
  }

  public function delete_permanently(int $userId)
  {
    $data = $this->data;
    $data['method'] = 'DELETE';
    $data['url'] = sprintf('%s/deleted_users/%s.json', $data['baseurl'], $userId);
    return new BasicCurl($data);
  }

  public function show_deleted(int $userId)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/deleted_users/%s.json', $data['baseurl'], $userId);
    return new BasicCurl($data);
  }

  public function compliance_deletion_statuses(int $userId, string $application = null)
  {
    $params = '';
    if (isset($application) && $application !== null) {
      $params = '?application=' . $application;
    }
    $data = $this->data;
    $data['url'] = sprintf('%s/users/%s/compliance_deletion_statuses%s', $data['baseurl'], $userId, $params);
    return new BasicCurl($data);
  }

  public function logout_many(array $userIds)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/users/logout_many.json?ids=%s', $data['baseurl'], implode(',', $userIds));
    return new BasicCurl($data);
  }

  /*
   * ALIAS FUNCTIONS
   */
  public function deleted()
  {
    return $this->list_deleted();
  }
}