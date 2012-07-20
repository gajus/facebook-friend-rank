[ay-fb-friend-rank](https://github.com/anuary/ay-fb-friend-rank/) ([demonstration](https://dev.anuary.com/a67edf20-19c9-5d3e-b440-c94f91bc63fe/)) is a PHP 5.3 class that can calculate who are the best user's friends. Data accuracy depends on the user activity and granted permissions. The only dependancy is [Facebook PHP SDK](https://github.com/facebook/php-sdk/).

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
	
By default every action is valued 1. Every criteria can be assigned an individual weight using `setCriteriaWeight([action name, see $criteria], [numeric value])` method.

This class will become redundant once Facebook makes `communication_rank` column publicly available.

	SELECT uid2, communication_rank FROM friend where uid1 = me() ORDER BY communication_rank DESC LIMIT 10;