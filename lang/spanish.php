<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* JINZORA | Web-based Media Streamer
*
* Jinzora is a Web-based media streamer, primarily desgined to stream MP3s
* (but can be used for any media file that can stream from HTTP).
* Jinzora can be integrated into a PostNuke site, run as a standalone application,
* or integrated into any PHP website.  It is released under the GNU GPL.
*
* Jinzora Author:
* Ross Carlson: ross@jasbone.com
* http://www.jinzora.org
* Documentation: http://www.jinzora.org/docs
* Support: http://www.jinzora.org/forum
* Downloads: http://www.jinzora.org/downloads
* License: GNU GPL <http://www.gnu.org/copyleft/gpl.html>
*
* Contributors:
* Please see http://www.jinzora.org/modules.php?op=modload&name=jz_whois&file=index
*
* Translation originally by :::martin::: - Thanks :::martin:::
*
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

/* Let's define all the words here */
$word_genres = 'Géneros';
$word_genre = 'Género';
$word_search_results = 'Resultados de la Búsqueda';
$word_tools = 'Herramientas';
$word_search = 'Buscar:';
$word_artist = 'Artistas';
$word_album = 'Albumes';
$word_pleasechoose = 'Por favor elija...';
$word_play = 'Reproducir';
$word_play_all_albums_from = 'Reproducir todos los álbumes de:';
$word_randomize_all_albums_from = 'Randomizar todos los álbumes de:';
$word_play_album = 'Reproducir álbum';
$word_download_album = 'Descargar álbum';
$word_id3_tag_tools = 'Herramientas de etiqueta de MP3 ID3';
$word_update_id3v1 = 'Actualizar etiquetas ID3';
$word_update_id3v1_desc = 'Crear dinámicamente todas las etiquetas ID3 de Género/Artista/Album/Número de track - Nombre de archivo';
$word_strip_id3v1_desc = 'Cortar todas las etiquetas ID3 tags de todos los archivos';
$word_update_id3v2 = 'Actualizar las etiquetas ID3';
$word_update_id3v2_desc = 'Crear dinámicamente todas las etiquetas ID3 de Género/Artista/Album/Número de track - Nombre de archivo';
$word_strip_id3v2_desc = 'Cortar todas las etiquetas ID3 tags de todos los archivos';
$word_strip_id3v1 = 'Cortar las etiquetas ID3';
$word_strip_id3v2 = 'Cortar las etiquetas ID3';
$word_directory_other_tools = 'Directorio | Otras Herramientas | Herramientas Varias';
$word_upload_center = 'Centro de Uploads';
$word_select_for_ipod = 'Seleccionar para sincronizar con iPod';
$word_fix_file_case = 'Corregir la escritura del nombre de archivo';
$word_create_new_genre = 'Crear nuevo género';
$word_delete_genre = 'Borrar género';
$word_upload_to_jinzora = 'Subir música a Jinzora';
$word_ipod_select_desc = 'Permitir a los artistas ser seleccionados para sincronizar con iPod utilizando ephPod';
$word_fix_file_case_desc = 'Cambiar todas las iniciales a Mayúscula';
$word_create_new_genre_desc = 'Agregar un nuevo género a Jinzora';
$word_delete_genre_desc = 'Borrar un género de Jinzora';
$word_add_to = 'Agregar a:';
$word_delete = 'Borrar';
$word_download = 'Descargar';
$word_return_home = 'Volver al inicio';
$word_more = 'Mas';
$word_play_random = 'Reproducir aleatoriamente';
$word_move_item = 'Mover item';
$word_login = 'Acceso';
$word_random_select = 'Generar aleatoriamente:';
$word_logout = 'Salida';
$word_up_level = 'Subir nivel';
$word_down_level = 'Bajar nivel';
$word_enter_setup = 'Ingresar configuración';
$word_go_button = 'Ir';
$word_username = 'Nombre de usuario:';
$word_password = 'Clave:';
$word_home = 'Inicio';
$word_language = 'Lenguaje:';
$word_theme = 'Tema:';
$word_secure_warning = "Jinzora no es seguro, por favor ejecute 'sh secure.sh' a nivel de shell!";
$word_check_for_update = 'Buscar actualizaciones de Jinzora';
$word_new_genre = 'Nuevo género:';
$word_search_for_album_art = 'Buscar el arte de';
$word_cancel = 'Cancelar';
$word_are_you_sure_delete = 'Está seguro que desea borrar:';
$word_playlist = 'Lista de reproducción';
$word_check_all = 'Chequear todos';
$word_check_none = 'Ninguno';
$word_selected = 'Seleccionado';
$word_session_playlist = ' - Sesion de lista de reproducción  - ';
$word_new_playlist = ' - Nueva lista de reproducción - ';
$word_send_tech_email = 'Enviar información técnica al soporte';
$word_auto_update = 'Actualización automática';
$word_auto_update_beta = 'Actualización automática (version beta)';
$word_rewrite_files_from_id3 = 'Rescribir los nombres de archivo en base a la información de ID3';
$word_create_shoutcast_playlist = 'Crear una lista de reproducción para Shoutcast';
$word_hide_tracks = 'Esconder tracks';
$word_show_tracks = 'Mostrar tracks';
$word_shoutcast_tools = 'Herramientas de Shoutcast';
$word_start_shoutcast = 'Iniciar el servidor Shoutcast';
$word_stop_shoutcast = 'Detener el servidor Shoutcast';
$word_create_shoutcast_random_playlist = 'Aleatorizar la lista de reproducción de Shoutcast';
$word_fix_media_names = 'Corregir los nombres de los archivos';
$word_remember_me = 'Recordar mis datos';
$word_show_hidden = 'Mostrar los ocultos';
$word_update_cache = 'Actualizar el cache';
$word_search_missing_album_art = 'Buscar el arte faltante';
$word_define = 'Definir';
$word_define_uc = 'El centro de uploads permite a los usuarios subir música a Jinzora';
$word_define_id3_update = 'Esta herramienta permite a los usuarios actualizar dinámicamente todas las etiquetas ID3 de todos los archivos MP3 usando la información de la estructura de carpetas<br><br>Por ejemplo en un modo de 3 directorios:<br><br>Jazz/Miles Davis/Kind of Blue/01 - All Blues.mp3<br><br>...se convierte en...<br><br>Género: Jazz<br>Artista: Miles Davis<br>Album: Kind of Blue<br>Número de Track: 01<br>Nombre de Track: All Blues<br><br>In en el modo de 2 directorios el campo de Género es ignorado';
$word_define_id3_strip = 'Esta herramienta eliminará los valores de los campos de Artista, Album, Número de Track, Nombre de Track de la etiqueta ID3 de un MP3';
$word_define_create_genre = 'Herramienta que permite al usuario crear una etiqueta ID3 fácilmente';
$word_define_delete_genre = 'Herramienta que permite al usuario borrar un género completo y TODOS sus archivos dependientes<br><br>POR FAVOR SEA CUIDADOSO!!!';
$word_define_ipod_sync = 'Herramienta que permite al usuario elegir Artistas para ser sincronizados con un iPod MP3 player, utilizando ephPod';
$word_define_check_updates = 'Herramienta que permite al usuario de Jinzora llamar al servidor para verificar si existe una nueva versión';
$word_define_send_tech_info = 'Herramienta que genera un reporte que es enviado por e-mail al soporte técnico de Jinzora<br><br>Por favor NO la utilice a menos que el soporte técnico esté esperando el e-mail!';
$word_define_enter_setup = 'Herramienta que recomienza el proceso de configuración para hacer el proceso más sencillo<br><br>NOTA: Por favor ejecute primero configure.sh !';
$word_define_start_shoutcast = 'Herramienta que permite al usuario iniciar el servidor Shoutcast, si shoutcasting está habilitado';
$word_define_stop_shoutcast = 'Herramienta que permite al usuario detener el servidor Shoutcast, si shoutcasting está habilitado';
$word_define_fix_media = 'Herramientas que ayudan en los procesos masivos con archivos';
$word_define_update_cache = 'Herramienta que actualiza la information de cache de la sesión actual<br><br>Esta herramienta debería ser ejecutada si los cambios a los archivos o a la estructura de directorios son hechos con actively browsing<br><br>Poniendo en cache los archivos de esta manera hace a Jinzora más rápido';
$word_define_search_for_art = 'Esta herramienta presenta al usuario imágenes de artes de álbum posibles, álbum por álbum via images.google.com<br><br>El usuario puede elegir el arte que quiera, o el generado por defecto por el sistema';
$word_define_rewrite_from_id3 = 'Esta herramienta re-escribe todos los nombres de archivo utilizando la información de las etiquetas ID3 extractando el número de track y el nombre de track<br><br>NOTA: El valor del separador del primer track - si es múltiple - se convertirá en el separador de tracks para los nuevos nombres de archivo';
$word_change_art = 'Cambiar el arte';
$word_survey = 'Encuesta de Jinzora';
$word_define_survey = 'Una encuesta simple para que podamos aprender más sobre cómo es utilizado Jinzora y así poder mejorarlo!';
$word_user_manager = 'Manager de usuarios';
$word_define_user_manager = 'Te permite configurar diferentes permisos para los usuarios';
$word_add_user = 'Agregar usuario';
$word_access_level = 'Nivel de acceso';
$word_update_successful = 'Actualización exitosa!';
$word_send_playlist = 'Enviar lista de reproducción';
