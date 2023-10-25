# Zendesk PHP API Library

This is not a complete/full library for Zendesk API's. Development may vary depending on different needs for the moment.

### Config

Subdomain and API credentials can easily be stored in .env file which can then be loaded via the dotenv library

The library uses https://developer.zendesk.com/api-reference as reference and use the different capabilities (Ticketing, Help Center, Live Chat etc) as modules which can be enabled via the configuration.

See examples\conf.php

### Usage

See examples folder for configuration file + basic usage

The library is built in a way to try to match the structure of https://developer.zendesk.com/api-reference as much as possible. For example, the hierarchy shown in the Zendesk API Reference (Capabilites > Subsection > Page) is same/similar as when enabling the modules in the config.

```
'modules' => [
  'ticketing' => [
    'tickets' => ['attachments', comments],
    'search',
    'users' => ['identities']
  ],
  'helpcenter' => [
    'helpcenter' => ['articles', 'attachments', 'comments'],
    'federatedsearch' => ['records', 'sources', 'types']
  ]
]
```
