<!DOCTYPE html>
<html lang="en">
<header>
    Logged in as {$currentUser.username}
    <form method="post" action="{$logoutActionUrl}">
        <input type="submit" value="Logout">
    </form>
</header>

<main>
    <h1>Find a mentor</h1>

    <form method="post" action="{$formSubmitActionUrl}">

        <div class="form">
            <label for="timeslot_id">Choose appropriate time for you (GMT+3)</label>
            <select name="timeslot_id" id="timeslot_id">
                {foreach $timeslots as $key => $value}
                    <option value="{$key}">{$value}</option>
                {/foreach}
            </select>
        </div>

        <div class="form">
            <label for="checkbox">I need only one meeting </label>
            <input type="checkbox" name="checkbox" maxlength="30" class="form-control" id="checkbox"
        </div>

        <div class="form">
            <label for="category_id">Choose a category</label>
            <select name="category_id" id="category_id">
                {foreach $categories as $key => $value}
                    <option value="{$key}">{$value}</option>
                {/foreach}
            </select>
        </div>

        <input type="hidden" name="user_id" value="{$currentUser.id}">

        <input type="submit" value="Submit">

    </form>

</main>


</html>
