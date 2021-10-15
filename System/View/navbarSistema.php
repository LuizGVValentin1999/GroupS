<div class="topnav">
    <div class="center" style="cursor: pointer;">
        <a  href="chat?group=<?=$_GET['group']?>"  <?=($_GET['url']=='Group/chat'?'class="active"':'')?>>Chat</a>
        <a  href="forum?group=<?=$_GET['group']?>"  <?=($_GET['url']=='Group/forum'?'class="active"':'')?>>Forum</a>
        <a  href="calendario?group=<?=$_GET['group']?>"  <?=($_GET['url']=='Group/calendario'?'class="active"':'')?>>Calendario</a>
    </div>
</div>