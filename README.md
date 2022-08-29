# MW-EsekPosts

A Mediawiki extension that fetches the E-Sektionen posts for a specific user if they have `Posts` tag as below.

```html
<Posts>aa0000bb-s</Posts>
```

## Setup

To use this extension you need to set the following global variables in your LocalSettings.php:

```php
$wgEsek['ekorre_url'] // the URL to your api instance
$wgEsek['ekorre_api_key'] // the API key to authenticate the request
```
