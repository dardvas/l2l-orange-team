<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Become mentor for refugee and expats">
    <meta name="keywords" content="mentor advise refugee expats">
    <link rel="stylesheet" type="text/css" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/custom.css">
    <title>Become a advisor</title>
</head>

<body>
<header>
    <nav class="navbar navbar-light">
        <div class="container">
            <div class="topnavhelp">
                Help&GetHelp
            </div>

            <div class="topnav">
                <a href="{$findMentorUrl}">How to find an advisor?</a>
                <a href="{$becomeMentorUrl}">How to become an advisor?</a>
                <a href="{$profileUrl}">Profile</a>
            </div>
            Logged in as {$currentUser.username}
            <form method="post" action="{$logoutActionUrl}">
                <input type="submit" value="Logout">
            </form>

        </div>
    </nav>
</header>

<main>
    <div class="row justify-content-center">
        <div class="col-md-8 p-5">
            <div class="card">
                <div class="card-header">
                    Become an advisor
                </div>
                <div class="card-body">
                    <form method="post" action="{$formSubmitActionUrl}">
                        <div class="form-group">
                            <label for="timeslot_id">Choose appropriate time for you (GMT+3)</label>
                            <select name="timeslot_id" id="timeslot_id">
                                {foreach $timeslots as $key => $value}
                                    <option value="{$key}">{$value}</option>
                                {/foreach}
                            </select>
                        </div>

                        <label class="container">I want to do one-time meetings only
                            <input type="checkbox" name="checkbox" id="checkbox">
                            <span class="checkmark"></span>
                        </label>

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
                            <input type="text" name="request" class="form-control" id="request">
                        </div>
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary" value="Submit">
                                Send a request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</main>

<footer>
    <div class="footer container text-center">
        <a><p>&copy; 2022 Help&GetHelp. All rights reserved.</p> </a>
    </div>
</footer>

</body>

</html>
