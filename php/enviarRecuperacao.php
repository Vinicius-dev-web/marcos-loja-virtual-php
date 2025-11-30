<?php
require "conexao.php";
require "../PHPMailer/src/PHPMailer.php";
require "../PHPMailer/src/SMTP.php";
require "../PHPMailer/src/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST["email"];

    // Verificar se o e-mail existe
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) {
        die("E-mail não encontrado.");
    }

    $user = $res->fetch_assoc();

    // Criar token
    $token = bin2hex(random_bytes(32));
    $expira = date("Y-m-d H:i:s", time() + 3600); // 1 hora

    // Salvar token no banco
    $sql = "UPDATE usuarios SET reset_token = ?, reset_expira = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $token, $expira, $user["id"]);
    $stmt->execute();

    // 🔗 LINK CORRETO PARA SUA PASTA
    $link = "http://localhost/bolviershop/resetar.php?token=$token";

    // Enviar e-mail
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "bolviergames@gmail.com";
        $mail->Password = "mixa ohjf hcff osbi";  // SENHA CERTA
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom("bolviergames@gmail.com", "Suporte Bolvier");
        $mail->addAddress($email);
        $mail->Subject = "Esqueceu a senha?";
        $mail->isHTML(true);

        $mail->Body = "
            <h2>Recuperação de Senha</h2>
            <p>Clique no link abaixo para recuperar sua senha:</p>
            <a href='$link'>$link</a>
            <p>Este link expira em 1 hora.</p>
            <p>Conte com a gente. Time Bolvier, sempre contigo!</p>
        ";

        $mail->send();
        echo "E-mail enviado! Verifique sua caixa de entrada.";

    } catch (Exception $e) {
        echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
    }
}
?>
