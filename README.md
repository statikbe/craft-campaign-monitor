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

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Link Field.

## Usage

To use:

After installing and enabling the plugin, you'll need to enter your **API Key** and **Client ID** from your Campaign Monitor account under *Settings > Campaign Monitor*.

### Subscribe Form

You can implement a subscribe form in your templates using the following code. Note that **Resubscribe** will be set to **true**.

```
    <form method="post" action="" accept-charset="UTF-8">
      {{ csrfInput() }}
      <input type="hidden" name="action" value="campaign-monitor/subscribe" />
      {{ redirectInput('foo/bar') }}
      {{ hiddenInput('listId', 'ListID'|hash) }}
      
      <label>Email Address</label>
      <input type="email" name="email" placeholder="john.doe@email.com" required />
      
      {# Use firstname + lastname fields, or fullname (optional) #}
      <label>First Name</label>
      <input type="text" name="firstname" placeholder="John" />
      <label>Last Name</label>
      <input type="text" name="lastname" placeholder="Doe" />
      {# <label>Full Name</label>
      <input type="text" name="fullname" placeholder="John Doe" /> #}
      
      <button type="submit">Submit</button>
    </form>
```

## Credits

Heavily inspired by [clearbold/craft-campaignmonitor-service](https://github.com/clearbold/craft-campaignmonitor-service) and [clearbold/craft-campaignmonitor-lists](https://github.com/clearbold/craft-campaignmonitor-lists).