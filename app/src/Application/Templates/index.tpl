<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../img/fav/fav.ico" type="image">
    <link rel="apple-touch-icon" sizes="180x180" href="../img/fav/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../img/fav/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/fav/favicon-16x16.png">
    <meta name="description" content="Find mentor for refugee and expats">
    <meta name="keywords" content="mentor advise refugee expats">
    <link rel="stylesheet" type="text/css" href="C:/Users/SunduyoolS/Documents/Dev/l2l-orange-team/app/src/Application/Templates/assets/css/bootstrap.min.css">
    <title>Find a mentor</title>   
</head>

<header>
    <nav class="navbar navbar-light" >
        <div class="container">        
            <div class="topnavhelp">
                Help&GetHelp  
            </div>
        {if $isAuthorized}
            Hola, {$currentUser.username}, que tal?
            <form method="post" action="{$logoutActionUrl}">
                <input type="submit" value="Logout">
            </form>
            <div class="topnav">
                <a href="{$findMentorUrl}">How to find an advisor?</a>
                <a href="{$becomeMentorUrl}">How to become an advisor?</a>
                <a href="{$profileUrl}">Profile</a>
            </div>
        </div>
        {/if}

    {if !$isAuthorized}
        Join our community!
        <div class="topnav">
        <a href="{$loginUrl}">Log in</a>
        <a href="{$signupUrl}">Sign up</a>
   
        <a href="{$loginUrl}">Find an adviser</a>
        <a href="{$loginUrl}">Become an adviser</a>
        <a href="{$findMentorUrl}">How to find an advisor?</a>
        <a href="{$becomeMentorUrl}">How to become an advisor?</a>
    </div>
    {/if}
    </nav> 
</header>

<main>
        <section>
            <code></code>
            <div class="container">
                <div class="img">
                <img src="file:///C:/Users/SunduyoolS/Documents/Dev/l2l-orange-team/app/src/Application/Templates/assets/images/image17.png">
                </div>
                <h1>Connect with new local community through helping and getting help</h1>
            </div>
        </section>

        <div>

        </div>
        <div></div>
        <div></div>

        <section>
        <div class="container">
        <p> Get help on any topic of interest from finding housing to adapting your portfolio and resume to the local market</p>
         </div>
        <a href='{$becomeMentorUrl}'><button class="button">Become an advisor</button></a>       
        <a href='{{$findMentorUrl}'><button class="button">Find an advisor?</button></a>
        </section>

        <section>
            <div class="container">
                <div class="image">
                <img src="file:///C:/Users/SunduyoolS/Documents/Dev/l2l-orange-team/app/src/Application/Templates/assets/images/Who.jpg">
                </div>
            </div>
        </section>

        <section>
            <img src="file:///C:/Users/SunduyoolS/Documents/Dev/l2l-orange-team/app/src/Application/Templates/assets/images/card1.jpg">
            <img src="file:///C:/Users/SunduyoolS/Documents/Dev/l2l-orange-team/app/src/Application/Templates/assets/images/Card2.jpg">

        </section>
</main>
<footer>
    <div class="footer">	
        <a> <p>&copy; 2022 Help&GetHelp. All rights reserved.</p> <a/>
    </div>
</footer>

</body>

</html>