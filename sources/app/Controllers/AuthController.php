<?php

class AuthController extends BaseController
{
    public function login()
    {
        echo "Login";
        exit;
    }

    public function register()
    {
        // Mirar si hay post
            // Mirar formato correcto
            // Si hay error salir del if
            // Enviar datos
            // Si hay error salir del if
            // Guardar datos del usuario y redirigir
        
        $this->render(AuthSources::signin());
    }

    public function forgot()
    {
        echo "Olvidar contraseña";
        exit;
    }
}