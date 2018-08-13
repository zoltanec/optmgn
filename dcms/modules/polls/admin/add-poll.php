<?php
// create empty poll
$poll = new Polls_Poll();
$poll->active = false;
$poll->save();
D::$Tpl->Redirect('~/edit-poll/'.$poll->poll_id);
?>