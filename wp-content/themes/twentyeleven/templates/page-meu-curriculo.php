<?php
/**
  Template Name: P&aacute;gina Fixa - Meu Curriculo
 * */
get_header();

/*
 * VARIAVEIS GLOBAIS
 */
$DirTemplate    = get_template_directory() . '/';
$PathTemplate   = get_bloginfo('template_directory') . '/';


/*
 * Verificar se o camarada esta logado
 * Caso nao esteja logado, imprime o form de login pra ele
 */
if ( !is_user_logged_in() ) {
    include_once $DirTemplate . 'templates/include-form.php';
 } else {

// Usuario Logado
// Pagina de cadastro - Dados Pessoais

include_once $DirTemplate . 'templates/formCandidato.php';



/*echo ',,' . is_user_logged_in();

global $current_user;
// retorna os dados do usuário logado
$current_user = wp_get_current_user();
// passamos o ID do usuário e geramos o array
$user_info = get_userdata($current_user->ID);
// Criamos uma variavel com os dados que desejamos
// Aqui a lista completa dos dados que podemos puxar
// WordPress http://codex.wordpress.org/Author_Templates#Using_Author_Information
$first_name = $user_info->first_name;
$user_email = $user_info->user_email;
// mostra na tela
echo "Meu nome é: " . $first_name . " e meu e-mail é: " . $user_email;

echo '<pre>';
print_r($user_info);
echo '</pre>';*/
 }
?>

<?php get_footer(); ?>
