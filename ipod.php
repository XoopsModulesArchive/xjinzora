<?php

require __DIR__ . '/settings.php';
require __DIR__ . '/system.php';

$link_url = 'index.php?ptype=tools&action=ipodsync';

/* Let's show them a table with the selections for sync */
?>
<form action="<?php echo $link_url . '&ptype=tools&ephPod=yes'; ?>" method="post">
    <table width="<?php echo $main_table_width; ?>%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td width="33%" class="jz_artist_table_td">
                <strong>Select the artists you would like the sync</strong><br>
                <select name="original_artists[]" size="20" multiple style="width:300px;" class="jz_select">
                    <?php
                    /* Ok, let's get all the artists and add them one by one */
                    $d = dir($mp3_dir);
                    $ctr = 0;
                    while ($genreDir = $d->read()) {
                        /* Let's check what we got back */

                        if ('.' == $genreDir || '..' == $genreDir) {
                            continue;
                        }

                        if ('dir' == filetype($mp3_dir . '/' . $genreDir)) {
                            $d2 = dir($mp3_dir . '/' . $genreDir);

                            while ($artistDir = $d2->read()) {
                                /* Let's check what we got back */

                                if ('.' == $artistDir || '..' == $artistDir) {
                                    continue;
                                }

                                if ('dir' == filetype($mp3_dir . '/' . $genreDir . '/' . $artistDir)) {
                                    $artistArray[$ctr] = $artistDir . '--' . $genreDir;

                                    $ctr += 1;
                                }
                            }
                        }
                    }
                    /* If they are already being synced let's not display them */
                    /* Now let's open the file for reading */
                    $filename = $web_root . $root_dir . $jinzora_temp_dir . '/' . $ephPod_file_name;
                    $handle = fopen($filename, 'rb');
                    $contents = fread($handle, filesize($filename));
                    fclose($handle);

                    /* Let's replace the slashes with --- for comparison */
                    $contents = str_replace('\\', '---', $contents);

                    /* Now let's build and array out of the file */
                    $originalSyncArray = explode("\n", $contents);

                    /* Let's sort the array */
                    sort($artistArray);
                    sort($originalSyncArray);

                    $ctr = 0;
                    while (count($artistArray) > $ctr) {
                        /* Now let's sort then loop through the array */

                        $ctr2 = 0;

                        while (count($originalSyncArray) > $ctr2) {
                            if ('' != $artistArray[$ctr] and '' != $originalSyncArray[$ctr2]) {
                                /* Now let's split apart the value for display */

                                $artDisplay = explode('--', $artistArray[$ctr]);

                                /* Now let's see if we have a match */

                                if ('' != mb_stristr($originalSyncArray[$ctr2], $artDisplay[0])) {
                                    $artistArray[$ctr] = '';
                                }
                            }

                            $ctr2 += 1;
                        }

                        $ctr += 1;
                    }

                    /* Now let's sort then loop through the array */
                    sort($artistArray);
                    $ctr = 0;
                    while (count($artistArray) > $ctr) {
                        /* Let's make sure it's not blank */

                        if ('' != $artistArray[$ctr]) {
                            /* Now let's split apart the value for display */

                            $artDisplay = explode('--', $artistArray[$ctr]);

                            echo '<option value="' . $ephPod_drive_letter . ':---' . $artDisplay[1] . '---' . $artDisplay[0] . '---*">' . $artDisplay[0] . '</option>';
                        }

                        $ctr += 1;
                    }
                    ?>
                </select>
                <?php
                /* Now let's get the size of all these artists */

                //$totalSize = getSize($web_root. "/". $mp3_dir);
                //echo $totalSize. "<br>";
                ?>
            </td>
            <td width="33%" align="center">
                <input type="submit" name="add_artists" value="Add ->">
                <br><br>
                <input type="submit" name="remove_artists" value="<- Remove">
                <br><br>
                <a href="<?php echo $playlist_dir . '/syncdirs.dat'; ?>">Download ephPod Sync File</a>
            </td>
            <td width="1%" align="center">&nbsp;</td>
            <td width="32%" class="jz_artist_table_td">
                <strong>Artists currently being synced</strong><br>
                <select name="synced_artists[]" size="20" multiple style="width:300px;" class="jz_select">
                    <?php
                    /* Now let's open the file for reading to populate our select box */
                    $filename = $web_root . $root_dir . $jinzora_temp_dir . '/' . $ephPod_file_name;
                    $handle = fopen($filename, 'rb');
                    $contents = fread($handle, filesize($filename));
                    fclose($handle);

                    /* Now let's replace the slashes with --- for display */
                    $contents = str_replace('\\', '---', $contents);

                    /* Now let's build and array out of the file */
                    $currentSyncArray = explode("\n", $contents);

                    /* Now let's display that array */
                    $ctr = 0;
                    $syncedSize = 0;
                    $ctr3 = 0;
                    while (count($currentSyncArray) > $ctr) {
                        $artDisplay = explode('---', $currentSyncArray[$ctr]);

                        /* Let's make sure there is data */

                        if ('' != $artDisplay[1]) {
                            echo '<option value="' . $ephPod_drive_letter . ':' . chr(92) . $artDisplay[1] . chr(92) . $artDisplay[2] . chr(92) . '*">' . $artDisplay[2] . '</option>';

                            //$sizeArray[$ctr3] = getSize($web_root. "/". $mp3_dir. "/". $artDisplay[1]. "/". $artDisplay[2]);

                            $ctr3 += 1;
                        }

                        $ctr += 1;
                    }
                    ?>
                </select>
            </td>
        </tr>
    </table>
</form>
<br>
<?php
?>	
