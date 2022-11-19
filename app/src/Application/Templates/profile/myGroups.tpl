<img height="200px" width="200px" stype="background: grey" src="">
<h3>{$currentUser.username}</h3>
<hr>
<b><a href=".">I advise</a></b>
<a href="{$myMentorsUrl}">I attend</a>
<ul>
    {foreach $myGroups as $group}
        <li>{$group}</li>
    {/foreach}
</ul>
