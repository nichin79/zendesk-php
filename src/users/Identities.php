<?php
namespace Nichin79\Zendesk\Users;

use Nichin79\Curl\BasicCurl;

class Identities
{
  protected array $data = [];

  public function __construct(array $data)
  {
    $this->data = $data;
  }

  public function list_user_identities(int $userId)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/users/%s/identities', $data['baseurl'], $userId);
    return new BasicCurl($data);
  }

  public function list_end_user_identities(int $userId)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/end_users/%s/identities', $data['baseurl'], $userId);
    return new BasicCurl($data);
  }

  public function show_user_identity(int $userId, int $identityId)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/users/%s/identities/%s', $data['baseurl'], $userId, $identityId);
    return new BasicCurl($data);
  }

  public function show_end_user_identity(int $userId, int $identityId)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/end_users/%s/identities/%s', $data['baseurl'], $userId, $identityId);
    return new BasicCurl($data);
  }

  public function create_user_identity(int $userId, string $body)
  {
    $data = $this->data;
    $data['method'] = 'POST';
    $data['url'] = sprintf('%s/users/%s/identities.json', $data['baseurl'], $userId);
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  public function create_end_user_identity(int $userId, string $body)
  {
    $data = $this->data;
    $data['method'] = 'POST';
    $data['url'] = sprintf('%s/end_users/%s/identities.json', $data['baseurl'], $userId);
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  public function update_user_identity(int $userId, int $identityId, string $body)
  {
    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = sprintf('%s/users/%s/identities/%s.json', $data['baseurl'], $userId, $identityId);
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  public function make_user_identity_primary(int $userId, int $identityId)
  {
    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = sprintf('%s/users/%s/identities/%s/make_primary.json', $data['baseurl'], $userId, $identityId);
    $data['data'] = '{}';
    return new BasicCurl($data);
  }

  public function make_end_user_identity_primary(int $userId, int $identityId)
  {
    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = sprintf('%s/end_users/%s/identities/%s/make_primary.json', $data['baseurl'], $userId, $identityId);
    $data['data'] = '{}';
    return new BasicCurl($data);
  }

  public function verify_user_identity(int $userId, int $identityId)
  {
    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = sprintf('%s/users/%s/identities/%s/verify.json', $data['baseurl'], $userId, $identityId);
    $data['data'] = '{}';
    return new BasicCurl($data);
  }

  public function request_user_verification(int $userId, int $identityId)
  {
    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = sprintf('%s/users/%s/identities/%s/request_verification.json', $data['baseurl'], $userId, $identityId);
    $data['data'] = '{}';
    return new BasicCurl($data);
  }

  public function request_end_user_verification(int $userId, int $identityId)
  {
    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = sprintf('%s/end_users/%s/identities/%s/request_verification.json', $data['baseurl'], $userId, $identityId);
    $data['data'] = '{}';
    return new BasicCurl($data);
  }

  public function delete_user_identity(int $userId, int $identityId)
  {
    $data = $this->data;
    $data['method'] = 'DELETE';
    $data['url'] = sprintf('%s/users/%s/identities/%s.json', $data['baseurl'], $userId, $identityId);
    return new BasicCurl($data);
  }

  public function delete_end_user_identity(int $userId, int $identityId)
  {
    $data = $this->data;
    $data['method'] = 'DELETE';
    $data['url'] = sprintf('%s/end_users/%s/identities/%s.json', $data['baseurl'], $userId, $identityId);
    return new BasicCurl($data);
  }
}