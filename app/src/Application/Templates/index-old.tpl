{if $isAuthorized}
    Hola, {$currentUser.username}, que tal?
    <form method="post" action="{$logoutActionUrl}">
        <input type="submit" value="Logout">
    </form>
    <br>
    <a href="{$findMentorUrl}">Find an adviser</a>
    <a href="{$becomeMentorUrl}">Become an adviser</a>
    <br>
    <a href="{$profileUrl}">Profile</a>
{/if}
{if !$isAuthorized}
    Join our community!
    <br>
    <a href="{$loginUrl}">Log in</a>
    <a href="{$signupUrl}">Sign up</a>

    <br><br>

    We are really cool<br><br>

    Really really<br><br>

    <a href="{$loginUrl}">Find an adviser</a>
    <a href="{$loginUrl}">Become an adviser</a>
{/if}
