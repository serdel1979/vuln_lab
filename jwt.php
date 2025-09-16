<?php
session_start();

// Implementación didáctica y vulnerable de JWT.
// NO usar en producción.

function b64($s){ return rtrim(strtr(base64_encode($s), '+/', '-_'), '='); }

// Genera JWT sencillo al visitar ?gen=1
if (isset($_GET['gen']) && isset($_SESSION['user'])) {
    $header = json_encode(['typ'=>'JWT','alg'=>'HS256']);
    $payload = json_encode(['user'=>$_SESSION['user'], 'role'=>'user', 'iat'=>time()]);
    $secret = 'my_super_secret'; // secreto fijo y débil
    $sig = hash_hmac('sha256', b64($header).'.'.b64($payload), $secret, true);
    $token = b64($header).'.'.b64($payload).'.'.b64($sig);
    echo "Token: <pre>$token</pre>";
    exit;
}

// Verificación INTENCIONALMENTE INSEGURA:
// Acepta tokens con alg:none (no firma) o firma HMAC con clave fija.
// Esto permite practicar bypasss y ver por qué es peligroso.
if (isset($_POST['token'])) {
    $token = $_POST['token'];
    $parts = explode('.', $token);
    if (count($parts) !== 3) { echo "Formato inválido"; exit; }
    $header = json_decode(base64_decode(strtr($parts[0], '-_', '+/')));
    $payload = json_decode(base64_decode(strtr($parts[1], '-_', '+/')), true);
    $sig = $parts[2];

    if ($header->alg === 'none') {
        // ACEPTAMOS tokens sin firma (vulnerabilidad intencional)
        echo "Aceptado token con alg:none. Payload:<pre>" . print_r($payload, true) . "</pre>";
        exit;
    } elseif ($header->alg === 'HS256') {
        $secret = 'my_super_secret';
        $expected = rtrim(strtr(base64_encode(hash_hmac('sha256', $parts[0].'.'.$parts[1], $secret, true)), '+/', '-_'), '=');
        if ($expected === $sig) {
            echo "Firma valida. Payload:<pre>" . print_r($payload, true) . "</pre>";
        } else {
            echo "Firma invalida.";
        }
        exit;
    } else {
        echo "Algoritmo no soportado en esta demo.";
        exit;
    }
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>JWT demo</title></head><body>
<h2>JWT demo (vulnerable)</h2>
<p>Si estás logueado puedes <a href="?gen=1">generar un token</a> (HS256 con clave fija).</p>
<form method="post">
  Token a verificar:<br>
  <textarea name="token" cols="80" rows="5"></textarea><br>
  <button>Verificar</button>
</form>
<p><a href="users.php">Volver</a></p>
</body></html>
