<?php
// Niente accessi diretti
if(!isset($hash_pwd)) die('Accesso diretto non consentito!');

// E' stato inviato il form
if(isset($_POST['submitted'])){
    $url = $_POST['url'];
    $method = $_POST['method'];
    
    if($url == '' || $method == ''){
        // E' incompleto
        echo <<<_END
    <div class="alert alert-error">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Attenzione!</strong> Non hai compilato tutti i campi.
    </div>
_END;
        print_form();
    } else {
        // E' tutto compilato
        if(filter_var($url, FILTER_VALIDATE_URL) && $method >= 0){
            echo <<<_END
    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Tutto bene!</strong> Scaricamento completato.
    </div>
_END;
            // Tipo di conversione
            switch ($method) {
                case 0:
                    $command = "youtube-dl -o \"./download/%(title)s.%(ext)s\" -f webm ".$url; //WebM qualità media
                    break;
                case 1:
                    $command = "youtube-dl -o \"./download/%(title)s.%(ext)s\" -f 3gp ".$url; //3gp qualità minima
                    break;
                case 2:
                    $command = "youtube-dl -o \"./download/%(title)s.%(ext)s\" -f worst ".$url; //mp4 qualità bassa
                    break;
                case 3:
                    $command = "youtube-dl -o \"./download/%(title)s.%(ext)s\" -f best ".$url; //mp4 qualità alta
                    break;
                case 4:
                    $command = "youtube-dl -o \"./download/%(title)s.%(ext)s\" ".$url." --extract-audio --audio-format mp3"; //mp3 solo audio
                    break;
            }
            echo "<pre>";
            echo exec($command);
            echo "</pre>";
        } else {
            // Errore nell'url
            echo <<<_END
    <div class="alert alert-error">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Attenzione!</strong> Non hai inserito un indirizzo valido.
    </div>
_END;
            print_form();
        }
    }
} else {
    print_form();
}

function print_form(){
    echo <<<_END
<form method="post" action="index.php?mode=1" class="form-horizontal">
  <div class="control-group">
    <label class="control-label">Indirizzo:</label>
    <div class="controls">
      <input type="text" name="url" value="" />
          <span class="add-on">
            <i class="icon-play-circle">
            </i>
          </span>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label">Impostazioni:</label>
    <div class="controls">
        <select name="method" size="1">
            <option value="0">Video media qualità - WebM</option>
            <option value="1">Video bassa qualità - 3gp</option>
            <option value="2">Video bassa qualità - mp4</option>
            <option value="3">Video alta qualità - mp4</option>
            <option value="4">Solo audio - mp3</option>
        </select>
          <span class="add-on">
            <i class="icon-refresh">
            </i>
          </span>
    </div>
  </div>
<input type="hidden" name="submitted" value="yes" />
<div class="controls">
  <button type="submit" class="btn btn-large btn-primary">Inizia</button>
  <a class="btn btn-large" href="index.php?mode=1">Cancella</a>
</div>
</form>
_END;
}

/*
    $json = '{"upload_date": "20140402", "description": "Clan Wars are almost here. Prepare your defenses! Get Clash of Clans on the App Store or Google Play: http://supr.cl/ClanWars A free game for mobile play.", "extractor": "youtube", "height": 720, "_filename": "Clash of Clans Introduces - Clan Wars! (Coming Soon)-_-lO_1QCuoI.mp4", "like_count": 116107, "uploader": "Clash of Clans", "duration": 46, "format_id": "22", "player_url": null, "uploader_id": "OfficialClashOfClans", "subtitles": null, "stitle": "Clash of Clans Introduces: Clan Wars! (Coming Soon)", "view_count": 16986860, "playlist": null, "title": "Clash of Clans Introduces: Clan Wars! (Coming Soon)", "url": "https://r3---sn-b5gg-ca9e.googlevideo.com/videoplayback?sparams=id%2Cip%2Cipbits%2Citag%2Cratebypass%2Crequiressl%2Csource%2Cupn%2Cexpire&mv=m&key=yt5&itag=22&source=youtube&ms=au&fexp=917000%2C931956%2C938645%2C914088%2C916623%2C902545%2C937417%2C913434%2C936916%2C934022%2C936921%2C936923&mws=yes&ip=130.192.232.16&expire=1397071754&ratebypass=yes&ipbits=0&requiressl=yes&id=o-AJQMLfAxvG0b6HMHmE7vEvglMqenJtx7BE1-3hf8QIMB&sver=3&upn=K4gdTPH0LpU&mt=1397047122&signature=3443CC473C8757CB6DF5CF58561C2F7C46F18022.CF9273EF2D9E2471A13063F38892D8CA20225953", "extractor_key": "Youtube", "id": "_-lO_1QCuoI", "format": "22 - 1280x720", "annotations": null, "dislike_count": 5536, "width": 1280, "ext": "mp4", "playlist_index": null, "webpage_url": "https://www.youtube.com/watch?v=_-lO_1QCuoI", "formats": [{"format": "171 - audio only (DASH webm audio)", "url": "https://r3---sn-b5gg-ca9e.googlevideo.com/videoplayback?lmt=1396542918164527&sparams=clen%2Cdur%2Cgir%2Cid%2Cip%2Cipbits%2Citag%2Clmt%2Crequiressl%2Csource%2Cupn%2Cexpire&key=yt5&itag=171&source=youtube&ms=au&fexp=917000%2C931956%2C938645%2C914088%2C916623%2C902545%2C937417%2C913434%2C936916%2C934022%2C936921%2C936923&mws=yes&ip=130.192.232.16&mv=m&expire=1397071754&upn=THV2_sEc5s0&ipbits=0&dur=45.132&requiressl=yes&id=o-AJQMLfAxvG0b6HMHmE7vEvglMqenJtx7BE1-3hf8QIMB&sver=3&clen=683728&gir=yes&mt=1397047122&signature=F6286C50ACFD3FD9F4D384BFAA3D5B73F0CC9353.E0FFDF2BE1446D8806C53CFD9827DF5470CE066B&ratebypass=yes", "vcodec": "none", "format_note": "DASH webm audio", "abr": 48, "player_url": null, "ext": "webm", "preference": -50, "format_id": "171"}, {"format": "140 - audio only (DASH audio)", "url": "https://r3---sn-b5gg-ca9e.googlevideo.com/videoplayback?lmt=1396376420322808&sparams=clen%2Cdur%2Cgir%2Cid%2Cip%2Cipbits%2Citag%2Clmt%2Crequiressl%2Csource%2Cupn%2Cexpire&key=yt5&itag=140&source=youtube&ms=au&fexp=917000%2C931956%2C938645%2C914088%2C916623%2C902545%2C937417%2C913434%2C936916%2C934022%2C936921%2C936923&mws=yes&ip=130.192.232.16&mv=m&expire=1397071754&upn=THV2_sEc5s0&ipbits=0&dur=45.186&requiressl=yes&id=o-AJQMLfAxvG0b6HMHmE7vEvglMqenJtx7BE1-3hf8QIMB&sver=3&clen=718502&gir=yes&mt=1397047122&signature=2B4E023758793C2D5B3377AF132C7AA788016683.D033F0D22F0F21D5FBF011E23572E6B81A29DEC3&ratebypass=yes", "vcodec": "none", "format_note": "DASH audio", "abr": 128, "player_url": null, "ext": "m4a", "preference": -50, "format_id": "140"}, {"format": "160 - 192p (DASH video)", "url": "https://r3---sn-b5gg-ca9e.googlevideo.com/videoplayback?lmt=1396376413767209&sparams=clen%2Cdur%2Cgir%2Cid%2Cip%2Cipbits%2Citag%2Clmt%2Crequiressl%2Csource%2Cupn%2Cexpire&key=yt5&itag=160&source=youtube&ms=au&fexp=917000%2C931956%2C938645%2C914088%2C916623%2C902545%2C937417%2C913434%2C936916%2C934022%2C936921%2C936923&mws=yes&ip=130.192.232.16&mv=m&expire=1397071754&upn=THV2_sEc5s0&ipbits=0&dur=45.128&requiressl=yes&id=o-AJQMLfAxvG0b6HMHmE7vEvglMqenJtx7BE1-3hf8QIMB&sver=3&clen=617312&gir=yes&mt=1397047122&signature=104BCC1E828C59FC89EB38FF3E08C401A03CE5A0.0964C2338925919F2914EB0139058F14A6072860&ratebypass=yes", "format_note": "DASH video", "player_url": null, "ext": "mp4", "preference": -40, "format_id": "160", "height": 192, "resolution": "192p"}, {"format": "242 - 240p (DASH webm)", "url": "https://r3---sn-b5gg-ca9e.googlevideo.com/videoplayback?lmt=1396542941583493&sparams=clen%2Cdur%2Cgir%2Cid%2Cip%2Cipbits%2Citag%2Clmt%2Crequiressl%2Csource%2Cupn%2Cexpire&key=yt5&itag=242&source=youtube&ms=au&fexp=917000%2C931956%2C938645%2C914088%2C916623%2C902545%2C937417%2C913434%2C936916%2C934022%2C936921%2C936923&mws=yes&ip=130.192.232.16&mv=m&expire=1397071754&upn=THV2_sEc5s0&ipbits=0&dur=45.087&requiressl=yes&id=o-AJQMLfAxvG0b6HMHmE7vEvglMqenJtx7BE1-3hf8QIMB&sver=3&clen=1118017&gir=yes&mt=1397047122&signature=111EA7CB59FE1F8EFFD5168712F5A8646235B48D.080CEAC0B11106D8F9E71BDD412F57A4FB329AA7&ratebypass=yes", "format_note": "DASH webm", "player_url": null, "ext": "webm", "preference": -40, "format_id": "242", "height": 240, "resolution": "240p"}, {"format": "133 - 240p (DASH video)", "url": "https://r3---sn-b5gg-ca9e.googlevideo.com/videoplayback?lmt=1396376416929938&sparams=clen%2Cdur%2Cgir%2Cid%2Cip%2Cipbits%2Citag%2Clmt%2Crequiressl%2Csource%2Cupn%2Cexpire&key=yt5&itag=133&source=youtube&ms=au&fexp=917000%2C931956%2C938645%2C914088%2C916623%2C902545%2C937417%2C913434%2C936916%2C934022%2C936921%2C936923&mws=yes&ip=130.192.232.16&mv=m&expire=1397071754&upn=THV2_sEc5s0&ipbits=0&dur=45.128&requiressl=yes&id=o-AJQMLfAxvG0b6HMHmE7vEvglMqenJtx7BE1-3hf8QIMB&sver=3&clen=1385129&gir=yes&mt=1397047122&signature=5892543E0FCAD94D73492F544E9B464E98320D5A.F579B29C54522ED131D090552FE08B0782E15F80&ratebypass=yes", "format_note": "DASH video", "player_url": null, "ext": "mp4", "preference": -40, "format_id": "133", "height": 240, "resolution": "240p"}, {"format": "243 - 360p (DASH webm)", "url": "https://r3---sn-b5gg-ca9e.googlevideo.com/videoplayback?lmt=1396542987307431&sparams=clen%2Cdur%2Cgir%2Cid%2Cip%2Cipbits%2Citag%2Clmt%2Crequiressl%2Csource%2Cupn%2Cexpire&key=yt5&itag=243&source=youtube&ms=au&fexp=917000%2C931956%2C938645%2C914088%2C916623%2C902545%2C937417%2C913434%2C936916%2C934022%2C936921%2C936923&mws=yes&ip=130.192.232.16&mv=m&expire=1397071754&upn=THV2_sEc5s0&ipbits=0&dur=45.087&requiressl=yes&id=o-AJQMLfAxvG0b6HMHmE7vEvglMqenJtx7BE1-3hf8QIMB&sver=3&clen=2048113&gir=yes&mt=1397047122&signature=7DFEC844B743A861E0A6FDDB97CB9ADFA4B8D26A.6368C55381477C4E2A7CD8EDA2604C11762B1445&ratebypass=yes", "format_note": "DASH webm", "player_url": null, "ext": "webm", "preference": -40, "format_id": "243", "height": 360, "resolution": "360p"}, {"format": "134 - 360p (DASH video)", "url": "https://r3---sn-b5gg-ca9e.googlevideo.com/videoplayback?lmt=1396376415131616&sparams=clen%2Cdur%2Cgir%2Cid%2Cip%2Cipbits%2Citag%2Clmt%2Crequiressl%2Csource%2Cupn%2Cexpire&key=yt5&itag=134&source=youtube&ms=au&fexp=917000%2C931956%2C938645%2C914088%2C916623%2C902545%2C937417%2C913434%2C936916%2C934022%2C936921%2C936923&mws=yes&ip=130.192.232.16&mv=m&expire=1397071754&upn=THV2_sEc5s0&ipbits=0&dur=45.128&requiressl=yes&id=o-AJQMLfAxvG0b6HMHmE7vEvglMqenJtx7BE1-3hf8QIMB&sver=3&clen=3306083&gir=yes&mt=1397047122&signature=E78E141A5F3F62483F70AD4D6601C8BC786BC8E3.0D35DEDF4FFB5B99379AA8CA1BA4568C4E2EFEFC&ratebypass=yes", "format_note": "DASH video", "player_url": null, "ext": "mp4", "preference": -40, "format_id": "134", "height": 360, "resolution": "360p"}, {"format": "244 - 480p (DASH webm)", "url": "https://r3---sn-b5gg-ca9e.googlevideo.com/videoplayback?lmt=1396542993736823&sparams=clen%2Cdur%2Cgir%2Cid%2Cip%2Cipbits%2Citag%2Clmt%2Crequiressl%2Csource%2Cupn%2Cexpire&key=yt5&itag=244&source=youtube&ms=au&fexp=917000%2C931956%2C938645%2C914088%2C916623%2C902545%2C937417%2C913434%2C936916%2C934022%2C936921%2C936923&mws=yes&ip=130.192.232.16&mv=m&expire=1397071754&upn=THV2_sEc5s0&ipbits=0&dur=45.087&requiressl=yes&id=o-AJQMLfAxvG0b6HMHmE7vEvglMqenJtx7BE1-3hf8QIMB&sver=3&clen=3824728&gir=yes&mt=1397047122&signature=32A78F5AAAA012EE5EF16A863EA5369CEE29663A.8106B82EE1CEBAD89CCF69E55DDAD4BBEE33D4C7&ratebypass=yes", "format_note": "DASH webm", "player_url": null, "ext": "webm", "preference": -40, "format_id": "244", "height": 480, "resolution": "480p"}, {"format": "135 - 480p (DASH video)", "url": "https://r3---sn-b5gg-ca9e.googlevideo.com/videoplayback?lmt=1396376414529236&sparams=clen%2Cdur%2Cgir%2Cid%2Cip%2Cipbits%2Citag%2Clmt%2Crequiressl%2Csource%2Cupn%2Cexpire&key=yt5&itag=135&source=youtube&ms=au&fexp=917000%2C931956%2C938645%2C914088%2C916623%2C902545%2C937417%2C913434%2C936916%2C934022%2C936921%2C936923&mws=yes&ip=130.192.232.16&mv=m&expire=1397071754&upn=THV2_sEc5s0&ipbits=0&dur=45.128&requiressl=yes&id=o-AJQMLfAxvG0b6HMHmE7vEvglMqenJtx7BE1-3hf8QIMB&sver=3&clen=6094310&gir=yes&mt=1397047122&signature=55BC1A914C1118870A0F8882B83A1E0506509AC9.7E06ADA0274112EE95384C1014E2441DFB992142&ratebypass=yes", "format_note": "DASH video", "player_url": null, "ext": "mp4", "preference": -40, "format_id": "135", "height": 480, "resolution": "480p"}, {"format": "247 - 720p (DASH webm)", "url": "https://r3---sn-b5gg-ca9e.googlevideo.com/videoplayback?lmt=1396543087363792&sparams=clen%2Cdur%2Cgir%2Cid%2Cip%2Cipbits%2Citag%2Clmt%2Crequiressl%2Csource%2Cupn%2Cexpire&key=yt5&itag=247&source=youtube&ms=au&fexp=917000%2C931956%2C938645%2C914088%2C916623%2C902545%2C937417%2C913434%2C936916%2C934022%2C936921%2C936923&mws=yes&ip=130.192.232.16&mv=m&expire=1397071754&upn=THV2_sEc5s0&ipbits=0&dur=45.087&requiressl=yes&id=o-AJQMLfAxvG0b6HMHmE7vEvglMqenJtx7BE1-3hf8QIMB&sver=3&clen=7601394&gir=yes&mt=1397047122&signature=C9779249F6EBB6C456539B578A889C4C418EBDAC.306C246C4627BF39F4A03A6346CB441420FB9C16&ratebypass=yes", "format_note": "DASH webm", "player_url": null, "ext": "webm", "preference": -40, "format_id": "247", "height": 720, "resolution": "720p"}, {"format": "136 - 720p (DASH video)", "url": "https://r3---sn-b5gg-ca9e.googlevideo.com/videoplayback?lmt=1396376428443817&sparams=clen%2Cdur%2Cgir%2Cid%2Cip%2Cipbits%2Citag%2Clmt%2Crequiressl%2Csource%2Cupn%2Cexpire&key=yt5&itag=136&source=youtube&ms=au&fexp=917000%2C931956%2C938645%2C914088%2C916623%2C902545%2C937417%2C913434%2C936916%2C934022%2C936921%2C936923&mws=yes&ip=130.192.232.16&mv=m&expire=1397071754&upn=THV2_sEc5s0&ipbits=0&dur=45.128&requiressl=yes&id=o-AJQMLfAxvG0b6HMHmE7vEvglMqenJtx7BE1-3hf8QIMB&sver=3&clen=12130190&gir=yes&mt=1397047122&signature=B4D1E583048895AA83A3B5A39755A4966BDE1F41.D3D7601A7892A01E071B074E752E40CD0B788109&ratebypass=yes", "format_note": "DASH video", "player_url": null, "ext": "mp4", "preference": -40, "format_id": "136", "height": 720, "resolution": "720p"}, {"format": "248 - 1080p (DASH webm)", "url": "https://r3---sn-b5gg-ca9e.googlevideo.com/videoplayback?lmt=1396543107660460&sparams=clen%2Cdur%2Cgir%2Cid%2Cip%2Cipbits%2Citag%2Clmt%2Crequiressl%2Csource%2Cupn%2Cexpire&key=yt5&itag=248&source=youtube&ms=au&fexp=917000%2C931956%2C938645%2C914088%2C916623%2C902545%2C937417%2C913434%2C936916%2C934022%2C936921%2C936923&mws=yes&ip=130.192.232.16&mv=m&expire=1397071754&upn=THV2_sEc5s0&ipbits=0&dur=45.087&requiressl=yes&id=o-AJQMLfAxvG0b6HMHmE7vEvglMqenJtx7BE1-3hf8QIMB&sver=3&clen=14465151&gir=yes&mt=1397047122&signature=1F1F2F72066B9200B02B15D9F1762C73DB467560.0ED8ADD9D40138CD39C356E4E5D590F87C6EB06F&ratebypass=yes", "format_note": "DASH webm", "player_url": null, "ext": "webm", "preference": -40, "format_id": "248", "height": 1080, "resolution": "1080p"}, {"format": "137 - 1080p (DASH video)", "url": "https://r3---sn-b5gg-ca9e.googlevideo.com/videoplayback?lmt=1396376439856649&sparams=clen%2Cdur%2Cgir%2Cid%2Cip%2Cipbits%2Citag%2Clmt%2Crequiressl%2Csource%2Cupn%2Cexpire&key=yt5&itag=137&source=youtube&ms=au&fexp=917000%2C931956%2C938645%2C914088%2C916623%2C902545%2C937417%2C913434%2C936916%2C934022%2C936921%2C936923&mws=yes&ip=130.192.232.16&mv=m&expire=1397071754&upn=THV2_sEc5s0&ipbits=0&dur=45.128&requiressl=yes&id=o-AJQMLfAxvG0b6HMHmE7vEvglMqenJtx7BE1-3hf8QIMB&sver=3&clen=23212194&gir=yes&mt=1397047122&signature=AED862BDA1B60C6FD923CDD68ABB3478D878D1E6.064F0B74960129121276E4F24824767578480D9A&ratebypass=yes", "format_note": "DASH video", "player_url": null, "ext": "mp4", "preference": -40, "format_id": "137", "height": 1080, "resolution": "1080p"}, {"width": 176, "ext": "3gp", "format": "17 - 176x144", "url": "https://r3---sn-b5gg-ca9e.googlevideo.com/videoplayback?sparams=id%2Cip%2Cipbits%2Citag%2Crequiressl%2Csource%2Cupn%2Cexpire&mv=m&key=yt5&itag=17&ip=130.192.232.16&ms=au&fexp=917000%2C931956%2C938645%2C914088%2C916623%2C902545%2C937417%2C913434%2C936916%2C934022%2C936921%2C936923&mws=yes&source=youtube&expire=1397071754&upn=K4gdTPH0LpU&ipbits=0&requiressl=yes&id=o-AJQMLfAxvG0b6HMHmE7vEvglMqenJtx7BE1-3hf8QIMB&sver=3&mt=1397047122&signature=5919AE5676479EBB84520FBDF53FA53B96ED03CF.C2D2D46E6043AE5CDE6AA971D8A4816185D00308&ratebypass=yes", "format_id": "17", "height": 144, "player_url": null}, {"width": 320, "ext": "3gp", "format": "36 - 320x240", "url": "https://r3---sn-b5gg-ca9e.googlevideo.com/videoplayback?sparams=id%2Cip%2Cipbits%2Citag%2Crequiressl%2Csource%2Cupn%2Cexpire&mv=m&key=yt5&itag=36&ip=130.192.232.16&ms=au&fexp=917000%2C931956%2C938645%2C914088%2C916623%2C902545%2C937417%2C913434%2C936916%2C934022%2C936921%2C936923&mws=yes&source=youtube&expire=1397071754&upn=K4gdTPH0LpU&ipbits=0&requiressl=yes&id=o-AJQMLfAxvG0b6HMHmE7vEvglMqenJtx7BE1-3hf8QIMB&sver=3&mt=1397047122&signature=6B70943987C4A93A2209B321E26A039F3384F475.6FBA9CA730AE166A0CC9A611D1DA8EE478F479A2&ratebypass=yes", "format_id": "36", "height": 240, "player_url": null}, {"width": 400, "ext": "flv", "format": "5 - 400x240", "url": "https://r3---sn-b5gg-ca9e.googlevideo.com/videoplayback?sparams=id%2Cip%2Cipbits%2Citag%2Crequiressl%2Csource%2Cupn%2Cexpire&mv=m&key=yt5&itag=5&ip=130.192.232.16&ms=au&fexp=917000%2C931956%2C938645%2C914088%2C916623%2C902545%2C937417%2C913434%2C936916%2C934022%2C936921%2C936923&mws=yes&source=youtube&expire=1397071754&upn=K4gdTPH0LpU&ipbits=0&requiressl=yes&id=o-AJQMLfAxvG0b6HMHmE7vEvglMqenJtx7BE1-3hf8QIMB&sver=3&mt=1397047122&signature=4C10A0C0D8C651EB984B7C47B53E1236DEB3B197.87B4C6F7A6761E037D9A31E0579B4C7A93AD3E52&ratebypass=yes", "format_id": "5", "height": 240, "player_url": null}, {"width": 640, "ext": "webm", "format": "43 - 640x360", "url": "https://r3---sn-b5gg-ca9e.googlevideo.com/videoplayback?sparams=id%2Cip%2Cipbits%2Citag%2Cratebypass%2Crequiressl%2Csource%2Cupn%2Cexpire&mv=m&key=yt5&itag=43&source=youtube&ms=au&fexp=917000%2C931956%2C938645%2C914088%2C916623%2C902545%2C937417%2C913434%2C936916%2C934022%2C936921%2C936923&mws=yes&ip=130.192.232.16&expire=1397071754&ratebypass=yes&ipbits=0&requiressl=yes&id=o-AJQMLfAxvG0b6HMHmE7vEvglMqenJtx7BE1-3hf8QIMB&sver=3&upn=K4gdTPH0LpU&mt=1397047122&signature=6D325AC24ACB296EEE1E15C4D42FA795DBF14C5B.8465093E063143B9968A7127054E2C15ADFAFBD3", "format_id": "43", "height": 360, "player_url": null}, {"width": 640, "ext": "mp4", "format": "18 - 640x360", "url": "https://r3---sn-b5gg-ca9e.googlevideo.com/videoplayback?sparams=id%2Cip%2Cipbits%2Citag%2Cratebypass%2Crequiressl%2Csource%2Cupn%2Cexpire&mv=m&key=yt5&itag=18&source=youtube&ms=au&fexp=917000%2C931956%2C938645%2C914088%2C916623%2C902545%2C937417%2C913434%2C936916%2C934022%2C936921%2C936923&mws=yes&ip=130.192.232.16&expire=1397071754&ratebypass=yes&ipbits=0&requiressl=yes&id=o-AJQMLfAxvG0b6HMHmE7vEvglMqenJtx7BE1-3hf8QIMB&sver=3&upn=K4gdTPH0LpU&mt=1397047122&signature=5BC083C9D49B53650B9901472FD4D823DEA6C9E6.596D18FABF7E40D47F7AE60569E873C81C929EF2", "format_id": "18", "height": 360, "player_url": null}, {"width": 1280, "ext": "mp4", "format": "22 - 1280x720", "url": "https://r3---sn-b5gg-ca9e.googlevideo.com/videoplayback?sparams=id%2Cip%2Cipbits%2Citag%2Cratebypass%2Crequiressl%2Csource%2Cupn%2Cexpire&mv=m&key=yt5&itag=22&source=youtube&ms=au&fexp=917000%2C931956%2C938645%2C914088%2C916623%2C902545%2C937417%2C913434%2C936916%2C934022%2C936921%2C936923&mws=yes&ip=130.192.232.16&expire=1397071754&ratebypass=yes&ipbits=0&requiressl=yes&id=o-AJQMLfAxvG0b6HMHmE7vEvglMqenJtx7BE1-3hf8QIMB&sver=3&upn=K4gdTPH0LpU&mt=1397047122&signature=3443CC473C8757CB6DF5CF58561C2F7C46F18022.CF9273EF2D9E2471A13063F38892D8CA20225953", "format_id": "22", "height": 720, "player_url": null}], "fulltitle": "Clash of Clans Introduces: Clan Wars! (Coming Soon)", "age_limit": 0, "thumbnail": "https://i1.ytimg.com/vi/_-lO_1QCuoI/maxresdefault.jpg", "webpage_url_basename": "watch"}';
    $vett = json_decode($json, true);

    foreach ($vett["formats"] as $k) {
        echo $k["ext"];
        echo preg_replace("/.* -(.*)/", " - $1", $k["format"]);
        echo '<br />';
    }
*/

?>
