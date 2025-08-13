<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // **IMPORTANTE**: Defina aqui o e-mail para onde as mensagens serão enviadas
    $destinatario = "maximusgerhardtgomes2220@gmail.com";

    $nome = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $servico = strip_tags(trim($_POST["service"]));
    $mensagem = strip_tags(trim($_POST["message"]));

    if (empty($nome) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($mensagem)) {
        header("Location: index.html?status=erro_campos");
        exit;
    }

    // Monta o corpo do e-mail
    $assunto = "Nova Mensagem de Contato do Site - " . $nome;
    $corpo_email = "Você recebeu uma nova mensagem do formulário de contato do seu site.\n\n";
    $corpo_email .= "Nome: $nome\n";
    $corpo_email .= "E-mail: $email\n";
    $corpo_email .= "Serviço de Interesse: $servico\n\n";
    $corpo_email .= "Mensagem:\n$mensagem\n";

    $cabecalhos = "From: " . $nome . " <" . $email . ">\r\n";
    $cabecalhos .= "Reply-To: " . $email . "\r\n";
    $cabecalhos .= "X-Mailer: PHP/" . phpversion();

    if (mail($destinatario, $assunto, $corpo_email, $cabecalhos)) {
        // Redireciona para uma página de sucesso (crie este arquivo se não existir)
        header("Location: obrigado.html");
    } else {
        // Redireciona de volta com uma mensagem de erro
        header("Location: index.html?status=erro_envio");
    }

} else {
    echo "Acesso negado.";
}
?>
