<img height="200px" width="200px" stype="background: grey" src="">
<h3>{$currentUser.username}</h3>
<hr>
<a href="{$myGroupsUrl}">I advise</a>
<b><a href=".">I attend</a></b>
<ul>
    {foreach $myMentors as $mentor}
        <li>{$mentor}</li>
    {/foreach}
</ul>
