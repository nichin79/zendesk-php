<?php
namespace Nichin79\Zendesk\Ticketing\Users;

use Nichin79\Curl\BasicCurl;

class Identities
{
  protected array $data = [];

  public function __construct(array $data)
  {
    $this->data = $data;
  }

  /**
   * Returns a list of identities for the given user.
   * Use the first endpoint if authenticating as an agent. Use the second if authenticating as an end user. End users can only list email and phone number identities.
   *
   * @param integer $userId  The id of the user
   * @param string $endpoint  users / end_users
   * @return BasicCurl
   */
  public function list(int $userId, string $endpoint = 'users')
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/%s/%s/identities', $data['baseurl'], $endpoint, $userId);
    return new BasicCurl($data);
  }

  /**
   * Shows the identity with the given id for a given user.
   * Use the first endpoint if authenticating as an agent. Use the second if authenticating as an end user. End users can only view email or phone number identity.
   *
   * @param integer $userId  The id of the user
   * @param integer $identityId  The ID of the user identity
   * @param string $endpoint  users / end_users
   * @return BasicCurl
   */
  public function show(int $userId, int $identityId, string $endpoint = 'users')
  {
    $data = $this->data;
    $data['url'] = sprintf('%s/%s/%s/identities/%s', $data['baseurl'], $endpoint, $userId, $identityId);
    return new BasicCurl($data);
  }

  /**
   * Adds an identity to a user's profile. An agent can add an identity to any user profile.
   * Use the first endpoint if authenticating as an agent. Use the second if authenticating as an end user. End users can only view email or phone number identity.
   *
   * @param integer $userId  The id of the user
   * @param string $body  The json body of the identity to create
   * @param string $endpoint  users / end_users
   * @return BasicCurl
   */
  public function create(int $userId, string $body, string $endpoint = 'users')
  {
    $data = $this->data;
    $data['method'] = 'POST';
    $data['url'] = sprintf('%s/%s/%s/identities.json', $data['baseurl'], $endpoint, $userId);
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  /**
   * This endpoint allows you to:
   * - Set the specified identity as verified (but you cannot unverify a verified identity)
   * - Update the value property of the specified identity
   * You can't change an identity's primary attribute with this endpoint. You must use the Make Identity Primary endpoint instead.
   *
   * @param integer $userId  The id of the user
   * @param integer $identityId  The ID of the user identity
   * @param string $body  The json body of the identity to create
   * @return BasicCurl
   */
  public function update(int $userId, int $identityId, string $body)
  {
    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = sprintf('%s/users/%s/identities/%s.json', $data['baseurl'], $userId, $identityId);
    $data['data'] = $body;
    return new BasicCurl($data);
  }

  /**
   * Sets the specified identity as primary.
   * Use the first endpoint if authenticating as an agent. Use the second if authenticating as an end user.
   *
   * @param integer $userId  The id of the user
   * @param integer $identityId  The ID of the user identity
   * @param string $endpoint  users / end_users
   * @return BasicCurl
   */
  public function make_identity_primary(int $userId, int $identityId, string $endpoint = 'users')
  {
    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = sprintf('%s/%s/%s/identities/%s/make_primary.json', $data['baseurl'], $endpoint, $userId, $identityId);
    $data['data'] = '{}';
    return new BasicCurl($data);
  }

  /**
   * Sets the specified identity as verified.
   * For security reasons, you can't use this endpoint to update the email identity of the account owner. To verify the person's identity, send a verification email. See Verifying the account owner's email address in Zendesk help.
   *
   * @param integer $userId  The id of the user
   * @param integer $identityId  The ID of the user identity
   * @return BasicCurl
   */
  public function verify_identity(int $userId, int $identityId)
  {
    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = sprintf('%s/users/%s/identities/%s/verify.json', $data['baseurl'], $userId, $identityId);
    $data['data'] = '{}';
    return new BasicCurl($data);
  }

  /**
   * Sends the user a verification email with a link to verify ownership of the email address.
   *
   * @param integer $userId  The id of the user
   * @param integer $identityId  The ID of the user identity
   * @param string $endpoint  users / end_users
   * @return BasicCurl
   */
  public function request_user_verification(int $userId, int $identityId, string $endpoint = 'users')
  {
    $data = $this->data;
    $data['method'] = 'PUT';
    $data['url'] = sprintf('%s/%s/%s/identities/%s/request_verification.json', $data['baseurl'], $endpoint, $userId, $identityId);
    $data['data'] = '{}';
    return new BasicCurl($data);
  }

  /**
   * Deletes the identity for a given user. In certain cases, a phone number associated with an identity is still visible on the user profile after the identity has been deleted via API. You can remove the phone number from the user profile by updating the phone attribute of the user to an empty string. See Update User via API for details and examples.
   *
   * @param integer $userId  The id of the user
   * @param integer $identityId  The ID of the user identity
   * @param string $endpoint  users / end_users
   * @return BasicCurl
   */
  public function delete_identity(int $userId, int $identityId, string $endpoint = 'users')
  {
    $data = $this->data;
    $data['method'] = 'DELETE';
    $data['url'] = sprintf('%s/%s/%s/identities/%s.json', $data['baseurl'], $endpoint, $userId, $identityId);
    return new BasicCurl($data);
  }
}