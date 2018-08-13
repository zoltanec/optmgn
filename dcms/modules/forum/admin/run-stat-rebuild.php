<?php
try {
	$section = dFactory::ForumSection(D::$req->int('sid'));
} catch (Exception $e) {
	D::$Tpl->RedirectOrText('~/','NO_SUCH_SECTION');
}
$section->runStatRebuild();
D::$Tpl->RedirectOrText('~/edit-section/sid_'.$section->sid);
?>