<?php
use Whangaonokupu\Whangaonokupu;
require_once( 'tuhimunatanga.php' );
$Tuhimunatanga = new Tuhimunatanga();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<base href="/tuhimunatanga/">
		<title><?php echo $Tuhimunatanga->taitara; ?></title>
		<link rel="stylesheet" href="kaahua.css?ver=<?php echo filemtime( 'kaahua.css' ); ?>">
		<script src='hootuhihawa.js?ver=<?php echo filemtime( 'hootuhihawa.js' ); ?>'></script>
	</head>
	<body>
		<header>
			<div class="takai">
				<h2> <a href="<?php echo Tuhimunatanga::PAPA_HONO; ?>"><?php echo $Tuhimunatanga->taitara; ?></a></h2>
			</div>
		</header>
		<div id="taapare_matua">
			<div id="rohe_potae">
			<div id="rohe_taniwha">
					<div class="takai">
											<H4>WHAKAATURANGA: Hanga he whakapiri hei haumaru papatono-taupangatanga.</H4>
											<ul>
												<li><a target = "_blank" href="https://www.wolframalpha.com/input/?i=log2(62%5E15)">Moka-89.31</a> te kahanga o te haatepe-waahitau tukutuku mo ia hanga-whakapiri</li>
												<li>E whakamunatia ana nga whakapiri ia te aratau <i><?php echo strtoupper( $Tuhimunatanga::tu_aratuka() ); ?></i></li>
												<li>Moka-<?php echo Whangaonokupu::mokamoka( $Tuhimunatanga->kupu_katoa );?> te kahanga of te whangaono kupu</li>
												<li>Kaua e wareware te waahitau tukutuku me te kupuhipa. Mena kua ngarongaro enei, e kore e taea te wetemuna te whakapiri.</li>
												<li>I taapirihia he taitapa tupurangi.</li>
											</ul>	
					<br />
								<p>
								<?php if ( 'POST' !== $_SERVER[ 'REQUEST_METHOD' ] && isset( $_GET[ 'i' ] ) && strlen( $_GET[ 'i' ] ) == Tuhimunatanga::HAATEPE_ROA && !isset( $_POST[ 'kupuhipatuarua' ] ) ) {
											$raraunga = new Raraunga();	
											$whakahaatepe_tukurua  = $raraunga->koruki( $Tuhimunatanga->whakahaatepe( Tuhimunatanga::MOMO_HAATEPE, $Tuhimunatanga->tenei_haatepe ) );
											$rarangi      = $raraunga->tiipako( "SELECT `rarangi_huna` FROM `nga_taaurunga` WHERE `haatepe`=" . $whakahaatepe_tukurua );
											if ( $rarangi !== false ) {
												if ( !empty( $rarangi ) ) {
													$aho_whakamunatia = wordwrap( $rarangi[ 0 ][ 'rarangi_huna' ], Tuhimunatanga::TAIKAI_KUPU, "\n", true );
												} else {
													$Tuhimunatanga->karere_hapa .= "E hee ana te waahitau tukutuku, ngarongaro tenei tuhinga raanei";
													$aho_whakamunatia = $Tuhimunatanga->karere_hapa;
												}
											}
								?>
								<textarea cols="102" style="width:780px;" name="haatepe" spellcheck="false" rows="20" id="waehere" style="font-size: 16px; Courier New, monospace"; autofocus><?php if ( isset( $aho_whakamunatia ) ) echo $aho_whakamunatia; ?></textarea>
								<form action="./?i=<?php echo $Tuhimunatanga->tenei_haatepe; ?>" name="ipupapatono" id="ipupapatono" method="post">
									<br /><b>Kupuhipa:</b><br />
									<textarea class="Kupuhipa" cols="102" style="width:780px;" spellcheck="false" name="kupuhipatuarua" rows="1" id="ipu_kupuhika" autofocus></textarea><button type="submit" value="Wetemuna">Wetemuna</button>
								</form>
								<?php } elseif ( 'POST' == $_SERVER[ 'REQUEST_METHOD' ] && isset( $_POST[ 'kupuhipatuarua' ] ) ) {
										$waehere_whakamunatia = $Tuhimunatanga->karere_wetemunahia;
										$waehere_whakamunatia = preg_replace( "/[\n]/i", "\x00", $waehere_whakamunatia );
										$huaanga_waehere_whakamunatia = explode( "\x00", $waehere_whakamunatia );
								?>
						<div id="rohe_waihere2">
							<div id="rohe_waihere">
								<div id="patena_waihere">
									<span class="huri_matau">
										<a href="<?php echo ( isset( $Tuhimunatanga->papahono_huri ) ? $Tuhimunatanga->papahono_huri . '#raraunga' : '' ); ?>" class="pateneiti">raraunga taketake</a>
									</span>
									<a href="<?php echo Tuhimunatanga::PAPA_HONO; ?>" class="pateneiti" style="margin:0">whakapiri hou</a>
								</div>
								<div id="selectable">
										<ol class="tuhinga">
										<?php
												foreach ( $huaanga_waehere_whakamunatia as $nama_rarangi => $rarangi )  {
												  $nama_rarangi = ( $nama_rarangi + 1 );
												  echo "<li class=\"li1\"><div class=\"de1\">" . $rarangi . "</div></li>\n";
												}
										?>
										</ol>
								</div>
							</div>
						</div>
						<br /><h4 id="raraunga">RARAUNGA TAKETAKE</h4><br />
						<div class="rohepotae_kupu" style="margin-bottom:0">
										<textarea class="puta_waihere" cols="120" style="width:100%;" spellcheck="false" name="haatepe" rows="50" id="waehere" autofocus><?php echo $Tuhimunatanga->karere_wetemunahia; ?></textarea>
										<br /><p align="center"><a href="<?php echo Tuhimunatanga::PAPA_HONO; ?>">Whakapiri Hou</a></p>
						</div>
					<?php } elseif ( 'POST' !== $_SERVER[ 'REQUEST_METHOD' ] && !isset( $_GET[ 'i' ] ) && strlen( $Tuhimunatanga->papahono_huri ) == 0 ) { ?>
									</p>
									<form action="./" name="ipupapatono" id="ipupapatono" method="post">
										<input name="kupuhipa" type="hidden" value="<?php echo $Tuhimunatanga->kupuhipa_aunoa; ?>">
										<p>
										<textarea cols="102" name="haatepe" spellcheck="false" rows="20" id="haatepe" style="font-size: 12px; font-family:verdana"; placeholder="Whakapiri ou tuhinga ki konei" autofocus></textarea>
										<br />
										<select style="width:780px"; name="paunga">
											<option value="" disabled selected>Waa Pau</option>
											<option value="0">Amuri paanui ka tuumata!</option>
											<option value="600">Tekau Miniti</option>
											<option value="3600">Kotahi Houra</option>
											<option value="86400">Kotahi Ra</option>
											<option value="604800">Kotahi Wiki</option>
											<option value="2635200">Kotahi Marama</option>
											<option value="31579200">Kotahi Tau</option>
											<option value="3157920000">Ko Te Mutunga Kore</option>
										</select><button type="submit" value="Auaha">Auaha</button>
										</p>
									</form>
					<?php } elseif ( isset( $_GET[ 'i' ] ) && strlen( $_GET[ 'i' ] ) <> Tuhimunatanga::HAATEPE_ROA ) {
							header( "Location: " . Tuhimunatanga::PAPA_HONO );
							exit( 'Kei te hee te waahitau tukutuku' );
					} elseif ( 'POST' == $_SERVER[ 'REQUEST_METHOD' ] ) { 
						if ( strlen( $Tuhimunatanga->papahono_huri ) > 0 ) { ?>
							<?php
								$raraunga = new Raraunga();	
								$rarangi      = $raraunga->tiipako( "SELECT `rarangi_huna` FROM `nga_taaurunga` WHERE `haatepe`=" . $Tuhimunatanga->haatepe_mutu );
								if ( $rarangi === false ) {
									die( "E hika! E pakaru ana te raraunga" );
								} else {
									$aho_whakamunatia = wordwrap( $rarangi[ 0 ][ 'rarangi_huna' ], Tuhimunatanga::TAIKAI_KUPU, "\n", true );
								}
							?>
							<textarea cols="102" style="width:780px;" name="haatepe" spellcheck="false" rows="20" id="waehere" style="font-size: 12px; Courier New, monospace"; autofocus><?php if ( isset( $aho_whakamunatia ) ) echo $aho_whakamunatia; ?></textarea>
							<p>Whakatūpato: Kaua e wareware koe te <i>Kiianga Taarehu</i> me te <i>Waahitau Tukutuku</i> ki te wetemuna i tenei whakapiri.<br /><br />
							<b>Kiianga Taarehu:</b><br />
							<textarea class="whangaonokupu" style="width:780px;" name="haatepe" spellcheck="false" id="kupuhipa" rows="1" autofocus><?php echo $Tuhimunatanga->kupuhipa_aunoa; ?></textarea>
							<button type="Submit" onclick="papatopenga()">Taaura</button></p>
							<div id="rarangi_kupu">
								<?php if ( isset( $Tuhimunatanga->rarangi_kupu ) ) { ?>
								He tumomo tauira o nga kupu whangaono (he taonganui mo te maumaharatanga):<br />
								<?php echo $Tuhimunatanga->rarangi_kupu;
								} ?>
								
							</div>
							<br />
							<p><b>Waahitau Tukutuku:</b><br /><a target=_"blank" href="<?php echo $Tuhimunatanga->papahono_huri; ?>"><?php echo $Tuhimunatanga->papahono_huri; ?></a></p>
					</p>
					<?php }
					}
					?>
					</div>
				</div>	
			</div>	
		</div>				
	</body>
</html>
