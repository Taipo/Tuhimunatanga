=== Tuhimunatanga ===

Tangata Haututu: @te_taipo

Herenga PHP: 7.0

Tenei Putanga: 1.0.0

Raihana: GPLv2 

Paewhakaata o te Raihana: http://www.gnu.org/licenses/gpl-2.0.html

He whakaaturanga o tetehi whakapiri hei haumaru papatono-taupangatanga

Mihi atu nei ki a Karaitiana Taiuru mo tona papakupu o nga kupu aa-kaupapa Maori, o te rorohiko me te paapaaho paapori:
https://www.taiuru.maori.nz/dictionary-computer-social-media/

== Whakaaturanga ==
* https://hokioisecurity.com/tuhimunatanga/

#### Ahuatanga O Tuhimunatanga

* He kore te paarongo tautuhituhi kei roto i te raraunga
* Mena kua wareware koe te te waahitau tukutuku, te kupuhipa ranei. Mena kua ngarongaro enei, e kore e taea te wetemuna te whakapiri.
* Mahia te aratau a AES-256-GCM
* Moka-102.4 te kahanga o te whakamunatia o nga kii kupuhipa
* Moka-89.31 te kahanga o te haatepe-waahitau tukutuku mo ia hanga-whakapiri
* Ka taea e koe ki te moonehu tou whakapiri

== Taautatanga  ==

1. Hanga tetehi raraunga

```mysql
CREATE TABLE `nga_taaurunga` (
  `haatepe` varchar(500) NOT NULL,
  `kupuhipa_huna` varchar(500) NOT NULL,
  `rarangi_huna` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```
2. Whakatakoto tou te paarongo o tou raraunga i roto i te whiringa_whakapiri.ini
```
[raraunga]
ingoa = 
kupuhipa = 
ingoa_raraunga = 
raraunga_waahitau_tukutuku = 
```

Ka mutu!
