<header>
    Logged in as {$currentUserId}
    <form method="post" action="{$logoutActionUrl}">
        <input type="submit" value="Logout">
    </form>
</header>

<main>
    <form method="post" action="{$formSubmitActionUrl}">
        <label for="input-tweet-message"></label>
        <input type="text" id="input-tweet-message" name="message">

        <input type="hidden" name="user_id" value="{$currentUserId}">

        <input type="submit" value="Submit">
    </form>
</main>

<aside>
    <h2>Something curious here you may find</h2>

</aside>
