<?php
namespace Nichin79\Zendesk\Ticketing\Tickets;

use Nichin79\Curl\BasicCurl;

class Attachments
{
  protected array $data = [];

  public function __construct(array $data)
  {
    $this->data = $data;
  }

  public function delete(string $token)
  {
    $data = $this->data;
    $data['method'] = 'DELETE';
    $data['url'] = sprintf('%s/api/v2/uploads/%s', $data['baseurl'], $token);
    return new BasicCurl($data);
  }

  public function show(int $attachmentId)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/attachments/%s', $data['baseurl'], $attachmentId);
    return new BasicCurl($data);
  }

  public function update_malware(int $attachmentId, bool $bool = true)
  {
    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = sprintf('%s/attachments/%s', $data['baseurl'], $attachmentId);
    $data['data'] = '{"attachment": {"malware_access_override": ' . $bool . '}}';
    return new BasicCurl($data);
  }

  public function redact(int $ticketId, int $commentId, int $attachmentId)
  {
    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = sprintf('%s/tickets/%s/comments/%s/attachments/%s/redact', $data['baseurl'], $ticketId, $commentId, $attachmentId);
    $data['data'] = '{}';
    return new BasicCurl($data);
  }


}