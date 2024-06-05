<?php
namespace Nichin79\Zendesk\Ticketing;

use Nichin79\Curl\BasicCurl;
use Nichin79\Zendesk\Ticketing\Groups\Memberships;

class Groups
{
  protected array $data = [];

  public Groups\Memberships $memberships;
  public function __construct(array $data)
  {
    $this->data = $data;

    foreach (\Nichin79\Zendesk\Zendesk::get_modules($this->data['modules']['ticketing']['groups']) as $module) {
      switch ($module) {
        case 'memberships';
          $this->memberships = new Memberships($this->data);
          break;
      }
    }
  }

  /**
   * Returns a maximum of 100 records per page.
   * @param mixed $user_id
   * @return BasicCurl
   */
  public function list($user_id = null)
  {
    $data = $this->data;
    if ($user_id) {
      $data['url'] = sprintf('%s/users/%s/groups.json', $data['baseurl'], $user_id);
    } else {
      $data['url'] = sprintf('%s/groups', $data['baseurl']);
    }
    return new BasicCurl($data);
  }

  /**
   * Returns an approximate count of groups. If the count exceeds 100,000, it is updated every 24 hours.
   * The refreshed_at property of the count object is a timestamp that indicates when the count was last updated.
   * Note: When the count exceeds 100,000, refreshed_at may occasionally be null. This indicates that the count is being updated in the background, and the value property of the count object is limited to 100,000 until the update is complete.
   * 
   * @param mixed $user_id
   * @return BasicCurl
   */
  public function count($user_id = null)
  {
    $data = $this->data;
    if ($user_id) {
      $data['url'] = sprintf('%s/users/%s/groups/count.json', $data['baseurl'], $user_id);
    } else {
      $data['url'] = sprintf('%s/groups/count', $data['baseurl']);
    }
    return new BasicCurl($data);
  }

  /**
   * Returns a maximum of 100 records per page.
   * @return BasicCurl
   */
  public function assignable()
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/groups/assignable.json', $data['baseurl']);
    return new BasicCurl($data);
  }


  /**
   * Returns a group specified by id
   * 
   * @param int $groupId The ID of the group
   * @return BasicCurl
   */
  public function show(int $groupId)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/groups/%s.json', $data['baseurl'], $groupId);
    return new BasicCurl($data);
  }


  /**
   * Creates the group specified in $body.
   * 
   * @param string $body json formatted string of organization to create
   * @return BasicCurl
   */
  public function create(string $body)
  {
    $data = $this->data;
    $data['method'] = 'POST';
    $data['url'] = sprintf('%s/groups.json', $data['baseurl']);
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  /**
   * Update specified group
   * 
   * @param string $groupId Group to update
   * @param string $body json formatted string of data to update
   * @return BasicCurl
   */
  public function update(int $groupId, string $body)
  {
    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = sprintf('%s/groups/%s.json', $data['baseurl'], $groupId);
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  /**
   * Deletes specified group.
   * 
   * @param int $groupId The ID of the group
   * @return BasicCurl
   */
  public function delete(int $groupId)
  {
    $data = $this->data;
    $data['method'] = 'DELETE';
    $data['url'] = sprintf('%s/groups/%s.json', $data['baseurl'], $groupId);
    return new BasicCurl($data);
  }
}