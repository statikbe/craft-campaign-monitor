# Campaign Monitor plugin for Craft CMS 4.x

[Campaign Monitor](https://www.campaignmonitor.com/) integration for Craft CMS. Subscribe to a mailing list through a form.

## Requirements

This plugin requires Craft CMS 4.0.0 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

```
   cd /path/to/project
```

2. Then tell Composer to load the plugin:

```
    composer require statikbe/craft-campaign-monitor
```

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Campaign Monitor.

## Usage

To use:

After installing and enabling the plugin, you'll need to enter your **API Key** and **Client ID** from your Campaign Monitor account under *Settings > Campaign Monitor*.

By default, a contact in Campaign Monitor has the following fields:

* Email (required)
* Name

### Basic Subscribe Form

You can implement a subscribe form in your templates using the following code. Note that **Resubscribe** will be set to **true**.

`````html
<form method="post">
    {{ csrfInput() }}
    {{ actionInput('campaign-monitor/subscribe') }}
    {{ redirectInput('foo/bar') }}
    {{ hiddenInput('listId', 'ListID'|hash) }}
      
    <label for="email">E-mail</label>
    <input type="email" name="email" required />
      
    {# Use firstname + lastname fields, or fullname (optional) #}
    <label for="firstname">First Name</label>
    <input type="text" name="firstname" />
    <label for="lastname">Last Name</label>
    <input type="text" name="lastname" />
    {# <label for="fullname">Full Name</label>
      <input type="text" name="fullname" /> #}
      
    <button type="submit">Subscribe</button>
</form>
`````

### Subscribe form with custom fields
Campaign Monitor custom fields can be added in the ``fields`` namespace.
For example ``fields[city]``, where "city" is the handle of the custom field in Campaign Monitor.

`````html
 <form method="post">
    {{ csrfInput() }}
    {{ actionInput('campaign-monitor/subscribe') }}
    {{ redirectInput('foo/bar') }}
    {{ hiddenInput('listId', 'ListID'|hash) }}

    <label for="email">E-mail</label>
    <input type="email" name="email" required />
   

    <label>Custom Field</label>
    <input type="text" name="fields[CustomFieldCampaignMonitor]" placeholder="Some Value" value="Some Value" />

    <button type="submit">Subscribe</button>
</form>
`````

## Credits

Heavily inspired by [clearbold/craft-campaignmonitor-service](https://github.com/clearbold/craft-campaignmonitor-service) and [clearbold/craft-campaignmonitor-lists](https://github.com/clearbold/craft-campaignmonitor-lists).