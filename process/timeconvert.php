<?php 
date_default_timezone_set('Asia/Baku');
function timeConvert ( $zaman ){
	$zaman =  strtotime($zaman);
	$zaman_farki = time() - $zaman;
	$saniye = $zaman_farki;
	$dakika = round($zaman_farki/60);
	$saat = round($zaman_farki/3600);
	$gun = round($zaman_farki/86400);
	$hafta = round($zaman_farki/604800);
	$ay = round($zaman_farki/2419200);
	$yil = round($zaman_farki/29030400);
	if( $saniye < 60 ){
		if ($saniye == 0){
			return "just now";
		} else {
			return $saniye .' second ago';
		}
	} else if ( $dakika < 60 ){
		return $dakika .' mins ago';
	} else if ( $saat < 24 ){
		return $saat.' hours ago';
	} else if ( $gun < 7 ){
		return $gun .' days ago';
	} else if ( $hafta < 4 ){
		return $hafta.' weeks ago';
	} else if ( $ay < 12 ){
		return $ay .' months ago';
	} else {
		return $yil.' years ago';
	}
}
?>