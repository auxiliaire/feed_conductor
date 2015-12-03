feed_conductor
==============

A Symfony demo application by Viktor Daróczi.

## Demo features ##

### Fetch any twitter feed from Twitter API ###

You can simply fetch a user's feed by calling /fetch/{user_id}. Eg. /fetch/noghayel. All status updates and profile data will be saved to the database.

### Style colors by Twitter API ###

The fetched social profile data will be used to color the page to get customized look.

### Interact with Twitter via connect ###

Use the links below the statuses to interact with Twitter by requesting app authentication. Supported operations are:

* **Retweet** Share tweet with followers
* **Reply** Reply to the author of the tweet
* **Favorite** Add tweet to your favorites

## Tech features ##

* **Symfony 2.7.7**
* **Doctrine 3.5.1**
* **Composer**
* **Abraham TwitterOAuth 0.6.2**
* **Twig 1.23.1**
* **Bower**
* **Bootstrap 3.3.6**
* **Available on github**

Public repository at https://github.com/auxiliaire/feed_conductor