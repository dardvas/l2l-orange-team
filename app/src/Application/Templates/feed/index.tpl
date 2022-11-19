<header>
    Logged in as {$currentUser.username}
    <form method="post" action="{$logoutActionUrl}">
        <input type="submit" value="Logout">
    </form>
</header>

<main>
    {if $isMyFeed}
    <form method="post" action="{$tweetSubmitActionUrl}">
        <label for="input-tweet-message"></label>
        <input type="text" id="input-tweet-message" name="message">

        <input type="hidden" name="user_id" value="{$currentUser.id}">

        <input type="submit" value="Tweet">
    </form>
    {/if}

    {if ! $isMyFeed && ! $isSubscribed}
    <form method="post" action="{$subscribeActionUrl}">
        <input type="hidden" name="subscriber_id" value="{$currentUser.id}">
        <input type="hidden" name="publisher_id" value="{$feedOwner.id}">

        <input type="submit" value="Subscribe">
    </form>
    {/if}

    <div>
        <ul>
            {foreach from=$tweets item=tweet}
                <li>#{$tweet.id} - {$tweet.message} <small>(created at {$tweet.created_at_timestamp})</small></li>
            {/foreach}
        </ul>
    </div>
</main>

<aside>
    <h2>Something curious here you may find</h2>
    <ul>
        {foreach from=$otherUsersFeeds item=otherUserFeed}
            <li>
                <a href="{$otherUserFeed.feed_url}">{$otherUserFeed.username}</a><br>
                <small>Last message: {$otherUserFeed.last_tweet_message}</small>
            </li>
        {/foreach}
    </ul>
</aside>
