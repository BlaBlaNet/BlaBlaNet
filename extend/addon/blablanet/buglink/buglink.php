<?php
/**
 * Name: BugLink
 * Description: Show link to project bug site at bottom of page
 * Version: 1.0
 * Author: Mike Macgirvin <mike@macgirvin.com>
 * Maintainer:
 * MinVersion: 1.0
 */


function buglink_load() { register_hook('page_end', 'addon/buglink/buglink.php', 'buglink_active'); }

function buglink_unload() { unregister_hook('page_end', 'addon/buglink/buglink.php', 'buglink_active'); }

function buglink_active(&$a,&$b) { $b .= '<div style="position: fixed; bottom: 5px; left: 5px;" class="hidden-xs"><a href="https://geditlab.com/blablanet/BlaBlanet/issues" target="_blank" title="' . t('Report Bug') . '"><img src="addon/buglink/bug-x.gif" alt="' . t('Report Bug') . '" /></a></div>'; } 
