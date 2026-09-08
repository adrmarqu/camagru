<?php

class HttpController extends BaseController
{
    public function __invoke(HttpException $e)
    {
        $code = $e->getCode();
        $data =
        [
            'code' => $code,
            'titleErr' => Lang::t("$code.title"),
            'message' => $e->getMessage(),
            'link' => $e->getLink(),
            'linkLabel' => $e->getBtnName(),
            'css' => [ '/error.css' ]
        ];

        http_response_code($e->getCode());
        $this->render('/others/error', $data);
    }
}