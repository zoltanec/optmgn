<?php
Notify_Sms::send(D::$config->{'store.notify_admin_number'}, "Call: ".D::$req->textLine('phone'));
D::$tpl->PrintText('OK');
