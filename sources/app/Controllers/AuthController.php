<?php

class AuthController extends BaseController
{
    public function login()
    {
        $this->render('/auth/login', AuthSources::login());
    }

    public function signin()
    {
        // Mirar si hay post
            // Mirar formato correcto
            // Si hay error salir del if
            // Enviar datos
            // Si hay error salir del if
            // Guardar datos del usuario y redirigir
        
        $this->render('/auth/signin', AuthSources::signin());
    }

    public function forgot()
    {
        $this->render('/auth/forgot', AuthSources::forgot());

    }
}