<?php
require 'vendor/autoload.php';
require_once 'models/LineJson.php';
require_once 'models/LinePost.php';
require_once 'managers/LineLocationMgr.php';

use \LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot\QuickReplyBuilder\QuickReplyMessageBuilder;
use \LINE\LINEBot\QuickReplyBuilder\ButtonBuilder\QuickReplyButtonBuilder;
use \LINE\LINEBot\TemplateActionBuilder\LocationTemplateActionBuilder;

$jsonMessage = '{"destination":"U52d37d1d9b625754fa7308ed6af263ef","events":[{"type":"message","message":{"type":"text","id":"14743579319820","text":"..."},"timestamp":1631597207787,"source":{"type":"user","userId":"U420aa8a5b3859615a73a08c3f9fa53e2"},"replyToken":"f223ae75bb764c22a14cc18f72fc1929","mode":"active"}]}';
$jsonMap = '{"destination":"U52d37d1d9b625754fa7308ed6af263ef","events":[{"type":"message","message":{"type":"location","id":"14743074306580","latitude":25.028028164750477,"longitude":121.5493593925288,"address":"106台灣台北市大安區敦化南路二段111號"},"timestamp":1631590614516,"source":{"type":"user","userId":"U420aa8a5b3859615a73a08c3f9fa53e2"},"replyToken":"5b7db4bb1a924978918706f76292c7a0","mode":"active"}]}';

$HttpRequestBody = file_get_contents('php://input');
file_put_contents('php://stderr', $HttpRequestBody);
$linePost = new LinePost($HttpRequestBody);
//設定Token 
$channelSecret =  '64f2e4b2431a448b2c872f5c58a201a9';
$channelAccessToken = 'b31d8B9iAriRU9gT2b2LHKapaDFZzWga3SmlmHCMRWUsl5OplYXV/78fKWM/qjkVGX7W/ReVne/1S+9Q9Vc2bBtZsI6td4pb6sqL8MQWCNzLQPI2dh2S5tjEBN4s6+QRkFTXjCqaNTNUZYZ6F0C2cwdB04t89/1O/w1cDnyilFU=';
// $message = $this->parserMess($HttpRequestBody);
$message = $linePost->getMessage();
// file_put_contents('php://stderr', $message['type']);
// exit;

$httpClient = new CurlHTTPClient($channelAccessToken);
$bot = new LINEBot($httpClient, ['channelSecret' => $channelSecret]);
if ($message['type'] == 'location') {
	$lineReplyMess = array(0 => array('text' => '500m內電梯大樓/華廈 共有108筆。買方熱門詢問 : ', 'typecode' => '電梯大樓/華廈', 'count' => 108, 'searchUrlLowPrice' => 'https://dev-member.rakuya.com.tw/login/auth-login?token=zu2QWY9dCESiLaflzHu5ZTM3MGI0MmUzZTBhMmE5MzJkNDQ0OWM4MTQxMTRhM2Y1NGQzNWU0MDg2OTM1YmFlMWUyYjQ0YmVhOTBhODA4YmKjFmr4lGl42Ov_SMVuvGN5QhEr6CNc8Z7lsk5uOhWBPmLon0h4WGv-tC2WK-HTlv--k34bWYBss6IEaY1ndZNyhxiEjHsN5EwOB3sS-WFEKzYJbHx_9xRmjrubT01X8Zm8I5SZizNJdM-0w86Rb2Kgdz_NL4uTvbM5_seDe-F1WqDXCbC9cStme_5BIZkArrZOtq7nSD3YCDW-QUfVE_k_eg_3VkBmesaxSUsj3uRs2zLTaHQNq8BOwyQ1sr0Q1CuAeVoioMoo5hdj2Rax0IbUCv8-W0qaBSFAfFaJ6JSfnHxO_kIWUihYKzNzuMzMaLPWtrr6m3gCSzILnRIyyS1B', 'searchUrlLowPriceText' => '< 1200萬 低總價', 'searchUrlAll' => 'https://dev-member.rakuya.com.tw/login/auth-login?token=v61yG2zK0KnU0GSnORDzsTNkNGY0NzllOTZjZGNmYjMyNjEzMDhlMjhhZDMzODFmZWUwMzg0NjA1YWI4NjFmNDZjMjEyMzhmYzYyOTM1Mjm5d8IfcbbXOKkD9eAMVm2lrD0xnVi6Ox8GosEYGLEdjQWNYKU7RkvkV6I6qFsmj_2tt4hsbuQfj1eZxyvhNlu2OxCv7ZMKUcqMKXoufrNGkyDeOtAou4bMb_nKwuvdgAbwnQcy5JGq3PDBk1shROa24CZcH_-QnEKse5F1VN1CgmrzvYl-_QKuiPZ-jBLdjyEGhwS2YFfT0lY5BLGwx0UjeTI_MUkj7Z2LWQhwAnEergHuDlOFNDnaFls9inVqQfkkKANFzJI-2pN6YR7_lwo5kgxcGnvUUyH8rNqwLLNSvt1QWuTo5_QBdg_j6h2s4AY=', 'searchUrlAllText' => '全部查看',), 1 => array('text' => '500m內公寓 共有46筆。買方熱門詢問 : ', 'typecode' => '公寓', 'count' => 46, 'searchUrlLowPrice' => 'https://dev-member.rakuya.com.tw/login/auth-login?token=PRWwfzxVxL4T2tAKtiO9lmQ4MTAyNTljMTM5YTk4MTgwZmRjZWVlNGFiNDUwODkyZmFlZTRiZDRmYjBiZDBiYzE0MmE5NGNlYTJlMDZiMGb7FT9mLaZaLOshY54-wwQpMau8x0G4vPKBXH-yMWTgytrxwXuROYeQuFOdEBlGAK8gJtLNA-IzqVYmdAfiJ-LmkLtaaJiJ7riXe_Zi7nNW_zM7aRlzEZBwr-ThdUcRe2060KStrb64vdF45URpWTvDT3tm_uSbGEVLm8ErgVKw_vl0smc7QxL-mMtFW9v_zlhoeZ5B3IlONcaOIalcBWeBZzhGSquqpwr0BkGAIUJh0DeruTXYSbkqWVJcNOEMc0DOpAeFluXwDzwvOtsFVEY-MeA5foBtjpYQ-Zj-jO3q4lkSoCGjfK5kYnebWM3Jg2w1VPXnFJEguzHSjVg7uFtF', 'searchUrlLowPriceText' => '< 1200萬 低總價', 'searchUrlAll' => 'https://dev-member.rakuya.com.tw/login/auth-login?token=zAniH4OYcWoFZK28fR5QRjA2ZDFhZjI5NmZiODZhODYzMWMyMDkwOThiYzdiYzVhNWUxNzg5YzM0OTE5MmQ0ZTYwNWM2OTM3MGFkZDdlOGUCu8I2fLL06msXxuQU-w_mmm3KffQM6Fflo0JZzx_3S4Q96TBaG3057-g14Vf2-Lvv8QCSA8f4N5j8uUYP-leZ6aaR2I8az1wr3De9T4Aox86tBzu-uuaQRsDdjh0DBgMBCCfsxcWVXk3RH5FL2c7IBk6oGxVFodB_DIwwatiGdKTVWL3dFwM5HcfIx3yz-wgOvtct5ktjnh2zF-BGrW-r1xUVUySA1ryXnFLSGSMP8uCh5uivYLgErpoeCY3Hs6CuuUq9Psyoi_CaO-I6KMeXudIn7eOGIFQaQ1Kucxcz2W70OohDZ4pAK_YPljW5Ems=', 'searchUrlAllText' => '全部查看',), 2 => array('text' => '500m內套房 共有4筆。買方熱門詢問 : ', 'typecode' => '套房', 'count' => 4, 'searchUrlLowPrice' => 'https://dev-member.rakuya.com.tw/login/auth-login?token=UK8XkGGgDS_g0bIqSzuC1DQxNTBhNGQ2NmRlODJhNDNmOTUwOWRiNzFiOTc4YzljODE2MjE1MzdkZjA5NTMwYTZkYjAxNWIxODhlMjJiODfPdvAufI16oiK7ndVXNIgmo-IzetY3sG2X-oPnLC_VzNzs4zGkstlb02PO1yiNv1T6vK55WLHw0Ka82O9UPWI4nv6iqfPbjinJXZI2taOT_wnT8rZmJDJ1nfeHECZzaDvPLW-IeAxIj36xcc3O9INhJVcXQOSoygCMz1hJgJvHS83_d85QEQUOtsQru849F11kQITSTUY0_cVDCdJeA8JIS-xr-Kwv1nFdTuF50o8Ahg2WMF9TlIo0dydktHGgsA8pKW07zk0_NeMOkZyHBZ17tE2lupcVgF1vrE6KyZtT-uocvWGcj_2gSkt6ftcwZWl_7U8hZHjsAnOWl8sR7qT5', 'searchUrlLowPriceText' => '< 1200萬 低總價', 'searchUrlAll' => 'https://dev-member.rakuya.com.tw/login/auth-login?token=wYA_wNFoliUAsCs1VguDlGU2NWU4YjAyZDI2YTkwN2I0NGNjNTg1N2QwMmEzMjM0M2E0MmJlNDZjN2YyZmY3N2JmMzE2NGQ3YWJkYWFjZGQhEZX_bhMsFHC9kCYobRi8-37KOYYbOtHg2xfMHCW5QE_bIIGTCRYcQgOyLnk4JNtnKSofDRmbkDai5w648nl75sck-XA2K4dCmmSiUMbm_eEDYXUVENM2GLOKbBFnlHEw7Z4PQh2wJfCCwxC0tdHV6-jfGFuUeOVcbCouljzeWTU29uH7qdjpW4gpe9d8tk0_gJgiyJXsnPXub7oIKIMasEoT5G3TL6UZwJ2vsMT_PzWqjJI1zG7B8Kev5TNB1BtyVhF4_oT5r0N6-Sql5Ai75kRytaBjqhNP41H8gXwjGMRdgk0MSMxb4xYnfJC9PzM=', 'searchUrlAllText' => '全部查看',), 3 => array('text' => '500m內透天厝 共有1筆。買方熱門詢問 : ', 'typecode' => '透天厝', 'count' => 1, 'searchUrlLowPrice' => 'https://dev-member.rakuya.com.tw/login/auth-login?token=cb0Kp6lhiioBcgNHixwV4Tk3YjkwODJhNjQxY2I3ZWFlZGExZjgyYTJhNGFjYjM5OTQ0MzNjODJlODE5ODBiZDMxY2EzNzQxYjgzZjI2MGJWjOmGS3wgbUtQLUHm-n7N_uo9IVIrXWQ6gxirdRvCKL0J_FO8EF5UugLxgtJPnK_YCCBtyXP0zE2TZ-VasfC5_F22CQNs_6cQ9t9LVaCenYjxMErK_quYsi7h7ZzfPUsuG85DdqQAisbxqoNEP1T0HTnNUZsW2ixtgEoQN5lc3BfT82umpmhpVK5NIw1L48rKCUv9ow636wCdeQKZxv2J4SNBZPr7OaC6h_F2jgBhX-SHCDDtolIrV179e9-C6m45s2U_-0Svi9JsbGTGD4tblaVHQxtTfuvG_fW0l0gLGKVSlhmVt6Q7IEKlUnZX9ac-hVgtMcKhtU2PKVZekG06', 'searchUrlLowPriceText' => '< 1200萬 低總價', 'searchUrlAll' => 'https://dev-member.rakuya.com.tw/login/auth-login?token=Q3k_Hnxa7paI_UAMp-37JWJmNjVjNTYyOTAzNzVkMWZhMTJjMzMwZGJhYzg1OTdjZDk3ZWNmNDgyNDk1YWI5OWEzNjVjZDc3OGI0MmFjZmIdzK8pixswLJJEeQTpElnsGA4VEMzVL53pW5nWy3LLNqpA81SJazVQ95x0_PsGWmLVJOiXh5RbgRGIm9C-s7gX1U_YNYU6tsb_QaV55wqMzUP_iScUFC3YIYIRDdm3NXeOJj4gI-xumL0d3EijOPBznNnEmxl6O2zwmJeJEP9VcqLrf7Rx9BBgn5Oh3urfcBY1zutHWSd372439tHTgZfGqYp6YpGgeXKXUgBLF9f1PzvLKPBMk1BHFmnbOEWhfrYG1c93-DCQNZbfv4uny-qDINEhjjNcHFR45RWmEOYYvH8DHDfmsvR6OPgjycXWzyg=', 'searchUrlAllText' => '全部查看',), 4 => array('text' => '500m內樓中樓 共有3筆。買方熱門詢問 : ', 'typecode' => '樓中樓', 'count' => 3, 'searchUrlLowPrice' => 'https://dev-member.rakuya.com.tw/login/auth-login?token=J8a0ys2SAzwPv7876C4DGTQ0NDk0ZTcxNjUyNjE0NDFhNDMwYWJkYzc4ZjAxNDU4OTI4NDkzZjUzMDgwMjc5MzFkNzg1NjBjM2Q2MGQxZTbb5-grSC13Ttz0Pz3P9UaYeVzfXqKqcbJ8vU0hXA7eErhswjt45wdp_oRYsGNSDCHKXDpdCXp67xnwxkb5xvzxWfYwdLOwjISYeB1xMZW-7HV7-c2VW80688LsFNS8EuO6kyNEHNxQCf2FFTP-Ach0f2TLfDOr0dTLEsqtbvCresikCLLLjQhgqnKVOXTKksdEAI3l2ekkgFuDB3s1fj33Zo38OGiJkw9c47hA2JZt-vxn2o0NR9jO6W1Npmx8fEiK3D8KkYGDtGM1T75EA-41UiL_YcToF7xi1fFIRD_49cV_1Qpqbv-dY71jdR55JzQsHHfixqaWZo3dzHsy6QdL', 'searchUrlLowPriceText' => '< 1200萬 低總價', 'searchUrlAll' => 'https://dev-member.rakuya.com.tw/login/auth-login?token=5ZgGwWnvoUmz4excM9y6BTdjOWUzMjkyOTAwYTg0ZGVkZGMxMzhiNjIzODZlMzZiMGQ4OGRhNjNmMDkzNDc1YmIzNDAwMmFmMzY0YmM1MTL6EbnUPBBvW142aRJK-vL_inR5QtJ1guaq-hGdu8OLOC4wVunmcnMU9j0KZbcch0QIJM-b8sCDK_4xIqPe4zZRsXrvKjpwcA09GDos0wx4hXzd4P6tcYUYjVSMJDd5e4-yuGTgnsRS3AUqR4a0j2njslkIFAquCEig6szM8wMTbMM2wB2nQnnJBSztDUu2HjjsIIZQpR7iMICXDdPiw0V6l1qzS21PCrFmAiHamj8JYyigsqLJxn0jAfBqG-BnvZaiPR3FwVKdYubwIc40igzn4AC1DPwctZpCs-GIOoGLPCcnbTahh7k045hwR19Ps5A=', 'searchUrlAllText' => '全部查看',), 5 => array('text' => '500m內別墅 共有1筆。買方熱門詢問 : ', 'typecode' => '別墅', 'count' => 1, 'searchUrlLowPrice' => 'https://dev-member.rakuya.com.tw/login/auth-login?token=J7iFp9OPRXVHbvXs1YT6vTczYTM1ZDRkY2Y5YzMyMzM0OTA1YTYzYzQ4NzE5MzEwNTYzZTljN2Y1MmQ1MTUzZjRhYWZhZTRjNWY4NmVmZDM9hQhSq6EIrNK18N96Qf259Xs3SPwDFApwypBzEx7qO31-xG5HL8NR_NjYYy-g7FLLKUYxZybcAgUrTealgdVZrpMp42kHN6eZN9tQeQebt9L1XY1lq-AM0_eJ0lx08E6TeegwSwgPG8NEAFcHqjLF3qDneAHaYjNWkYI6aN7FtVNoylmBB54wcu_PTjVB-fXOUCBvFB47n8D5IoCwOvtfN-IidVcdzdNI9cAIHtvjMt07JYQzioNCktW74eXvqZiJjVeAo6knJTvyyHXYk1QQh3eJo2Ku-O3bU6xE9cvSubIoR8kUcqyoOhWpQ5hgVBkEjA8k97ruYWfgJu9bBANG', 'searchUrlLowPriceText' => '< 1200萬 低總價', 'searchUrlAll' => 'https://dev-member.rakuya.com.tw/login/auth-login?token=7KOjc2ng45hzLeTx2SrZgmRiNjAzYWY1ODE4OWJlZWQ0YTFjZWFjMDVkYTk1NThhMzM0M2UwODY0MmFkODlkM2Y4NWM4Njc5MzAzNzg5MDQYPGLgh9oF9kKxa_Lg7OTEcTVnexeijFxvbrMeuCm0tiD7U37CZ96YB948XmkGTNC8oyQZDvQOe_X0EhcXmRMcsLv6j9aQRsyIeVpp38qwq_gY0ah3gTS3WZIx3pKmzwC3yvg0o2xBuwj7GD_8yFV7XQwT3M-Xi3eOazuJ_8maS9qPVt6sK7F4xOAgEHoogiPX-FGlg5pVKn58svzNKmnrwv45DZRIzhHgJ4fvyNhvcCF6wmuiU3j6E1HYOv7quY6N_iOPydTpzSHxBuR9bBb-MmZSNHovKbCjOoJEq-0_CGBZzG85mSBxJwjKWLB0Yik=', 'searchUrlAllText' => '全部查看',), 6 => array('text' => '500m內辦公大樓 共有24筆。買方熱門詢問 : ', 'typecode' => '辦公大樓', 'count' => 24, 'searchUrlLowPrice' => 'https://dev-member.rakuya.com.tw/login/auth-login?token=9ff0UeQijAoueMaEBiN6NDlkNDNjYzNjYzQ4YWU1MzdmN2VlNTZmMmU2MzNiOTk5OGY1OGY1YzMyYWY1MWJlYTNlNzlkODAxNGMxMDA4ZGbA1-K0fFNPiABIpehueEo0vMbN8US5VIIn-tqAEmIpPrnpd6iW4ZGyPm1RBO6xygj__O3hHd_xDNkYImN6HKVg1OMaqUB1mFa4xNLhuH1E2i4GVmhs2Dv0Y3qRiESuUkA3wNhi2STeDDy--xTV4WZKdwVnihpF8NDKwBDXO85Ws6GvPF7NjCnIBw8HFOZwJ7jF0zmKIeODVmuc6tPQDwHSHTn27lVEvTj9ZY-rFO9giu9Xh3bFQVZr4NS6qzAye0584BfuSGznmk9_1mBkouaGhKQjlEMqpQiRCLQ9zUUcuUv-tgkjwm7xPCQlbLr-lPsxh3fgY4y-232z0cLUbtBm', 'searchUrlLowPriceText' => '< 1200萬 低總價', 'searchUrlAll' => 'https://dev-member.rakuya.com.tw/login/auth-login?token=ec9HNcJMxtob3ewsGsDPYWVkZTZmMzAwZGI5YjU3MmJlN2MxMzFmMDRhMWYxMDVkODEyMjFmNmYyMTcwODBjYTE1NWFhOGQ4OWIwOWRkOGV-5bnqdcjOJHaykUQqEzpkX9viMPnvuIS1NSINc0nyfdX1xsfE7IMLDGIdiSDf65BisCd8zvWfHSXJAFAxOXqwGfizmCbNZFY454XCDJcrHUTCZY_Ki_Of-BmZni8mv_kT4AtnjK5m-E_P5avAGedgLmDypHvIJsZa2sh5XpmRxmTqPGyV8Zb5T34HOlRq730MPMOmfj9ZywP5d28EkZkHFt-9bSP37zdiUuxQft91OAloFifk1P9A7kdG1pymdshnMNTUnE-K5B1LUTN187KFW88XLRTO54J7v-YNi4rNh882eWI8A0-5GL4a_CzyLC4=', 'searchUrlAllText' => '全部查看',), 7 => array('text' => '500m內店面 共有53筆。買方熱門詢問 : ', 'typecode' => '店面', 'count' => 53, 'searchUrlLowPrice' => 'https://dev-member.rakuya.com.tw/login/auth-login?token=45h1JPzZgLcLzcZzqYb1LGViZGFmOTE2Mzg0OTEyYjZiZmUwYjI4OWYzMDdmYjFjODY5MDQzOTUyOTUxYTZhMmE4YzcyNjJmOTA4NTFiNDDPtBI1L6xZjizF_X3ZAb5R10MLCPyTxDxVk-Gop8B4cpK6OxwBM2O30EZBcWq7nXmbMYIdMfdm7MXuYEGXQyK4k67ly5mpaYxDec061gfdy-NZlY82k6C_QSTNMIILVtQGu-2Be6pukwjQBDttorrlbsT0tfWgJaEoDUtqIZhje72YXnGv3Ogrvdw83ceEVsuBV1Qr738JTueKVhFJ2pA4Ib3YUbs-1hTjIkAVGdcamC0wKL0tp38K7FwpwtY7WKEtDQQFKyeLjdD1HQ5IBXqK-Xs1tY_sxji93Cea87Ky3R7k3S9js0EcGYklN0MY_dS_k10lB4DIcT7caG9Fjcyk', 'searchUrlLowPriceText' => '< 1200萬 低總價', 'searchUrlAll' => 'https://dev-member.rakuya.com.tw/login/auth-login?token=lhrZE74bNg3Xm65SsfbUJzg5ZTMwMmI1M2RmYjM1ZTdlN2JkZGExNTA1YjY5MTQ0NjBjNGM0NGE2ZTJkZTEzZDQzMTI5MTFlMmZjZWFhOWGSBwh3Ql53SSPn51pBrZW9qhu1sMiykt4ZbF-j3xg1YOrasNKvAS3R3v-SjYx4mj-6rx4nveF8_s9XqaMrDqH1yKYzS6ehCB7vUI4-UZp_m_n0gp0smj_iN1OaM2TbWkRnsDsXbxIO8gsepn71-zAIsKU9jiFsqbqXX9FLPajHbZq_pMi_cViU1yUdMf4FXPdwgFexTb19aKZmtTSY8VtYOVa-Fuvj06_AmaQMqX9jVhqAmPotyYMQjLWvP1I0eI5BjjOL7pu5XaYS2V-1CseNybcVBvyL4HF07EjEauzCrbnVV08VC38AKbR47esq5Ds=', 'searchUrlAllText' => '全部查看',),);
	$CarouselColumn = [];
	foreach ($lineReplyMess as $key => $content) {
		$UriTemplate = [];
		if (!empty($content['searchUrlLowPrice'])) {
			$UriTemplate[] = new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder($content['searchUrlLowPriceText'], $content['searchUrlLowPrice'] . '&openExternalBrowser=1');
		}
		if (!empty($content['searchUrlAll'])) {
			// $UriTemplate[] = new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder($content['searchUrlAllText'], 'https://i.imgur.com/adKT5rY.jpg?openExternalBrowser=1');
			$UriTemplate[] = new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder($content['searchUrlAllText'], $content['searchUrlAll'] . '&openExternalBrowser=1');
		}
		$CarouselColumn[] = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder($content['typecode'], $content['text'], 'https://i.imgur.com/VKihAYW.jpg', $UriTemplate, '#FFFFFF');
	}
	$Carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder($CarouselColumn, 'rectangle', 'cover');
	$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder('CCC', $Carousel);
	$bot->replyMessage($linePost->getReplyToken(), $textMessageBuilder);
	exit;
}
// $lineReplyMess = array(0 => array('text' => '500m內電梯大樓/華廈 共有108筆。買方熱門詢問 : ', 'typecode' => '電梯大樓/華廈', 'count' => 108, 'searchUrlLowPrice' => 'https://dev-member.rakuya.com.tw/login/auth-login?token=zu2QWY9dCESiLaflzHu5ZTM3MGI0MmUzZTBhMmE5MzJkNDQ0OWM4MTQxMTRhM2Y1NGQzNWU0MDg2OTM1YmFlMWUyYjQ0YmVhOTBhODA4YmKjFmr4lGl42Ov_SMVuvGN5QhEr6CNc8Z7lsk5uOhWBPmLon0h4WGv-tC2WK-HTlv--k34bWYBss6IEaY1ndZNyhxiEjHsN5EwOB3sS-WFEKzYJbHx_9xRmjrubT01X8Zm8I5SZizNJdM-0w86Rb2Kgdz_NL4uTvbM5_seDe-F1WqDXCbC9cStme_5BIZkArrZOtq7nSD3YCDW-QUfVE_k_eg_3VkBmesaxSUsj3uRs2zLTaHQNq8BOwyQ1sr0Q1CuAeVoioMoo5hdj2Rax0IbUCv8-W0qaBSFAfFaJ6JSfnHxO_kIWUihYKzNzuMzMaLPWtrr6m3gCSzILnRIyyS1B', 'searchUrlLowPriceText' => '< 1200萬 低總價', 'searchUrlAll' => 'https://dev-member.rakuya.com.tw/login/auth-login?token=v61yG2zK0KnU0GSnORDzsTNkNGY0NzllOTZjZGNmYjMyNjEzMDhlMjhhZDMzODFmZWUwMzg0NjA1YWI4NjFmNDZjMjEyMzhmYzYyOTM1Mjm5d8IfcbbXOKkD9eAMVm2lrD0xnVi6Ox8GosEYGLEdjQWNYKU7RkvkV6I6qFsmj_2tt4hsbuQfj1eZxyvhNlu2OxCv7ZMKUcqMKXoufrNGkyDeOtAou4bMb_nKwuvdgAbwnQcy5JGq3PDBk1shROa24CZcH_-QnEKse5F1VN1CgmrzvYl-_QKuiPZ-jBLdjyEGhwS2YFfT0lY5BLGwx0UjeTI_MUkj7Z2LWQhwAnEergHuDlOFNDnaFls9inVqQfkkKANFzJI-2pN6YR7_lwo5kgxcGnvUUyH8rNqwLLNSvt1QWuTo5_QBdg_j6h2s4AY=', 'searchUrlAllText' => '全部查看',), 1 => array('text' => '500m內公寓 共有46筆。買方熱門詢問 : ', 'typecode' => '公寓', 'count' => 46, 'searchUrlLowPrice' => 'https://dev-member.rakuya.com.tw/login/auth-login?token=PRWwfzxVxL4T2tAKtiO9lmQ4MTAyNTljMTM5YTk4MTgwZmRjZWVlNGFiNDUwODkyZmFlZTRiZDRmYjBiZDBiYzE0MmE5NGNlYTJlMDZiMGb7FT9mLaZaLOshY54-wwQpMau8x0G4vPKBXH-yMWTgytrxwXuROYeQuFOdEBlGAK8gJtLNA-IzqVYmdAfiJ-LmkLtaaJiJ7riXe_Zi7nNW_zM7aRlzEZBwr-ThdUcRe2060KStrb64vdF45URpWTvDT3tm_uSbGEVLm8ErgVKw_vl0smc7QxL-mMtFW9v_zlhoeZ5B3IlONcaOIalcBWeBZzhGSquqpwr0BkGAIUJh0DeruTXYSbkqWVJcNOEMc0DOpAeFluXwDzwvOtsFVEY-MeA5foBtjpYQ-Zj-jO3q4lkSoCGjfK5kYnebWM3Jg2w1VPXnFJEguzHSjVg7uFtF', 'searchUrlLowPriceText' => '< 1200萬 低總價', 'searchUrlAll' => 'https://dev-member.rakuya.com.tw/login/auth-login?token=zAniH4OYcWoFZK28fR5QRjA2ZDFhZjI5NmZiODZhODYzMWMyMDkwOThiYzdiYzVhNWUxNzg5YzM0OTE5MmQ0ZTYwNWM2OTM3MGFkZDdlOGUCu8I2fLL06msXxuQU-w_mmm3KffQM6Fflo0JZzx_3S4Q96TBaG3057-g14Vf2-Lvv8QCSA8f4N5j8uUYP-leZ6aaR2I8az1wr3De9T4Aox86tBzu-uuaQRsDdjh0DBgMBCCfsxcWVXk3RH5FL2c7IBk6oGxVFodB_DIwwatiGdKTVWL3dFwM5HcfIx3yz-wgOvtct5ktjnh2zF-BGrW-r1xUVUySA1ryXnFLSGSMP8uCh5uivYLgErpoeCY3Hs6CuuUq9Psyoi_CaO-I6KMeXudIn7eOGIFQaQ1Kucxcz2W70OohDZ4pAK_YPljW5Ems=', 'searchUrlAllText' => '全部查看',), 2 => array('text' => '500m內套房 共有4筆。買方熱門詢問 : ', 'typecode' => '套房', 'count' => 4, 'searchUrlLowPrice' => 'https://dev-member.rakuya.com.tw/login/auth-login?token=UK8XkGGgDS_g0bIqSzuC1DQxNTBhNGQ2NmRlODJhNDNmOTUwOWRiNzFiOTc4YzljODE2MjE1MzdkZjA5NTMwYTZkYjAxNWIxODhlMjJiODfPdvAufI16oiK7ndVXNIgmo-IzetY3sG2X-oPnLC_VzNzs4zGkstlb02PO1yiNv1T6vK55WLHw0Ka82O9UPWI4nv6iqfPbjinJXZI2taOT_wnT8rZmJDJ1nfeHECZzaDvPLW-IeAxIj36xcc3O9INhJVcXQOSoygCMz1hJgJvHS83_d85QEQUOtsQru849F11kQITSTUY0_cVDCdJeA8JIS-xr-Kwv1nFdTuF50o8Ahg2WMF9TlIo0dydktHGgsA8pKW07zk0_NeMOkZyHBZ17tE2lupcVgF1vrE6KyZtT-uocvWGcj_2gSkt6ftcwZWl_7U8hZHjsAnOWl8sR7qT5', 'searchUrlLowPriceText' => '< 1200萬 低總價', 'searchUrlAll' => 'https://dev-member.rakuya.com.tw/login/auth-login?token=wYA_wNFoliUAsCs1VguDlGU2NWU4YjAyZDI2YTkwN2I0NGNjNTg1N2QwMmEzMjM0M2E0MmJlNDZjN2YyZmY3N2JmMzE2NGQ3YWJkYWFjZGQhEZX_bhMsFHC9kCYobRi8-37KOYYbOtHg2xfMHCW5QE_bIIGTCRYcQgOyLnk4JNtnKSofDRmbkDai5w648nl75sck-XA2K4dCmmSiUMbm_eEDYXUVENM2GLOKbBFnlHEw7Z4PQh2wJfCCwxC0tdHV6-jfGFuUeOVcbCouljzeWTU29uH7qdjpW4gpe9d8tk0_gJgiyJXsnPXub7oIKIMasEoT5G3TL6UZwJ2vsMT_PzWqjJI1zG7B8Kev5TNB1BtyVhF4_oT5r0N6-Sql5Ai75kRytaBjqhNP41H8gXwjGMRdgk0MSMxb4xYnfJC9PzM=', 'searchUrlAllText' => '全部查看',), 3 => array('text' => '500m內透天厝 共有1筆。買方熱門詢問 : ', 'typecode' => '透天厝', 'count' => 1, 'searchUrlLowPrice' => 'https://dev-member.rakuya.com.tw/login/auth-login?token=cb0Kp6lhiioBcgNHixwV4Tk3YjkwODJhNjQxY2I3ZWFlZGExZjgyYTJhNGFjYjM5OTQ0MzNjODJlODE5ODBiZDMxY2EzNzQxYjgzZjI2MGJWjOmGS3wgbUtQLUHm-n7N_uo9IVIrXWQ6gxirdRvCKL0J_FO8EF5UugLxgtJPnK_YCCBtyXP0zE2TZ-VasfC5_F22CQNs_6cQ9t9LVaCenYjxMErK_quYsi7h7ZzfPUsuG85DdqQAisbxqoNEP1T0HTnNUZsW2ixtgEoQN5lc3BfT82umpmhpVK5NIw1L48rKCUv9ow636wCdeQKZxv2J4SNBZPr7OaC6h_F2jgBhX-SHCDDtolIrV179e9-C6m45s2U_-0Svi9JsbGTGD4tblaVHQxtTfuvG_fW0l0gLGKVSlhmVt6Q7IEKlUnZX9ac-hVgtMcKhtU2PKVZekG06', 'searchUrlLowPriceText' => '< 1200萬 低總價', 'searchUrlAll' => 'https://dev-member.rakuya.com.tw/login/auth-login?token=Q3k_Hnxa7paI_UAMp-37JWJmNjVjNTYyOTAzNzVkMWZhMTJjMzMwZGJhYzg1OTdjZDk3ZWNmNDgyNDk1YWI5OWEzNjVjZDc3OGI0MmFjZmIdzK8pixswLJJEeQTpElnsGA4VEMzVL53pW5nWy3LLNqpA81SJazVQ95x0_PsGWmLVJOiXh5RbgRGIm9C-s7gX1U_YNYU6tsb_QaV55wqMzUP_iScUFC3YIYIRDdm3NXeOJj4gI-xumL0d3EijOPBznNnEmxl6O2zwmJeJEP9VcqLrf7Rx9BBgn5Oh3urfcBY1zutHWSd372439tHTgZfGqYp6YpGgeXKXUgBLF9f1PzvLKPBMk1BHFmnbOEWhfrYG1c93-DCQNZbfv4uny-qDINEhjjNcHFR45RWmEOYYvH8DHDfmsvR6OPgjycXWzyg=', 'searchUrlAllText' => '全部查看',), 4 => array('text' => '500m內樓中樓 共有3筆。買方熱門詢問 : ', 'typecode' => '樓中樓', 'count' => 3, 'searchUrlLowPrice' => 'https://dev-member.rakuya.com.tw/login/auth-login?token=J8a0ys2SAzwPv7876C4DGTQ0NDk0ZTcxNjUyNjE0NDFhNDMwYWJkYzc4ZjAxNDU4OTI4NDkzZjUzMDgwMjc5MzFkNzg1NjBjM2Q2MGQxZTbb5-grSC13Ttz0Pz3P9UaYeVzfXqKqcbJ8vU0hXA7eErhswjt45wdp_oRYsGNSDCHKXDpdCXp67xnwxkb5xvzxWfYwdLOwjISYeB1xMZW-7HV7-c2VW80688LsFNS8EuO6kyNEHNxQCf2FFTP-Ach0f2TLfDOr0dTLEsqtbvCresikCLLLjQhgqnKVOXTKksdEAI3l2ekkgFuDB3s1fj33Zo38OGiJkw9c47hA2JZt-vxn2o0NR9jO6W1Npmx8fEiK3D8KkYGDtGM1T75EA-41UiL_YcToF7xi1fFIRD_49cV_1Qpqbv-dY71jdR55JzQsHHfixqaWZo3dzHsy6QdL', 'searchUrlLowPriceText' => '< 1200萬 低總價', 'searchUrlAll' => 'https://dev-member.rakuya.com.tw/login/auth-login?token=5ZgGwWnvoUmz4excM9y6BTdjOWUzMjkyOTAwYTg0ZGVkZGMxMzhiNjIzODZlMzZiMGQ4OGRhNjNmMDkzNDc1YmIzNDAwMmFmMzY0YmM1MTL6EbnUPBBvW142aRJK-vL_inR5QtJ1guaq-hGdu8OLOC4wVunmcnMU9j0KZbcch0QIJM-b8sCDK_4xIqPe4zZRsXrvKjpwcA09GDos0wx4hXzd4P6tcYUYjVSMJDd5e4-yuGTgnsRS3AUqR4a0j2njslkIFAquCEig6szM8wMTbMM2wB2nQnnJBSztDUu2HjjsIIZQpR7iMICXDdPiw0V6l1qzS21PCrFmAiHamj8JYyigsqLJxn0jAfBqG-BnvZaiPR3FwVKdYubwIc40igzn4AC1DPwctZpCs-GIOoGLPCcnbTahh7k045hwR19Ps5A=', 'searchUrlAllText' => '全部查看',), 5 => array('text' => '500m內別墅 共有1筆。買方熱門詢問 : ', 'typecode' => '別墅', 'count' => 1, 'searchUrlLowPrice' => 'https://dev-member.rakuya.com.tw/login/auth-login?token=J7iFp9OPRXVHbvXs1YT6vTczYTM1ZDRkY2Y5YzMyMzM0OTA1YTYzYzQ4NzE5MzEwNTYzZTljN2Y1MmQ1MTUzZjRhYWZhZTRjNWY4NmVmZDM9hQhSq6EIrNK18N96Qf259Xs3SPwDFApwypBzEx7qO31-xG5HL8NR_NjYYy-g7FLLKUYxZybcAgUrTealgdVZrpMp42kHN6eZN9tQeQebt9L1XY1lq-AM0_eJ0lx08E6TeegwSwgPG8NEAFcHqjLF3qDneAHaYjNWkYI6aN7FtVNoylmBB54wcu_PTjVB-fXOUCBvFB47n8D5IoCwOvtfN-IidVcdzdNI9cAIHtvjMt07JYQzioNCktW74eXvqZiJjVeAo6knJTvyyHXYk1QQh3eJo2Ku-O3bU6xE9cvSubIoR8kUcqyoOhWpQ5hgVBkEjA8k97ruYWfgJu9bBANG', 'searchUrlLowPriceText' => '< 1200萬 低總價', 'searchUrlAll' => 'https://dev-member.rakuya.com.tw/login/auth-login?token=7KOjc2ng45hzLeTx2SrZgmRiNjAzYWY1ODE4OWJlZWQ0YTFjZWFjMDVkYTk1NThhMzM0M2UwODY0MmFkODlkM2Y4NWM4Njc5MzAzNzg5MDQYPGLgh9oF9kKxa_Lg7OTEcTVnexeijFxvbrMeuCm0tiD7U37CZ96YB948XmkGTNC8oyQZDvQOe_X0EhcXmRMcsLv6j9aQRsyIeVpp38qwq_gY0ah3gTS3WZIx3pKmzwC3yvg0o2xBuwj7GD_8yFV7XQwT3M-Xi3eOazuJ_8maS9qPVt6sK7F4xOAgEHoogiPX-FGlg5pVKn58svzNKmnrwv45DZRIzhHgJ4fvyNhvcCF6wmuiU3j6E1HYOv7quY6N_iOPydTpzSHxBuR9bBb-MmZSNHovKbCjOoJEq-0_CGBZzG85mSBxJwjKWLB0Yik=', 'searchUrlAllText' => '全部查看',), 6 => array('text' => '500m內辦公大樓 共有24筆。買方熱門詢問 : ', 'typecode' => '辦公大樓', 'count' => 24, 'searchUrlLowPrice' => 'https://dev-member.rakuya.com.tw/login/auth-login?token=9ff0UeQijAoueMaEBiN6NDlkNDNjYzNjYzQ4YWU1MzdmN2VlNTZmMmU2MzNiOTk5OGY1OGY1YzMyYWY1MWJlYTNlNzlkODAxNGMxMDA4ZGbA1-K0fFNPiABIpehueEo0vMbN8US5VIIn-tqAEmIpPrnpd6iW4ZGyPm1RBO6xygj__O3hHd_xDNkYImN6HKVg1OMaqUB1mFa4xNLhuH1E2i4GVmhs2Dv0Y3qRiESuUkA3wNhi2STeDDy--xTV4WZKdwVnihpF8NDKwBDXO85Ws6GvPF7NjCnIBw8HFOZwJ7jF0zmKIeODVmuc6tPQDwHSHTn27lVEvTj9ZY-rFO9giu9Xh3bFQVZr4NS6qzAye0584BfuSGznmk9_1mBkouaGhKQjlEMqpQiRCLQ9zUUcuUv-tgkjwm7xPCQlbLr-lPsxh3fgY4y-232z0cLUbtBm', 'searchUrlLowPriceText' => '< 1200萬 低總價', 'searchUrlAll' => 'https://dev-member.rakuya.com.tw/login/auth-login?token=ec9HNcJMxtob3ewsGsDPYWVkZTZmMzAwZGI5YjU3MmJlN2MxMzFmMDRhMWYxMDVkODEyMjFmNmYyMTcwODBjYTE1NWFhOGQ4OWIwOWRkOGV-5bnqdcjOJHaykUQqEzpkX9viMPnvuIS1NSINc0nyfdX1xsfE7IMLDGIdiSDf65BisCd8zvWfHSXJAFAxOXqwGfizmCbNZFY454XCDJcrHUTCZY_Ki_Of-BmZni8mv_kT4AtnjK5m-E_P5avAGedgLmDypHvIJsZa2sh5XpmRxmTqPGyV8Zb5T34HOlRq730MPMOmfj9ZywP5d28EkZkHFt-9bSP37zdiUuxQft91OAloFifk1P9A7kdG1pymdshnMNTUnE-K5B1LUTN187KFW88XLRTO54J7v-YNi4rNh882eWI8A0-5GL4a_CzyLC4=', 'searchUrlAllText' => '全部查看',), 7 => array('text' => '500m內店面 共有53筆。買方熱門詢問 : ', 'typecode' => '店面', 'count' => 53, 'searchUrlLowPrice' => 'https://dev-member.rakuya.com.tw/login/auth-login?token=45h1JPzZgLcLzcZzqYb1LGViZGFmOTE2Mzg0OTEyYjZiZmUwYjI4OWYzMDdmYjFjODY5MDQzOTUyOTUxYTZhMmE4YzcyNjJmOTA4NTFiNDDPtBI1L6xZjizF_X3ZAb5R10MLCPyTxDxVk-Gop8B4cpK6OxwBM2O30EZBcWq7nXmbMYIdMfdm7MXuYEGXQyK4k67ly5mpaYxDec061gfdy-NZlY82k6C_QSTNMIILVtQGu-2Be6pukwjQBDttorrlbsT0tfWgJaEoDUtqIZhje72YXnGv3Ogrvdw83ceEVsuBV1Qr738JTueKVhFJ2pA4Ib3YUbs-1hTjIkAVGdcamC0wKL0tp38K7FwpwtY7WKEtDQQFKyeLjdD1HQ5IBXqK-Xs1tY_sxji93Cea87Ky3R7k3S9js0EcGYklN0MY_dS_k10lB4DIcT7caG9Fjcyk', 'searchUrlLowPriceText' => '< 1200萬 低總價', 'searchUrlAll' => 'https://dev-member.rakuya.com.tw/login/auth-login?token=lhrZE74bNg3Xm65SsfbUJzg5ZTMwMmI1M2RmYjM1ZTdlN2JkZGExNTA1YjY5MTQ0NjBjNGM0NGE2ZTJkZTEzZDQzMTI5MTFlMmZjZWFhOWGSBwh3Ql53SSPn51pBrZW9qhu1sMiykt4ZbF-j3xg1YOrasNKvAS3R3v-SjYx4mj-6rx4nveF8_s9XqaMrDqH1yKYzS6ehCB7vUI4-UZp_m_n0gp0smj_iN1OaM2TbWkRnsDsXbxIO8gsepn71-zAIsKU9jiFsqbqXX9FLPajHbZq_pMi_cViU1yUdMf4FXPdwgFexTb19aKZmtTSY8VtYOVa-Fuvj06_AmaQMqX9jVhqAmPotyYMQjLWvP1I0eI5BjjOL7pu5XaYS2V-1CseNybcVBvyL4HF07EjEauzCrbnVV08VC38AKbR47esq5Ds=', 'searchUrlAllText' => '全部查看',),);
// $CarouselColumn = [];
// foreach ($lineReplyMess as $key => $content) {
// 	$UriTemplate = [];
// 	if (!empty($content['searchUrlLowPrice'])) {
// 		$UriTemplate[] = new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder($content['searchUrlLowPriceText'], $content['searchUrlLowPrice'] . '&openExternalBrowser=1');
// 	}
// 	if (!empty($content['searchUrlAll'])) {
// 		// $UriTemplate[] = new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder($content['searchUrlAllText'], 'https://i.imgur.com/adKT5rY.jpg?openExternalBrowser=1');
// 		$UriTemplate[] = new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder($content['searchUrlAllText'], $content['searchUrlAll'] . '&openExternalBrowser=1');
// 	}
// 	$CarouselColumn[] = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder($content['typecode'], $content['text'], 'https://i.imgur.com/VKihAYW.jpg', $UriTemplate, '#FFFFFF');
// }
// $Carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder($CarouselColumn, 'rectangle', 'cover');
// $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder('CCC', $Carousel);
// $bot->replyMessage($linePost->getReplyToken(), $textMessageBuilder);
// exit;

// $ButtonTemplate = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder(
// 	'公寓',
// 	'60筆60筆60筆60筆60筆60筆60筆60筆60筆60筆60筆60筆60筆60筆60筆60筆',
// 	'https://i.imgur.com/VKihAYW.jpg',
// 	[
// 		new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder('url', 'https://open.spotify.com/track/12095GlriCNhVCbJV30vKw?si=c8713d60fa4f4a4e'),
// 		new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder('url', 'https://open.spotify.com/track/12095GlriCNhVCbJV30vKw?si=c8713d60fa4f4a4e'),
// 	],
// 	'rectangle',
// 	'cover',
// 	'#FFFFFF'
// );
// $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder('alert', $ButtonTemplate);
// $bot->replyMessage($linePost->getReplyToken(), $textMessageBuilder);
// exit;

$QuickReplyMessageBuilder = new QuickReplyMessageBuilder([
	new QuickReplyButtonBuilder(new LocationTemplateActionBuilder('Location')),
	new QuickReplyButtonBuilder(new  \LINE\LINEBot\TemplateActionBuilder\CameraTemplateActionBuilder('Camera')),
	new QuickReplyButtonBuilder(new  \LINE\LINEBot\TemplateActionBuilder\CameraRollTemplateActionBuilder('Camera roll')),
]);
$messageInfo = $linePost->getMessage();
file_put_contents('php://stderr', json_encode($messageInfo));
if ($messageInfo['type'] == 'text') {
	$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($messageInfo['text'], $QuickReplyMessageBuilder);
	$bot->replyMessage($linePost->getReplyToken(), $textMessageBuilder);
}
if ($messageInfo['type'] == 'location') {
	$pushMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($HttpRequestBody . PHP_EOL . $messageInfo['latitude'] . ' ' . $messageInfo['longitude'] . PHP_EOL . $messageInfo['address'], $QuickReplyMessageBuilder);
	$bot->pushMessage($linePost->getUserId(), $pushMessageBuilder);
}
$LineJson = new LineJson();
$data = $LineJson->menu();
$richMenuBuilder = new \LINE\LINEBot\RichMenuBuilder($data['size'], $data['selected'], $data['name'], $data['chatBarText'], $data['areas']);
$response = $bot->createRichMenu($richMenuBuilder);
$status = $response->getHTTPStatus();
if ($status == 200) {
	$content = $response->getJSONDecodedBody();
	$richMenuId = $content['richMenuId'];
	$imagePath = __DIR__ . '/ellall.jpg';
	$contentType = 'image/jpeg';
	$imgResponse = $bot->uploadRichMenuImage($richMenuId, $imagePath, $contentType);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://api.line.me/v2/bot/user/all/richmenu/' . $richMenuId);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		'Content-Type: application/json',
		'Authorization: Bearer ' . $channelAccessToken
	]);
	$result = curl_exec($ch);
	curl_close($ch);
} else {
	error_log('fail');
}
exit;

$jsonMap = '{"destination":"U52d37d1d9b625754fa7308ed6af263ef","events":[{"type":"message","message":{"type":"location","id":"14743074306580","latitude":25.028028164750477,"longitude":121.5493593925288,"address":"106台灣台北市大安區敦化南路二段111號"},"timestamp":1631590614516,"source":{"type":"user","userId":"U420aa8a5b3859615a73a08c3f9fa53e2"},"replyToken":"5b7db4bb1a924978918706f76292c7a0","mode":"active"}]}';

function parserMess($jsonMapS)
{
	$requestBody  = json_decode($jsonMapS, true);
	if (!empty($requestBody)) {
		foreach ($requestBody['events'] as $content) {
			$eventsType = $content['type'];
			$replyToken = $content['replyToken'];
			$userId = $content['source']['userId'];
			$message = $content['message'];
		}
	}
	return $message;
}
