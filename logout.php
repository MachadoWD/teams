<?php
require_once __DIR__ . '/includes/funcoes.php';

// Encerra a sessão por completo
$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
}
session_destroy();

// Nova sessão apenas para exibir a mensagem de saída
session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax']);
session_start();
definir_flash('sucesso', 'Você saiu da sua conta com sucesso.');
redirecionar('index.php');
