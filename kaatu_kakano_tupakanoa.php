<?php
namespace Whangaonokupu;
	
class Whangaonokupu {	
    const INGOA_RAURANGA = 'raraunga/7776_kupu.db';
	const NAAMA_TEITEI = 599;
	const KUPU = 7;
	const KUPU_KATOA = 7776;
	
    public static function tu_tepuehu( $kupu = self::KUPU ) {
		$_rarangi_kupu = static::whakaraukupu( self::INGOA_RAURANGA );
		$_kupu_muna = '';
		$r = '';
		for ( $i = 0; $i < $kupu; $i++ ) {
			$r = static::whangatekau();
			$tenei_kupu = $_rarangi_kupu[ $r ];
			if ( false === strpos( $_kupu_muna, $tenei_kupu ) ) {
				$_kupu_muna .= $tenei_kupu . ' ';
			} else {
				while( false !== strpos( $_kupu_muna, $tenei_kupu ) ) {
					$tenei_kupu = $_rarangi_kupu[ $r ];
					if ( false === strpos( $_kupu_muna, $tenei_kupu ) ) {
						$_kupu_muna .= $tenei_kupu . ' ';
						break;
					}
				}
			}
			$r = '';
		}
		$_kupu_muna = trim( $_kupu_muna );
		return $_kupu_muna;
    }
	public static function mokamoka( $kupu = self::KUPU, $kupu_katoa = self::KUPU_KATOA ) {
		return round( ( static::taupu_koari( pow( ( int ) $kupu_katoa, ( int ) $kupu ) / 2 ) ), 2 );
	}
    public function whangatekau() {
		$naama = '';
		# roll a pentagonal trapezohedron dice 5 times appending i.e. 03728 = wordlist 3728
		for ( $a = 0; $a < 5; $a++ ) {
			$tenei_naama = ( random_int( 1, ( self::NAAMA_TEITEI * 10 ) ) % 6 ); // <-dice
			if ( $tenei_naama > 0 ) {
				$naama .= $tenei_naama;
			} else {
				while( $tenei_naama == 0 ) {
					$tenei_naama = ( random_int( 1, ( self::NAAMA_TEITEI * 10 ) ) % 6 );
					if ( $tenei_naama > 0 ) {
						$naama .= $tenei_naama;
						break;
					}
				}
			}
		}
		# mod to total word list count
		return $naama;
    }
    public function taupu_koari( $x ){
        return ( log10( $x ) / log10( 2 ) ) + 1;
    }
    public function whakaraukupu( $path ) {
		$_rarangi_kupu = array();
		$_rarangi = '';
		$fp = fopen( $path, 'r' );
		while ( !feof( $fp ) ) {
			$_rarangi = fgets( $fp );
			$_rarangi = trim( $_rarangi );
			if ( false !== strpos( $_rarangi, ' ' ) ) {
			$_rarangi = explode( ' ',trim( $_rarangi ) );
			$_rarangi_kupu[ $_rarangi[ 0 ] ] = $_rarangi[ 1 ];
			} else $_rarangi_kupu[] = $_rarangi;
		
		}
		fclose( $fp );
		return $_rarangi_kupu;
    }
}
