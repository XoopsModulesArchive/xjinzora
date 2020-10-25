<?php

// Let's set the image directory
$image_dir = "$root_dir/style/$jinzora_skin";
// Let's clean up the variables
$albumDispName = str_replace("'", '', $album);
$genreDispName = str_replace("'", '', $genre);
$artistDispName = str_replace("'", '', $artist);

// Now we need to include the menu library
require_once __DIR__ . '/menu.lib.php';

// Now we need to do a fix on all the words to remove the ' from them (if they had them)
$word_tools = str_replace("'", '', $word_tools);
$word_update_cache = str_replace("'", '', $word_update_cache);
$word_upload_center = str_replace("'", '', $word_upload_center);
$word_update_id3v1 = str_replace("'", '', $word_update_id3v1);
$word_user_manager = str_replace("'", '', $word_user_manager);
$word_search_for_album_art = str_replace("'", '', $word_search_for_album_art);
$word_enter_setup = str_replace("'", '', $word_enter_setup);
$word_check_for_update = str_replace("'", '', $word_check_for_update);
$word_add_fake_track = str_replace("'", '', $word_add_fake_track);
?>
<script language="JavaScript" type="text/javascript">
    var jzToolsMenu =
        [
            [null, '<?php echo $word_tools; ?>', null, null, '',
                <?php
                if (mb_stristr($_SESSION['prev_page'], '?')) {
                    $sep = '&';
                } else {
                    $sep = '?';
                }
                $this_url = $_SESSION['prev_page'] . $sep . 'editmenu=addmedia&info=' . jzstripslashes(urlencode($genre) . '/' . urlencode($artist) . '/' . urlencode($album));
                ?>
                ['<img src="<?php echo $image_dir; ?>/playlist.gif">', '<?php echo word_add_media; ?>', '<?php echo $this_url; ?>', null, ''],
                ['<img src="<?php echo $image_dir; ?>/playlist.gif">', '<?php echo $word_update_cache; ?>', '<?php echo $this_page . $url_seperator; ?>ptype=tools&action=updatecache', null, ''],
                ['<img src="<?php echo $image_dir; ?>/playlist.gif">', '<?php echo $word_update_id3v1; ?>', '<?php echo $this_page . $url_seperator; ?>ptype=tools&action=upid3', null, ''],
                ['<img src="<?php echo $image_dir; ?>/playlist.gif">', '<?php echo $word_user_manager; ?>', '<?php echo $this_page . $url_seperator; ?>ptype=tools&action=usermanager', null, ''],
                ['<img src="<?php echo $image_dir; ?>/playlist.gif">', '<?php echo $word_search_for_album_art; ?>', '<?php echo $this_page . $url_seperator; ?>ptype=tools&action=searchforart', null, ''],
                ['<img src="<?php echo $image_dir; ?>/playlist.gif">', '<?php echo $word_enter_setup; ?>', '<?php echo $this_page . $url_seperator; ?>ptype=tools&action=entersetup', null, ''],
                ['<img src="<?php echo $image_dir; ?>/playlist.gif">', '<?php echo $word_check_for_update; ?>', '<?php echo $this_page . $url_seperator; ?>ptype=tools&action=checkforupdates', null, ''],
            ],
        ];

</script>
<span id="myToolsMenu"></span>
<script language="JavaScript" type="text/javascript">
    cmDraw('myToolsMenu', jzToolsMenu, 'hbr', cmjz, 'jz');
</script>
