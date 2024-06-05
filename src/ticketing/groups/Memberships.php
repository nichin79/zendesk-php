<?php
namespace Nichin79\Zendesk\Ticketing\Groups;

use Nichin79\Curl\BasicCurl;

class Memberships
{
  protected array $data = [];

  public function __construct(array $data)
  {
    $this->data = $data;
  }

  /**
   * Returns a maximum of 100 records per page.
   *
   * @param integer|null $id  The id of the user or group
   * @param string $idType  users / groups - Optional, only required when an id has been specified
   * @return BasicCurl
   */
  public function list(int $id = null, string $idType = 'users')
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/group_memberships', $data['baseurl']);

    if ($id !== null) {
      if ($idType === 'users') {
        $data['url'] = sprintf('%s/users/%s/group_memberships', $data['baseurl'], $id);
      }

      if ($idType === 'groups') {
        $data['url'] = sprintf('%s/groups/%s/memberships', $data['baseurl'], $id);
      }
    }
    return new BasicCurl($data);
  }

  /**
   * Returns a maximum of 100 records per page.
   * @param integer|null $groupId  The id of the user or group
   * @return BasicCurl
   */
  public function assignable(int $groupId = null)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/group_memberships/assignable.json', $data['baseurl']);

    if ($groupId !== null) {
      $data['url'] = sprintf('%s/groups/%s/memberships/assignable.json', $data['baseurl'], $groupId);
    }

    return new BasicCurl($data);
  }

  /**
   * Shows specified group membership.
   * @param integer $membershipId  The id of the group membership id, not the group id
   * @param integer $userId  The id of the user - optional
   * @return BasicCurl
   */
  public function show(int $membershipId, int $userId = null)
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/group_memberships/%s.json', $data['baseurl'], $membershipId);

    if ($userId !== null) {
      $data['url'] = sprintf('%s/users/%s/group_memberships/%s.json', $data['baseurl'], $userId, $membershipId);
    }

    return new BasicCurl($data);
  }

  /**
   * Assigns an agent to a given group.
   * @param string $body json formatted string of data to update
   * @param integer $userId  The id of the user - optional
   * @return BasicCurl
   */
  public function create(string $body, int $userId = null)
  {
    $data = $this->data;
    $data['method'] = 'POST';
    $data['url'] = sprintf('%s/group_memberships.json', $data['baseurl']);

    if ($userId !== null) {
      $data['url'] = sprintf('%s/users/%s/group_memberships.json', $data['baseurl'], $userId);
    }

    $data['data'] = $body;
    return new BasicCurl($data);
  }

  /**
   * Assigns up to 100 agents to given groups.
   * @param string $body json formatted string of data to update
   * @return BasicCurl This endpoint returns a job_status JSON object and queues a background job to do the work. Use the Show Job Status endpoint to check for the job's completion.
   */
  public function create_many(string $body)
  {
    $data = $this->data;
    $data['method'] = 'POST';
    $data['url'] = sprintf('%s/group_memberships/create_many.json', $data['baseurl']);
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  /**
   * Sets the agents default group.
   * @param integer $membershipId  The id of the group membership id, not the group id
   * @param integer $userId  The id of the user
   * @return BasicCurl
   */
  public function make_default(int $userId, int $membershipId)
  {
    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = sprintf('%s/users/%s/group_memberships/%s/make_default.json', $data['baseurl'], $userId, $membershipId);
    $data['data'] = '{}';
    return new BasicCurl($data);
  }

  /**
   * Deletes a membership.
   * @param integer $membershipId  The id of the group membership id, not the group id
   * @param integer $userId  The id of the user - optional
   * @return BasicCurl This endpoint returns a job_status JSON object and queues a background job to do the work. Use the Show Job Status endpoint to check for the job's completion.
   */
  public function delete(int $membershipId, int $userId = null)
  {
    $data = $this->data;
    $data['method'] = 'DELETE';
    $data['url'] = sprintf('%s/group_memberships/%s.json', $data['baseurl'], $membershipId);

    if ($userId !== null) {
      $data['url'] = sprintf('%s/users/%s/group_memberships/%s.json', $data['baseurl'], $userId, $membershipId);
    }

    $data['data'] = '{}';
    return new BasicCurl($data);
  }

  /**
   * Immediately removes users from groups and schedules a job to unassign all working tickets that are assigned to the given user and group combinations.
   * @param array $membershipIds  Array of membership id's to delete.
   * @return BasicCurl
   */
  public function delete_many(array $membershipIds)
  {
    $data = $this->data;
    $data['method'] = 'DELETE';
    $data['url'] = sprintf('%s/group_memberships/destroy_many.json?ids=%s', $data['baseurl'], implode(',', $membershipIds));
    return new BasicCurl($data);
  }
}