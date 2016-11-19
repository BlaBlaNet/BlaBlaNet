<?php

if(! function_exists("string_plural_select_pl")) {
function string_plural_select_pl($n){
	return ($n==1 ? 0 : $n%10>=2 && $n%10<=4 && ($n%100<10 || $n%100>=20) ? 1 : 2);;
}}
;
App::$strings["Administrator"] = "Administrator";
App::$strings["Your account on %s will expire in a few days."] = "Twoje konto w  %s wygaśnie w ciągu kilku dni.";
App::$strings["Your Friendica test account is about to expire."] = "Twoje testowe konto Friendica za chwilę wygaśnie.";
App::$strings["Hi %1\$s,\n\nYour test account on %2\$s will expire in less than five days. We hope you enjoyed this test drive and use this opportunity to find a permanent Friendica website for your integrated social communications. A list of public sites is available at http://dir.friendica.com/siteinfo - and for more information on setting up your own Friendica server please see the Friendica project website at http://friendica.com."] = "Witaj %1\$s,\n\nTwoje konto testowe na %2\$s wygaśnie za mniej niż pięć dni. Mamy nadzieję, że Ci się podobało i wkrótce zarejestrujesz się na zawsze na jednej ze stron Friendica. Lista stron dostępnych publicznie jest dostępna w http://dir.friendica.com/siteinfo. Po więcej informacji o zakładaniu własnego serwera, odwiedź proszę stronę http://friendica.com.";
