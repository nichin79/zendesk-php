<?php
namespace Nichin79\Zendesk\Tickets;

use Nichin79\Curl\BasicCurl;

class Requests
{
  protected array $data = [];

  public function __construct(array $data)
  {
    $this->data = $data;
  }

  private function getBaseUrl(string $subdomain = null)
  {
    if (empty($subdomain)) {
      $subdomain = $this->data['subdomain'];
    }
    $baseurl = sprintf('%s://%s%s', $this->data['baseprotocol'], $subdomain, $this->data['basepath']);
    return $baseurl;
  }

  public function list(string $subdomain = null)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/requests', $this->getBaseUrl($subdomain));
    return new BasicCurl($data);
  }

  public function list_user(int $userId, string $subdomain = null)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/users/%s/requests.json', $this->getBaseUrl($subdomain), $userId);
    return new BasicCurl($data);
  }

  public function list_organization(int $orgId, string $subdomain = null)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/organizations/%s/requests.json', $this->getBaseUrl($subdomain), $orgId);
    return new BasicCurl($data);
  }

  public function search(array $params = [], string $subdomain = null)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/requests/search.json?%s', $this->getBaseUrl($subdomain), http_build_query($params));
    return new BasicCurl($data);
  }

  public function show(int $requestId, string $subdomain = null)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/requests/%s', $this->getBaseUrl($subdomain), $requestId);
    return new BasicCurl($data);
  }

  public function create(string $body, string $subdomain = null)
  {
    $data = $this->data;
    $data['method'] = 'POST';
    $data['url'] = sprintf('%s/requests.json', $this->getBaseUrl($subdomain));
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  public function update(int $requestId, string $body, string $subdomain = null)
  {
    $data = $this->data;
    $data['method'] = 'POST';
    $data['url'] = sprintf('%s/requests/%s.json', $this->getBaseUrl($subdomain), $requestId);
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  public function comments(int $requestId, string $subdomain = null)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/requests/%s/comments.json', $this->getBaseUrl($subdomain), $requestId);
    return new BasicCurl($data);
  }

  public function comment(int $requestId, int $commentId, string $subdomain = null)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/requests/%s/comments/%s.json', $this->getBaseUrl($subdomain), $requestId, $commentId);
    return new BasicCurl($data);
  }
}