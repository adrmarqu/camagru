<?php

class CheckFormController
{
    private string  $user;
    private string  $email;
    private string  $pass;
    private string  $passRep;
    private string  $newPass;
    private bool    $terms;

    public function __construct(array $post)
    {
        $this->user = $post['user'] ?? '';
        $this->email = $post['email'] ?? '';

        $this->pass = $post['pass'] ?? '';
        $this->passRep = $post['passRep'] ?? '';
        $this->newPass = $post['newPass'] ?? '';
        
        $this->terms = $post['terms'] ?? '';
    }

    public function checkForm(string $type, array $lang): array
    {
        $functionName = 'check' . $type;
        if (!method_exists($this, $functionName))
            return $lang['error_generic'] ?? 'Invalid form type';
        return $this->$functionName($lang);
    }

    private function checkLogin(array $lang): ?string
    {
        // Mirar la bbdd por coincidencias
    }

    private function checkSignin(array $lang): ?string
    {
        // Hacer check (user + email + pass + rep + sign)

        if (!$this->checkUser($this->user))
            return $lang['error_user'] ?? 'Error';
        
        if (!$this->checkEmail($this->email))
            return $lang['error_email'] ?? 'Error';

        if (!$this->checkPass($this->pass))
            return $lang['error_pass'] ?? 'Error';

        if (!$this->checkPassRep($this->pass, $this->passRep))
            return $lang['error_pass_rep'] ?? 'Error';
        
        if ($this->terms === false)
            return $lang['error_terms'] ?? 'Error';
        
        // Mirar la bbdd que no exista
        
    }

    private function checkUpdateUser(array $lang): ?string
    {
        // Hacer check (nuevo user)

        if (!$this->checkUser($this->user))
            return $lang['error_user'] ?? 'Error';
        
        $userid = $this->getUserId();

        // Peticion a la bbdd con el nuevo usuario
        // Si encuentra algo
            // id = userid
            // id != userid

        // Subir informacion
    }

    private function checkUpdateEmail(array $lang): ?string
    {
        //$userid = $this->getUserId();
        
        // Hacer check (nuevo email)

        if (!$this->checkEmail($this->email))
            return $lang['error_email'] ?? 'Error';

        // Peticion a la bbdd con el nuevo email
        // Si encuentra algo
            // id = userid
            // id != userid

        // Subir informacion
    }

    private function checkUpdatePass(array $lang): ?string
    {
        // Hacer check (nueva pass + rep)

        if (!$this->checkPass($this->pass))
            return $lang['error_pass'] ?? 'Error';

        if (!$this->checkPassRep($this->pass, $this->passRep))
            return $lang['error_pass_rep'] ?? 'Error';

        // Peticion a la bbdd para conseguir la password
        // Si es igual error

        // Subir informacion

    }

    /* 
    -------------------------------------------------------------------
    |                             UTILS                               |
    -------------------------------------------------------------------
    */

    /* private function getUserId()
    {
        return (int)($_SESSION['user_id'] ?? -1);
    } */

    private function checkUser(string $user): bool
    {
        $user = trim($user);

        $userPattern = '/^[a-zA-Z][a-zA-Z0-9_]{3,20}$/';

        if (!preg_match($userPattern, $user))
            return false;
        return true;
            
        //"El usuario tiene que estar entre 3 y 20 caracteres, solo puede tener letras, numeros o guiones bajos y ha de empezar por una letra";
    }

    private function checkEmail(string $email): bool
    {
        $emailPattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

        if (!preg_match($emailPattern, $email))
            return false;
        return true;
        //return "Formato de correo incorrecto";
    }

    private function checkPass(string $pass): bool
    {
        $passPattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/';

        if (!preg_match($passPattern, $pass))
            return false;
        return true;

        //return "La contraseña tiene que tener 8 caracteres, 1 mayuscula, 1 minuscula, 1 numero";
    }

    private function checkPassRep(string $pass, string $rep): bool
    {
        if ($pass !== $rep)
            return false;
        return true;

        //return "Passwords are not equal";
    }
        //"Necesitas aceptar los terminos";
}