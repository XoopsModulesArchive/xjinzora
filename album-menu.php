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
$word_play_all_albums_from = str_replace("'", '', $word_play_all_albums_from);
$word_randomize_all_albums_from = str_replace("'", '', $word_randomize_all_albums_from);
$word_check_all = str_replace("'", '', $word_check_all);
$word_check_none = str_replace("'", '', $word_check_none);
$word_play = str_replace("'", '', $word_play);
$word_selected = str_replace("'", '', $word_selected);
$word_delete = str_replace("'", '', $word_delete);
$word_session_playlist = str_replace("'", '', $word_session_playlist);
$word_new_playlist = str_replace("'", '', $word_new_playlist);
$word_new = str_replace("'", '', $word_new);
$word_media_management = str_replace("'", '', $word_media_management);
$word_actions = str_replace("'", '', $word_actions);
$word_search = str_replace("'", '', $word_search);
$word_rewrite_tags = str_replace("'", '', $word_rewrite_tags);
$word_download_album = str_replace("'", '', $word_download_album);
if (isset($word_group_features)) {
    $word_group_features = str_replace("'", '', $word_group_features);
}
if (isset($word_rate)) {
    $word_rate = str_replace("'", '', $word_rate);
}
$word_play_album = str_replace("'", '', $word_play_album);
$word_play_random = str_replace("'", '', $word_play_random);
$word_discuss = str_replace("'", '', $word_discuss);
$word_item_information = str_replace("'", '', $word_item_information);
$word_change_art = str_replace("'", '', $word_change_art);
$word_browse_album = str_replace("'", '', $word_browse_album);
if (isset($word_edit_album_info)) {
    $word_edit_album_info = str_replace("'", '', $word_edit_album_info);
}
$word_information = str_replace("'", '', $word_information);
$word_echocloud = str_replace("'", '', $word_echocloud);
$word_update_cache = str_replace("'", '', $word_update_cache);
$word_update_cache = str_replace("'", '', $word_update_cache);
if (isset($word_show_hidden)) {
    $word_show_hidden = str_replace("'", '', $word_show_hidden);
}
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
    var jzMenu =
        [
            [null, '<?php echo $word_actions; ?>', null, null, '',
                <?php
                // Let's see if they only wanted track plays
                if ('true' != $track_play_only) {
                    ?>
                ['<img src="<?php echo $image_dir; ?>/play.gif">', '<?php echo $word_play_album . ' <em>' . $albumDispName . '</em>'; ?>', '<?php echo $play_album_link; ?>', null, ''],
                <?php
                }
                ?>
                <?php
                if ('false' == $disable_random) {
                    ?>
                ['<img src="<?php echo $image_dir; ?>/random.gif">', '<?php echo $word_play_random . ' <em>' . $albumDispName . '</em>'; ?>', '<?php echo $play_album_rand_link; ?>', null, ''],
                <?php
                }
                ?>
                <?php
                // Let's see if they only wanted track plays
                if ('true' != $track_play_only) {
                    ?>
                <?php
                // Now we need to make sure they are NOT in 1 level mode
                if ('1' != $directory_level) {
                    ?>
                ['<img src="<?php echo $image_dir; ?>/play.gif">', '<?php echo $word_play_all_albums_from . ' <em>' . $artistDispName . '</em>'; ?>', '<?php echo $play_artist_link; ?>', null, ''],
                <?php
                } ?>
                <?php
                if ('false' == $disable_random) {
                    ?>
                ['<img src="<?php echo $image_dir; ?>/random.gif">', '<?php echo $word_randomize_all_albums_from . ' <em>' . $artistDispName . '</em>'; ?>', '<?php echo $play_artist_rand_link; ?>', null, ''],
                <?php
                } ?>
                <?php
                }
                ?>
                <?php
                if ('true' == $allow_download) {
                    // First let's get the size for this album

                    $album_size = '';

                    $d = dir($dirToLookIn);

                    $dirSize = 0;

                    while ($entry = $d->read()) {
                        // Let's make sure we are seeing real directories

                        if ('.' == $entry || '..' == $entry) {
                            continue;
                        }

                        $dirSize += filesize($dirToLookIn . '/' . $entry);
                    }

                    $album_size = round($dirSize / 1024000, 0) . ' MB';

                    // Now let's close the directory

                    $d->close();

                    // Now we have to change the URL if we are in CMS mode

                    if ('true' == $cms_mode) {
                        switch ($cms_type) {
                        case 'postnuke':
                            $link_begin = str_replace('index&', 'download&', $this_page);
                            break;
                        case 'mdpro':
                            $link_begin = str_replace('index&', 'download&', $this_page);
                            break;
                        case 'phpnuke':
                            $link_begin = 'modules/' . $_GET['name'] . '/download.php?';
                            break;
                        case 'cpgnuke':
                            $link_begin = 'modules/' . $_GET['name'] . '/download.php?';
                            break;
                        case 'nsnnuke':
                            $link_begin = 'modules/' . $_GET['name'] . '/download.php?';
                            break;
                        case 'mambo':
                            $link_begin = 'components/' . $_GET['option'] . '/download.php?';
                            break;
                    }
                    } else {
                        $link_begin = 'download.php?';
                    }

                    $dnl_url = $link_begin . 'info=' . urlencode($genre) . '/' . urlencode($artist) . '/' . urlencode($album); ?>
                ['<img src="<?php echo $image_dir; ?>/download.gif">', '<?php echo $word_download_album . ' <em>' . $albumDispName . ' (' . $album_size . ')</em>'; ?>', '<?php echo $dnl_url; ?>', null, ''],

                <?php
                }
                ?>
            ],
            _cmSplit,
            <?php
            if ('admin' == $_SESSION['jz_access_level']) {
                ?>
            [null, '<?php echo $word_media_management; ?>', null, null, '',
                <?php
                $art_url = $this_page . $url_seperator . 'ptype=artsearch&info=' . urlencode($genre) . '|||' . urlencode($artist) . '|||' . urlencode($album) . '&return=songs'; ?>
                ['<img src="<?php echo $image_dir; ?>/more.gif">', '<?php echo $word_change_art; ?>', '<?php echo $art_url; ?>', null, ''],
                <?php
                $this_url = $this_page . $url_seperator . 'ptype=updatetag&info=' . jzstripslashes(urlencode($genre) . '/' . urlencode($artist) . '/' . urlencode($album)) . '&return=' . urlencode($genre) . '|' . urlencode($artist) . '|' . urlencode($album); ?>
                ['<img src="<?php echo $image_dir; ?>/discuss.gif">', '<?php echo $word_rewrite_tags; ?>', '<?php echo $this_url; ?>', null, ''],
                <?php
                $this_url = $this_page . $url_seperator . 'ptype=songs&genre=' . urlencode($genre) . '&artist=' . urlencode($artist) . '&album=' . urlencode($album) . '&editmenu=album&info=' . urlencode($album); ?>
                ['<img src="<?php echo $image_dir; ?>/discuss.gif">', '<?php echo $word_item_information; ?>', '<?php echo $this_url; ?>', null, ''],
                <?php
                $this_url = $this_page . $url_seperator . 'ptype=songs&genre=' . urlencode($genre) . '&artist=' . urlencode($artist) . '&album=' . urlencode($album) . '&editmenu=bulkalbum&info=' . urlencode($album); ?>
                ['<img src="<?php echo $image_dir; ?>/discuss.gif">', '<?php echo $word_bulk_edit; ?>', '<?php echo $this_url; ?>', null, ''],
                <?php
                $this_url = $this_page . $url_seperator . 'ptype=songs&genre=' . urlencode($genre) . '&artist=' . urlencode($artist) . '&album=' . urlencode($album) . '&editmenu=addfake&info=' . urlencode($album); ?>
                ['<img src="<?php echo $image_dir; ?>/discuss.gif">', '<?php echo $word_add_fake_track; ?>', '<?php echo $this_url; ?>', null, ''],

            ],
            <?php
            }
            ?>

            <?php
            if ('true' == $amg_search or ('0' != $echocloud and '' != $echocloud)) {
                $artist_url = $this_page . $url_seperator . 'ptype=songs&genre=' . urlencode($genre) . '&artist=' . urlencode($artist) . '&album=' . urlencode($album) . '&search=amg&type=artists&info=' . urlencode($artist);

                $album_url = $this_page . $url_seperator . 'ptype=songs&genre=' . urlencode($genre) . '&artist=' . urlencode($artist) . '&album=' . urlencode($album) . '&search=amg&type=albums&info=' . urlencode($album); ?>
            ['', '<?php echo $word_information; ?>', null, null, '',
                ['<img src="<?php echo $image_dir; ?>/more.gif">', '<?php echo $word_search . ' AMG'; ?>', null, null, '',
                    ['<img src="<?php echo $image_dir; ?>/more.gif">', '<?php echo $albumDispName; ?>', '<?php echo $album_url; ?>', null, ''],
                    <?php
                    // Now we need to make sure they are NOT in 1 level mode
                    if ('' != $artistDispName) {
                        ?>
                    ['<img src="<?php echo $image_dir; ?>/more.gif">', '<?php echo $artistDispName; ?>', '<?php echo $artist_url; ?>', null, ''],
                    <?php
                    } ?>
                ],

                <?php
                // Now let's show the iTunes searching options
                $artist_url = $this_page . $url_seperator . 'ptype=songs&genre=' . urlencode($genre) . '&artist=' . urlencode($artist) . '&album=' . urlencode($album) . '&search=itunes&info=' . urlencode($artist);

                $album_url = $this_page . $url_seperator . 'ptype=songs&genre=' . urlencode($genre) . '&artist=' . urlencode($artist) . '&album=' . urlencode($album) . '&search=itunes&info=' . urlencode($album); ?>
                ['<img src="<?php echo $image_dir; ?>/more.gif">', '<?php echo $word_search . ' iTunes Music Store'; ?>', null, null, '',
                    ['<img src="<?php echo $image_dir; ?>/more.gif">', '<em><?php echo $albumDispName; ?></em>', '<?php echo $album_url; ?>', null, ''],
                    ['<img src="<?php echo $image_dir; ?>/more.gif">', '<em><?php echo $artistDispName; ?></em>', '<?php echo $artist_url; ?>', null, ''],
                ],

                <?php
            }
                if ('0' != $echocloud and '' != $echocloud and '1' != $directory_level) {
                    // Ok, now we need to search Echocloud to get matches to this artist

                    $ec_con = '';

                    $fp = fsockopen('www.echocloud.com', 80, $errno, $errstr, 5);

                    // Let's make sure that opened ok

                    if ($fp) {
                        $path = '/psearch.php?searchword=' . rawurlencode($artist) . '&nrows=' . ($echocloud + 1);

                        fwrite($fp, "GET $path HTTP/1.1\r\nHost:www.echocloud.com\r\n\r\n");

                        //fputs($fp, "Content-type: application/x-www-form-urlencoded\n");

                        fwrite($fp, "Connection: close\n\n");

                        // Now let's read all the data

                        $blnHeader = true;

                        while (!feof($fp)) {
                            if ($blnHeader) {
                                if ("\r\n" == fgets($fp, 1024)) {
                                    $blnHeader = false;
                                }
                            } else {
                                $ec_con .= fread($fp, 1024);
                            }
                        }

                        fclose($fp);

                        // Ok, now let's clean up what we got back

                        $ec_con = mb_substr($ec_con, 0, mb_strpos($ec_con, '</rs>'));

                        $ec_con = mb_substr($ec_con, mb_strpos($ec_con, '</date>') + 7, mb_strlen($ec_con));

                        // Now let's split it out by each item

                        $ecArray = explode('<r>', $ec_con);

                        if (count($ecArray) > 1) {
                            ?>
                ['<img src="<?php echo $image_dir; ?>/more.gif">', '<?php echo $word_echocloud; ?>', null, null, '',
                    <?php
                        }

                        for ($i = 0,$iMax = count($ecArray); $i < $iMax; $i++) {
                            if ('' != $ecArray[$i]) {
                                // Ok, now let's read the items

                                $ecArtist = mb_substr($ecArray[$i], 3, mb_strlen($ecArray[$i]));

                                $ecArtist = mb_substr($ecArtist, 0, mb_strpos($ecArtist, '<'));

                                $ecArtist = str_replace("'", '', $ecArtist);

                                $ecArray[$i] = mb_substr($ecArray[$i], mb_strpos($ecArray[$i], '<p>') + 3, mb_strlen($ecArray[$i]));

                                $ecPop = mb_substr($ecArray[$i], 0, mb_strpos($ecArray[$i], '</'));

                                $ecArray[$i] = mb_substr($ecArray[$i], mb_strpos($ecArray[$i], '<c>') + 3, mb_strlen($ecArray[$i]));

                                $ecCor = mb_substr($ecArray[$i], 0, mb_strpos($ecArray[$i], '</'));

                                $dnl_url = $this_page . $url_seperator . 'ptype=search&search=' . urlencode($ecArtist);

                                if ($ecArtist != $artist) {
                                    ?>
                    ['<img src="<?php echo $image_dir; ?>/more.gif">', '<em><?php echo $ecArtist; ?></em>', '<?php echo $dnl_url; ?>', null, ''],
                    <?php
                                }
                            }
                        }

                        if (count($ecArray) > 1) {
                            ?>
                ],
                <?php
                        }
                    }
                }
                ?>
            ],
        ];

</script>
<span id="myMenuID"></span>
<script language="JavaScript" type="text/javascript">
    cmDraw('myMenuID', jzMenu, 'hbr', cmjz, 'jz');
</script>
