<?php

/* Verify, Reset Password, Send Email */
abstract class TokenController extends BaseController
{
    protected const SEND_HTML_URL = "/token/send";
    protected const RESET_HTML_URL = "/token/reset";
    protected const RESULT_HTML_URL = "/token/result";
}