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
* Traduzido para o portugues por: Carlos T. L. Cherem cherem@interamerica.com.br
* www.interamerica.com.br || www.narguile.com.br || www.unixtotal.com.br || www.hpna.com.br
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

/* Let's define all the words here */
$word_genres = 'Escolha os Gêneros';
$word_genre = 'Gênero';
$word_search_results = 'Resultado da Busca';
$word_tools = 'Ferramentas';
$word_search = 'Busca:';
$word_artist = 'Artistas';
$word_album = 'Álbums';
$word_pleasechoose = 'Por favor, escolha...';
$word_play = 'Ouça';
$word_play_all_albums_from = 'Ouça todos os álbuns de:';
$word_randomize_all_albums_from = 'Ouça aleatóriamente todos os álbuns de:';
$word_play_album = 'Ouça o álbum';
$word_download_album = 'Baixe o álbum';
$word_id3_tag_tools = 'Ferramenta para a Guia ID3 MP3';
$word_update_id3v1 = 'Atualizar as guias ID3';
$word_update_id3v1_desc = 'Criar dinamicamente todas as guias ID3 a partir do Gênero/Artista/Álbum/Número da Faixa - Nome do Arquivo';
$word_strip_id3v1_desc = 'Retirar todas as guias ID3 de todos os arquivos';
$word_update_id3v2 = 'Atualizar as guias ID3';
$word_update_id3v2_desc = 'Criar dinamicamente todas as guias ID3 a partir do Gênero/Artista/Álbum/Número da Faixa - Nome do Arquivo';
$word_strip_id3v2_desc = 'Retirar todas as guias ID3 de todos os arquivos';
$word_strip_id3v1 = 'Retirar guias ID3';
$word_strip_id3v2 = 'Retirar guias ID3';
$word_directory_other_tools = 'Diretório | Ferramentas de Arquivo | Outras Ferramentas';
$word_upload_center = 'Centro de Envio';
$word_select_for_ipod = 'Selecione para sincronizar com o iPod';
$word_fix_file_case = 'Corrigir a estrutura de nome de arquivo';
$word_create_new_genre = 'Criar um novo Gênero';
$word_delete_genre = 'Apagar Gênero';
$word_upload_to_jinzora = 'Enviar músicas para Jinzora';
$word_ipod_select_desc = 'Permitir que os Artistas sejam selecionados para sincronizar com um iPod usando ephPod';
$word_fix_file_case_desc = 'Colocar todas as letras inicias como maiúsculas';
$word_create_new_genre_desc = 'Adicione um novo gênero no Jinzora';
$word_delete_genre_desc = 'Apague um gênero do Jinzora';
$word_add_to = 'Adicionar para:';
$word_delete = 'Apagar';
$word_download = 'Baixar';
$word_return_home = 'Voltar ao Início';
$word_more = 'Mais';
$word_play_random = 'Tocar Aleatóriamente';
$word_move_item = 'Mover item';
$word_login = 'Entrar';
$word_random_select = 'Gerar aleatóriamente:';
$word_logout = 'Sair';
$word_up_level = 'Nível superior';
$word_down_level = 'Nível Inferior';
$word_enter_setup = 'Entrar na Configuração';
$word_go_button = 'Ir';
$word_username = 'Nome de visitante:';
$word_password = 'Senha:';
$word_home = 'Início';
$word_language = 'Idioma:';
$word_theme = 'Thema:';
$word_secure_warning = "O Jinzora está seguro, execute o script 'sh secure.sh' no seu shell UNIX!";
$word_check_for_update = 'Verificar atualizações para o Jinzora';
$word_new_genre = 'Novo Gênero:';
$word_search_for_album_art = 'Buscar uma arte para o álbum';
$word_cancel = 'Cancelar';
$word_are_you_sure_delete = 'Você quer mesmo apagar:';
$word_playlist = 'LIsta de Reprodução';
$word_check_all = 'Marcar todos';
$word_check_none = 'Nenhum';
$word_selected = 'Selecionado';
$word_session_playlist = ' - Sessão de Lista de reprodução - ';
$word_new_playlist = ' - Nova lista de reprodução - ';
$word_send_tech_email = 'Envie informações técnicas ao suporte';
$word_auto_update = 'Atualizar Automaticamente';
$word_auto_update_beta = 'Atualizar automaticamente (distribuição em teste)';
$word_rewrite_files_from_id3 = 'Reescrever os nomes de arquivo a partir das informações de ID3';
$word_create_shoutcast_playlist = 'Criar uma lista de reprodução para o Shoutcast';
$word_hide_tracks = 'Esconder as Faixas';
$word_show_tracks = 'Exibir as Faixas';
$word_shoutcast_tools = 'Ferramentas para Shoutcast';
$word_start_shoutcast = 'Iniciar o servidor de Shoutcast';
$word_stop_shoutcast = 'Parar o servidor de Shoutcast';
$word_create_shoutcast_random_playlist = 'Tornar a lista de reprodução do Shoutcast Aleatória';
$word_fix_media_names = 'Corrigir os nomes dos arquivos';
$word_remember_me = 'Lembre-me';
$word_show_hidden = 'Mostre os ocultos';
$word_update_cache = 'Atualizar o Cache';
$word_search_missing_album_art = 'Buscar por artes de álbuns que estão faltando';
$word_define = 'Definir';
$word_define_uc = 'O Centro de Envio permite que os associados enviem arquivos para o Jinzora';
$word_define_id3_update = 'Esta ferramenta permite que os associadosi atualizem dinamicamente as guias ID3 em todos os arquivos MP3 usando a informação da estrutura de diretório<br><br>Por exemplo, em 3 diretórios:<br><br>Jazz/Miles Davis/Kind of Blue/01 - All Blues.mp3<br><br>...resultará...<br><br>Gênero: Jazz<br>Artista: Miles Davis<br>Álbum: Kind of Blue<br>Número da Faixa: 01<br>Nome da Faixa: All Blues<br><br>No caso de 2 diretórios o Gênero será ignorado';
$word_define_id3_strip = 'Esta ferramenta irá separar o Gênero, Artista, Álbum, Número da Faixa, Nome da Faixa a partir de uma guia ID3 MP3';
$word_define_create_genre = 'Isto permite que os associados criem uma guia ID3v1 de Gênero amigável';
$word_define_delete_genre = 'Isto permite que os associados apaguem um gênero inteiro e todos os arquivos abaixo dele,<br><br>SEJA MUITO CUIDADOSO!!!';
$word_define_ipod_sync = 'Isto permite que os associados selecionem Artistas a serem sincronizados com um player iPod MP3, usando o iphPod';
$word_define_check_updates = 'Isto permite que o Jinzora chame o início do servidor principal para saber se há alguma atualização ou não';
$word_define_send_tech_info = 'Isto gera um relatório que será enviado por e-mail para o supoirte técnico do Jinzora<br><br>Não use esta ferramenta a não ser que o suporte ersteja esperando um e-mail seu!';
$word_define_enter_setup = 'Isto reinicia o processo de configuração para tornar as configurações mais fáceis<br><br>NOTA: É necessário executar o arquivo configure.sh primeiro';
$word_define_start_shoutcast = 'Isto permite que o associado execute o servidor de Shoutcast, caso o shoutcasting esteja habilitado';
$word_define_stop_shoutcast = 'Isto permite que o associado pare o servidor Shoutcast, caso shoutcasting esteja habilitado';
$word_define_fix_media = 'Estas são algumas feramentas para ajudar a trabalhar com vários arquivos';
$word_define_update_cache = 'Isto atualiza as informações do Cache<br><br>Deverá ser executado sempre que houver alterações em arquivos e/ou diretórios<br><br>O Cache dos arquivos faz o Jinzora ficar muito mais rápido';
$word_define_search_for_art = 'Isto apresenta ao associado as imagens dos álbuns, álbum por álbum a partir de images.google.com<br><br>O associado pode escolher a imagem que mais lhe agrada, ou a imagem gerada automaticamente pelo sistema';
$word_define_rewrite_from_id3 = 'Esta ferramenta irá substituir todos os nomes de arquivos usando as informações das guias ID3 tag para o número e nome da faixa<br><br>NOTA: O primeiro valor separador da faixa - caso sejam vários - será convertido num separador para os outros nomes de arquivos';
$word_change_art = 'Alterar a arte';
$word_survey = 'Pesquisa Jinzora';
$word_define_survey = 'Apenas uma pesquisa simples que nos ajuda a saber como o Jinzora está sendo usado para torná-lo ainda melhor!';
$word_user_manager = 'Gerência de visitantes';
$word_define_user_manager = 'Permite a você definir diferentes permissões por associados';
$word_add_user = 'Adicionar associados';
$word_access_level = 'Nível de Acesso';
$word_update_successful = 'Atualizado com Sucesso!';
$word_send_playlist = 'Enviar lista de reprodução';

$word_rate = 'Classifique esta faixa';
