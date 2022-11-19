<!DOCTYPE html>
<html lang="en">
<header>
    Logged in as {$currentUser.username}
    <form method="post" action="{$logoutActionUrl}">
        <input type="submit" value="Logout">
    </form>
</header>
</head>


<main>
    <form method="post" action="{$formSubmitActionUrl}">

        <div class="form">
            <label for="category">Choose appropriate time for you (GMT+3)</label>
            <select name="category" id="category">
                <option value="1">From 9 AM to 12 PM</option>
                <option value="2">From 12 PM to 3 PM</option>
                <option value="3">From 3 PM to 6 PM</option>
                <option value="4">From 6 PM to 10 PM</option>
            </select>
         </div>
        <div class="form">
        <label for="checkbox">I need only one meeting </label>  
        <input type="checkbox" name="checkbox" maxlength="30" class="form-control" id="checkbox"
        </div>

        <div class="form">
            <label for="category">Choose a category</label>
            <select name="category" id="category">
                <option value="1">Work</option>
                <option value="2">Rent</option>
                <option value="3">Visa, documents</option>
                <option value="4">Language</option>
                <option value="5">Health</option>
                <option value="6">Childcare</option>
                <option value="7">Other</option>
            </select>
         </div>
        

        <label for="input-tweet-message"></label>
        <input type="text" id="input-tweet-message" name="message">
        <input type="hidden" name="user_id" value="{$currentUserId}">
        <input type="submit" value="Submit">

    </form>

</main>


</aside>
