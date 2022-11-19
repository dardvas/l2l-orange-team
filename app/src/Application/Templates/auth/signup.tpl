<h1>Signup form</h1>
<form action="{$actionUrl}" method="post">
    <label for="input-username">Username</label>
    <input type="text" id="input-username" name="username">

    <label for="input-password">Password</label>
    <input type="password" id="input-password" name="password">

    <label for="input-password-repeat">Password repeat</label>
    <input type="password" id="input-password-repeat" name="password_repeat">

    <input type="submit">
</form>

<a href="{$loginUrl}">Log in</a>
