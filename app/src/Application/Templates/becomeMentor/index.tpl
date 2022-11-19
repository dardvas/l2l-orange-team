<!DOCTYPE html>
<html lang="en">
<header>
    Logged in as {$currentUser.username}
    <form method="post" action="{$logoutActionUrl}">
        <input type="submit" value="Logout">
    </form>
</header>

<main>
    <h1>Become a mentor</h1>

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
            <label for="is_one_time">I want to do one-time meetings only </label>
            <input type="checkbox" name="is_one_time" maxlength="30" class="form-control" id="is_one_time"
        </div>

        <div class="form">
            <label for="category_id">Choose a category</label>
            <select name="category_id" id="category_id">
                {foreach $categories as $key => $value}
                    <option value="{$key}">{$value}</option>
                {/foreach}
            </select>
        </div>

        <div class="form">
            <label for="request">Please describe what you can help with</label>
            <input type="text" name="request" maxlength="30" class="form-control" id="request"
        </div>

        <input type="submit" value="Submit">

    </form>

</main>


</html>
