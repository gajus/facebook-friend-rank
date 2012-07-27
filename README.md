# Facebook Friend Rank Algorithm

[ay-fb-friend-rank](https://github.com/anuary/ay-fb-friend-rank/) ([demonstration](https://dev.anuary.com/16caf079-791e-5067-8b4c-76bd40347e2b/)) is a PHP 5.3 class that can calculate who are the best user's friends. Data accuracy depends on the user activity and granted permissions. The only dependancy is [Facebook PHP SDK](https://github.com/facebook/php-sdk/).

All the data is collected in two batched requests. Nonetheless, it takes time for Facebook to prepare this data (sometimes up to 5 seconds). Therefore, you are advised to cache the data once you have it and repeat the query only if user has approved more permissions.

Follow the blog entry about the [Facebook Friend Rank Algorithm](http://anuary.com/43/facebook-friend-rank-algorithm) to find out about possible implementations.

## Criteria

The following steps are taken to calculate the user ranking:

1. The applications looks through user's feed entries. `read_stream` permission is required. However, if the latter is not given the app will rely on the public feed.
	* Profile is given `feed_like` score for liking user's feed .
	* Profile is given `feed_comment` score for leaving a comment on user's feed.
	* Profile is given `feed_addressed` score for addressing user in his feed, whether by posting directly on his wall or tagging the user in his post.

2. Photos. `user_photos` and `friends_photos` permissions are required.
	* Profile is given `photo_tagged_user_by_friend` score if he tagged user in a photo.
	* Profile is given `photo_tagged_friend_by_user` score if user tagged him in a photo.
	* Profile is given `photo_like` score for liking a picture either uploaded by the user or a photo where user is tagged.
	* Profile is given `photo_comment` score for leaving a comment on a picture either uploaded by the user or a photo where user is tagged.

3. Friends. No additional permissions required.
	* Profile is given `friend_mutual` score for every mutual friend.

4. Inbox. `read_mailbox` is required.
	* Every profile is given `inbox_in_conversation` for participating in a mutual conversation with the user.
	* `inbox_chat` score is given for every message in a *duologue*.

## Weights

By default every action is valued 1. Every criteria can be assigned an individual weight using `setCriteriaWeight([action name, see $criteria], [numeric value])` method.

## Roadmap

* There are many more permissions that can improve the friend-rank accuracy that the script doesn't utilise yet, eg. `user_hometown,friends_hometown,user_interests,friends_interests`.
* As per Jeff Widman's thoughts on the EdgeRank (http://edgerank.net/), this script dramatically lacks Time Decay criteria. This is the next thing on the to-do-list.

## Alternatives

### Facebook Developer Love

This class will become redundant once Facebook makes `communication_rank` column publicly available.

	SELECT uid2, communication_rank FROM friend where uid1 = me() ORDER BY communication_rank DESC LIMIT 10;

### Ruby

A similar attempt to calculate the friend index has been made by [Mike Jarema using Ruby](https://github.com/mikejarema/facebook-friend-rank).

## License & Notes

The BSD License - Copyright (c) 2012 [Gajus Kuizinas](http://anuary.com/gajus).