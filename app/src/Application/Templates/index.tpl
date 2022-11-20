<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Find mentor for refugee and expats">
    <meta name="keywords" content="mentor advise refugee expats">
    <link rel="stylesheet" type="text/css" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/custom.css">
    <title>Find a mentor</title>
</head>

<body>
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
                {/if}
                {if !$isAuthorized}
                    Join our community!
                    <div class="topnav">
                        <a href="{$loginUrl}">Log in</a>
                        <a href="{$signupUrl}">Sign up</a>

                        <a href="{$loginUrl}">Find an adviser</a>
                        <a href="{$loginUrl}">Become an adviser</a>
                    </div>
                {/if}
            </div>
        </nav>
    </header>

    <main>
        <section>
            <div class="container mt-5">
                <div class="row">
                    <div class="col-4">
                        <img src="./assets/images/image17.png">
                    </div>
                    <div class="col-7 offset-1">
                        <h1>Connect with new local community through helping and getting help</h1>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container mt-3">
                <div class="row">
                    <div class="col-12 text-center mt-2">
                        <p> Get help on any topic of interest from finding housing to adapting your portfolio and resume to the local market</p>
                    </div>
                </div>
                <div class="row">
                    {if $isAuthorized}
                        <div class="col-3 offset-3 text-center">
                            <a href='{$becomeMentorUrl}'><button class="button">Become an advisor</button></a>
                        </div>
                        <div class="col-3 text-center">
                            <a href='{$findMentorUrl}'><button class="button">Find an advisor?</button></a>
                        </div>
                    {/if}
                    {if !$isAuthorized}
                        <div class="col-3 offset-3 text-center">
                            <a href='{$loginUrl}'><button class="button">Become an advisor</button></a>
                        </div>
                        <div class="col-3 text-center">
                            <a href='{$loginUrl}'><button class="button">Find an advisor?</button></a>
                        </div>
                    {/if}
                </div>
            </div>
        </section>

        <section>
            <div class="container mt-3">
                <div class="row">
                    <div class="col-8 offset-4">
                        <h1>Who is our service for?</h1>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <img src="./assets/images/card1.jpg">
                    </div>
                    <div class="col-6">
                        <img src="./assets/images/card2.jpg">
                    </div>
                </div>
            </div>

        </section>
    </main>

    <footer>
        <div class="footer container text-center">
            <p>&copy; 2022 Help&GetHelp. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>
