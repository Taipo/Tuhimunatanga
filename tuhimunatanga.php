<?php

use Whangaonokupu\Whangaonokupu;

include "kaatu_kakano_tupakanoa.php";
require_once( 'raraunga/raraunga.php' );

class Tuhimunatanga {
	
	const HAATEPE_ROA = 15;
	const MOMO_HAATEPE = 'sha3-512';
	const TAITAPA = 10000;
	const KUPU = 8;
	const TAIKAI_KUPU = 90;
	const PAPA_HONO = ''; // waahitau tukutuku o tou pae whakaata
	
	public $taitara = 'Whakaaturanga :: Hanga tetehi whakapiri hei haumaru papatono-taupangatanga'; 
	public $kupuhipa_aunoa, $karere_hapa, $haatepe_mutu, $tenei_haatepe, $karere_wetemunahia, $papahono_huri;
	
	function Tuhimunatanga() {
		date_default_timezone_set( 'NZ-CHAT' );
		$raraunga = new Raraunga();
		if ( 'POST' == $_SERVER[ 'REQUEST_METHOD' ] ) {
			if ( isset( $_POST[ 'haatepe' ] ) && isset( $_POST[ 'kupuhipa' ] ) && isset( $_POST[ 'paunga' ] ) && strlen( $_POST[ 'haatepe' ] ) > 3 ) {
				// Tekau ma rima te roa o te haatepe o te waahitau tukutuku
				$haatepe_papahono    = $this->mau_haatepe( static::HAATEPE_ROA, true );
				// Waru tekau ma ono te roa o te kupuhipa
				$this->kupuhipa_aunoa = $this->mau_haatepe( static::KUPU, true, true );
				// Mau te kiko
				$karerehuna_hou = $this->kore_rtk( $_POST[ 'haatepe' ], false );
				// Mau waahikee
				$this->waahikee = $this->kore_rtk( ( int ) $_POST[ 'paunga' ], true );
				// Mau te roa o taitapa
				$taitapa     = ( self::TAITAPA > strlen( $karerehuna_hou ) ) ? rand( 5, 1000) : 0;
				// Mo te waahitau tukutuku tenei
				$this->papahono_huri = self::PAPA_HONO . '?i=' . $haatepe_papahono;
				// E pai tonu ana, me whakamuna te waahitau tukutuku
				$rarangi_karerehuna    = $this->whakamuna( $karerehuna_hou, $this->kupuhipa_aunoa, $taitapa, $this->waahikee );
				// Whakahaatepe te haatepe
				$this->haatepe_mutu    = $raraunga->koruki( $this->whakahaatepe( static::MOMO_HAATEPE, $haatepe_papahono ) );
				// tapiri nga kouki
				$kupuhipa_huna_mutu = $raraunga->koruki( $rarangi_karerehuna );
				// whakapae korero raraunga
				$kupuhipa_aunoa_mutu_raraunga = $raraunga->koruki( $this->huna_whakamuna( $this->kupuhipa_aunoa ) );
				// tiakina ki te raraunga
				$huahua      = $raraunga->uiui( "INSERT INTO `nga_taaurunga` (`haatepe`,`kupuhipa_huna`,`rarangi_huna`) VALUES (" . $this->haatepe_mutu . "," . $kupuhipa_aunoa_mutu_raraunga . "," . $kupuhipa_huna_mutu . ")" );
				if ( $huahua === false ) $this->karere_hapa = "E hika! E pakaru ana te raraunga";
			} elseif ( isset( $_POST[ 'kupuhipatuarua' ] ) && strlen( $_POST[ 'kupuhipatuarua' ] ) > 0 ) {
			} else {
				header( "Location: " . $this->papahono_huri );
				exit();
			}
		}
		// get i
		if ( isset( $_GET[ 'i' ] ) ) {
			// mau haatepe
			$this->tenei_haatepe = $this->kore_rtk( $_GET[ 'i' ], true ); //Reo Tautohu Kuputuhiitua
			if ( strlen( $this->tenei_haatepe ) == static::HAATEPE_ROA ) {
				// Whakahaatepe te haatepe
				$whakahaatepe_tukurua   = $raraunga->koruki( $this->whakahaatepe( static::MOMO_HAATEPE, $this->tenei_haatepe ) );
				// Mau te waahitau tukutuku i te raraunga
				$rarangi = $raraunga->tiipako( "SELECT `kupuhipa_huna`,`rarangi_huna` FROM `nga_taaurunga` WHERE `haatepe`=" . $whakahaatepe_tukurua );
				if ( $rarangi === false ) {
					die( "E hika! E pakaru ana te raraunga" );
				} elseif ( !empty( $rarangi ) ) {
					$kupuhipa_huna = $rarangi[ 0 ][ 'kupuhipa_huna' ];
					$rarangi_huna = $rarangi[ 0 ][ 'rarangi_huna' ];
					$this->papahono_huri = self::PAPA_HONO . '?i=' . $this->tenei_haatepe;
					if ( false === empty( $rarangi_huna ) && isset( $_POST[ 'kupuhipatuarua' ] ) ) {
						$hanga_kupuhipa = $this->kore_rtk( $_POST[ 'kupuhipatuarua' ], true );
						if ( false !== $this->huna_manatoko( $hanga_kupuhipa, $kupuhipa_huna ) ) { 
							 $waitohuwaa_wehehia = self::haatepe_poto( $this->whakahaatepe( 'whirlpool', $hanga_kupuhipa, false ) );
							 $this->karere_wetemunahia = $this->wetemuna( $rarangi_huna,  $hanga_kupuhipa );
							 $mau_waitohuwaa = substr( $this->karere_wetemunahia, 0, 10 );
							 $waahikee =  trim( substr( $this->karere_wetemunahia, 10, strpos( $this->karere_wetemunahia, "\x00" ) - 10 ) );
							 $this->karere_wetemunahia = trim( str_replace( $mau_waitohuwaa . $waahikee, '', $this->karere_wetemunahia ) );
							 $this->mau_waa_tika( $mau_waitohuwaa, $waahikee, $whakahaatepe_tukurua );
						} else {
							$this->karere_hapa .= "E hika! E hee ana tou kupuhipa!";
							header( "Location: " . $this->papahono_huri );
							exit();
						}
					}
				}
			} else {
				header( "Location: " . self::PAPA_HONO );
				exit();				
			}
		} 
	}
	# Function List
	function mau_waa_tika( $mau_waitohuwaa, $waahikee, $whakahaatepe_tukurua ) {
		$raraunga 	= new Raraunga();
		$waa_kimua 	= ( intval( $mau_waitohuwaa ) + ( int ) $waahikee );
		if ( $waa_kimua <= time() ) {
			$huahua = $raraunga->uiui( "DELETE FROM `nga_taaurunga` WHERE `haatepe`=" . $whakahaatepe_tukurua );
			if ( $huahua === false ) $this->karere_hapa = "E hika! e pakarua ana te mukua o te rarangi raraunga ";
		}
	}
	function mau_rarangi_haatepe() {
		$raraunga = new Raraunga();
		$rarangi = $raraunga->tiipako( "SELECT `haatepe` FROM `nga_taaurunga`" );
		$rarangi_haatepe = array();
		if ( $rarangi === false ) {
			return; //e taa!
		} else {
			for( $x=0; $x<=count( $rarangi ); $x++ ) {
				if ( isset( $rarangi[ $x ][ 'haatepe' ] ) ) $rarangi_haatepe[ $x ] = $rarangi[ $x ][ 'haatepe' ];
			}
			return $rarangi_haatepe;
		}
	}
	function huna_whakamuna( $k_muna ) {
		if ( phpversion() >= 7.2 ) {
			if ( function_exists( 'sodium_crypto_pwhash_str' ) ) {
				return sodium_crypto_pwhash_str( $k_muna,
					SODIUM_CRYPTO_PWHASH_OPSLIMIT_SENSITIVE,
					SODIUM_CRYPTO_PWHASH_MEMLIMIT_SENSITIVE );	
			} else
				return password_hash(
				$k_muna,
				( ( phpversion() > 7.2 ) ? PASSWORD_ARGON2ID : PASSWORD_ARGON2I ),
				[
					'memory_cost' => 1<<19, // 512MB 
					'time_cost' => 5,
					'threads' => 3
				] );
		} else {
			return password_hash(
			$k_muna,
			PASSWORD_BCRYPT,
			[
				'cost' => 13,
			] );
		}
	}
	function huna_manatoko( $kii, $haatepe ) {
		if ( function_exists( 'sodium_crypto_pwhash_str_verify' ) ) {
			if ( sodium_crypto_pwhash_str_verify( $haatepe, $kii ) ) {
				return true;
			} else {
				return false;
			}
		}
		if ( password_verify( $kii, $haatepe ) ) {
			return true;
		} else {
			return false;
		}		
	}
	public static function tu_aratuka( $rahi_paraka = 256, $mode = 'cbc' ) {
		if ( phpversion() > 7.0 ) $mode = 'gcm';
		if ( phpversion() < 6 ) {
		  throw new Exception( 'Insecure version of PHP!' );
		}
		return 'aes-' . $rahi_paraka . '-' . $mode;
	}
	public static function mau_kii( $roa_a_haatepe = 32 ) {
	  for( $x=0; $x<=100; $x++ ) {
		$kii = openssl_random_pseudo_bytes( $roa_a_haatepe, $strong );
		if ( false !== $strong ) {
		  break;
		}
	  }
	  return $kii;
	}
	public static function mau_pa() { //pa = pere arawhititanga
		 return openssl_random_pseudo_bytes( openssl_cipher_iv_length( self::tu_aratuka() ) );
	}
	function whakamuna( $rarangi, $pepa, $taitapa = 0, $waahikee = 0, $a = null, $roa_a_tutohu = 128  ) {
		$momo_karerehuna    = self::tu_aratuka();
		$kii            = $pepa;
		$roa_a_kii      = mb_strlen( $kii, '8bit');
		$pa             = self::mau_pa(); // pere arawhiti
		if ( !is_null( $a ) && !empty( $a ) ) {
		  $a 		= hex2bin( $a );
		} else $a = null;
		
		# hanga inati tuuhaahaa
		$waitohuwaa_wehehia = self::haatepe_poto( $this->whakahaatepe( 'whirlpool', $pepa, false ) );
		$taitapa_whakawehe   = self::haatepe_poto( $this->whakahaatepe( static::MOMO_HAATEPE, $pepa, false ) );
		
		$waitohuwaa	= $waitohuwaa_wehehia . time() . $waahikee;
		$taitapa        = $taitapa_whakawehe . openssl_random_pseudo_bytes( $taitapa );
		$rarangi 	= $rarangi . $waitohuwaa . $taitapa;
		#self::taauru_whakapuaki( $rarangi, $kii, $roa_a_kii, $pa, $a, $roa_a_tutohu );
		$karerehuna_tunukore = ( false !== strpos( self::tu_aratuka(), 'gcm' ) ) ? trim( openssl_encrypt( $rarangi, $momo_karerehuna, $kii, OPENSSL_RAW_DATA, $pa, $tag, ( null === $a ? '' : $a ), $roa_a_tutohu / 8 ) ) : trim( openssl_encrypt( $rarangi . $waitohuwaa . $taitapa, $momo_karerehuna, $kii, OPENSSL_RAW_DATA, $pa ) );
		$awkm           = hash_hmac( 'tiger128,4', $karerehuna_tunukore, $kii, $hei_taahuurua = true ); // Ahuahaatepe Waihere Karere Motuheeheenga a-w-k-m
		$taaputa_gcm 	= base64_encode( $tag . $pa . $awkm . $karerehuna_tunukore );
		$taaputa 		= base64_encode( $pa . $awkm . $karerehuna_tunukore );
		$taaputa        = ( false !== strpos( self::tu_aratuka(), 'gcm' ) ) ? $taaputa_gcm : $taaputa;
		return $taaputa;		
	}
	public static function haatepe_poto( $haatepe ) {
		return substr( $haatepe, 0, 9 );
	}
	public function wetemuna( $karerehuna_puutahe64, $pepa, $a = null, $roa_a_tutohu = 128 ) {
		$momo_karerehuna     = self::tu_aratuka();
		$kii             = $pepa;
		$roa_a_kii       = mb_strlen( $kii, '8bit');
		$karerehuna_wete = base64_decode( $karerehuna_puutahe64 );
		$roa_a_pa        = openssl_cipher_iv_length( $karerehuna = $momo_karerehuna );
		$roa_a_tutohu 	 = $roa_a_tutohu / 8;
		if ( !is_null( $a ) && !empty( $a ) ) {
		  $a = hex2bin( $a );
		} else $a = null;
		$tag 		 = ( false !== strpos( self::tu_aratuka(), 'gcm' ) ) ? substr( $karerehuna_wete, 0, $roa_a_tutohu ) : '';
		$pa              = ( false !== strpos( self::tu_aratuka(), 'gcm' ) ) ? substr( $karerehuna_wete, $roa_a_tutohu, $roa_a_pa ) : substr( $karerehuna_wete, 0, $roa_a_pa );
		$awkm            = ( false !== strpos( self::tu_aratuka(), 'gcm' ) ) ? substr( $karerehuna_wete, $roa_a_tutohu + $roa_a_pa, $roa_a_awkm = 16 ) : substr( $karerehuna_wete, $roa_a_pa, $roa_a_awkm = 16 );
		$karerehuna_tunukore  = ( false !== strpos( self::tu_aratuka(), 'gcm' ) ) ? substr( $karerehuna_wete, $roa_a_tutohu + $roa_a_pa + $roa_a_awkm ) : substr( $karerehuna_wete, $roa_a_pa + $roa_a_awkm );
		#self::taauru_whakapuaki( $karerehuna_tunukore, $kii, $roa_a_kii, $pa, $a, ( $roa_a_tutohu * 8 ) );
		$taatai_awkm      = hash_hmac( 'tiger128,4', $karerehuna_tunukore, $kii, $hei_taahuurua = true ); // ko te huanga o tenei haatepe [tiger128,4], ko te tere, te pototanga me te maro
 
		if ( hash_equals( $awkm, $taatai_awkm ) ) { // inatonu te wetemuna, me whakataurite nga haatepe
		     $papa_kuputuhi    = ( false !== strpos( self::tu_aratuka(), 'gcm' ) ) ? trim( openssl_decrypt( $karerehuna_tunukore, $karerehuna, $kii, OPENSSL_RAW_DATA, $pa, $tag, ( null === $a ? '' : $a ) ) ) : trim( openssl_decrypt( $karerehuna_tunukore, $karerehuna, $kii, OPENSSL_RAW_DATA, $pa ) );
		     $waitohuwaa_wehehia = self::haatepe_poto( $this->whakahaatepe( 'whirlpool', $kii, false ) );
		     $taitapa_whakawehe = self::haatepe_poto( $this->whakahaatepe( static::MOMO_HAATEPE, $kii, false ) );		
		     $kuputuhi    = substr( $papa_kuputuhi, 0, strpos( $papa_kuputuhi, $waitohuwaa_wehehia ) );
		     $x 	  = strpos( $papa_kuputuhi, $waitohuwaa_wehehia );
		     $y 	  = strpos( $papa_kuputuhi, $taitapa_whakawehe );
		     $waitohuwaa  = trim( substr( $papa_kuputuhi, $x + 9, $y - ( $x + 9 ) ) );
		     $waitohuwaa  = preg_replace( "/[^0-9]/i", '', $waitohuwaa );
		     return $waitohuwaa . "\x00" . $kuputuhi;
		} else throw new Exception( 'Nga Tauwha Muhu: Kei te hee te rerenga whangaono' );
	}
	function mau_haatepe( $roa_a_haatepe = self::KUPU, $paanui_ia_tangata = false, $whangaono = false ) {
		mt_srand( $this->kakano_tupokanoa() );
		if ( false === $paanui_ia_tangata ) return self::mau_kii( $roa_a_haatepe ); // mahia ia openssl_random_pseudo_bytes()
		if ( false !== $whangaono ) return Whangaonokupu::tu_tepuehu( $roa_a_haatepe );
		$haatepe = '';
		$aho = array_merge( range( '0', '9' ), range( 'A', 'Z' ), range( 'a', 'z' ) );
		$t_char = count( $aho ) - 1;
		shuffle( $aho ); // Kaore e pai tenei taumaha mo te Tuhimunatanga
		for( $x = 0; $x < $roa_a_haatepe; $x++ ) {
			$rand_int = ( random_int( 0, ( $t_char * 10 ) ) % $t_char ); // Ko te kaha o tenei tuhimuna ko te random_int() tenei mo te teepu tirohia
			$haatepe = $haatepe . $aho[ $rand_int ];
			shuffle( $aho );
		}
		return $haatepe;
	}
	function kore_rtk( $taauru, $reta_tau = false, $waehere = 'UTF-8' ) {
		return ( ( false !== $reta_tau ) ? preg_replace( "/[^a-zA-Z0-9\/=\s]/i", '', $taauru ) : str_replace( '  ', '&nbsp; ', htmlspecialchars( $taauru ) ) );
	}
	# kaakano tupurangi
	function kakano_tupokanoa() {
		return abs( crc32( $this->whakahaatepe( static::MOMO_HAATEPE, ( hexdec( substr( microtime(), -8 ) ) & 0x7fffffff ), true ) ) );
	}
	function whakahaatepe( $momo_aho, $taauru, $whakatote = false ) {
		$momo_haatepe = $this->momo_aho( $momo_aho );
		if ( false !== $whakatote ) {
			$pepa = base64_encode( random_bytes( 64 ) );
		}
		return hash( $momo_haatepe, hash_pbkdf2( $momo_haatepe, $taauru, ( ( false !== $whakatote ) ? $pepa : NULL ), 24576, 48, true ) );
	}
	function momo_aho( $momo_aho ) {
		if ( is_int( $momo_aho ) ) {
			foreach ( hash_algos() as $kii => $uara ) {
				if ( $kii == $momo_aho ) {
					return $uara;
				}
			}
		} else {
			if ( in_array( $momo_aho, hash_algos() ) ) return $momo_aho;
		}
	}
	public static function taauru_whakapuaki( $rarangi, $kii, $roa_a_kii, $pa, $a, $roa_a_tutohu  ) {
		  Taapaetanga::korengia_aho_raanei( $rarangi, 'Me korengia aho-taahuurua raanei te kii whakamuna.' );
		  Taapaetanga::taahuurua( $kii, 'Me aho-taahuurua te kii whakamuna.' );
		  Taapaetanga::iro_huaanga( $roa_a_kii, [64, 86, 128, 192, 256], 'Kei te he te roaroa o te kii whakamuna.' );
		  Taapaetanga::aho( $pa, 'Me aho-taahuurua te pere arawhitinga.' );
		  Taapaetanga::korengia_taahuurua_raanei( $a, 'Me korengia aho-taahuurua raanei te raraunga motuheeheenga taapiripiri.' );
		  Taapaetanga::tau_toopuu( $roa_a_tutohu, 'Me tau toopuu te roaroa o te tuutohu.' );
		  Taapaetanga::iro_huaanga( $roa_a_tutohu, [128, 120, 112, 104, 96], 'He muhu te roaroa o te tuutohu. Ko nga uara tautokona ko: 128, 120, 112, 104 and 96.' );
	}	
}
