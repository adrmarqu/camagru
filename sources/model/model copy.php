<?php

require_once __DIR__ . '/connect.php';



function validarEmailEstricto(string $email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        return false;
    return true;
}

function modeloRegistrarNuevoUsuario(string $usuario, string $email, array $lang)
{
    if (empty($usuario))
    {
        $_SESSION['error'] = $lang['error_usuario_vacio'];
        return false;
    }

    if (empty($email))
    {
        $_SESSION['error'] = $lang['error_email_vacio'];
        return false;
    }

    if (!validarEmailEstricto($email))
    {
        $_SESSION['error'] = $lang['error_email_invalido'];
        return false;
    }

    if (strlen($usuario) < 5)
    {
        $_SESSION['error'] = $lang['error_usuario_peque'];
        return false; 
    }

    if (strlen($usuario) > 15)
    {
        $_SESSION['error'] = $lang['error_usuario_grande']; 
        return false;
    }

    if (preg_match('/\d/', $usuario))
    {
        $_SESSION['error'] = $lang['error_usuario_numero'];
        return false;
    }

    global $con;
    if (!isset($con) || !$con)
        return false;

    $stmt = $con->prepare("SELECT id FROM usuarios WHERE usuario = ? OR email = ?");
    if (!$stmt)
    {
        $con->close();
        return false;
    }
    $stmt->bind_param('ss', $usuario, $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0)
    {
        $stmt->close();
        $con->close();
        $_SESSION['error'] = $lang['error_usuario_repetido'];
        return false;
    }
    $stmt->close();

    $ins = $con->prepare("INSERT INTO usuarios (usuario, email) VALUES (?, ?)");
    if (!$ins)
    {
        $con->close();
        return false;
    }
    $ins->bind_param('ss', $usuario, $email);
    $ok = $ins->execute();
    $ins->close();

    if ($ok)
    {
        $myrows = [];
        $result = $con->query("SELECT * FROM usuarios");
        if ($result)
        {
            while ($row = $result->fetch_assoc())
                $myrows[] = $row;
        }
        $con->close();
        return [$myrows, true];
    }

    $con->close();
    return false;
}
