<?php

final class Mailer
{
    private string $to;
    private string $token;
    private string $type;

    public function __construct(string $email, string $token, string $type)
    {
        $this->to = $email;
        $this->token = $token;
        $this->type = $type;
    }

    /* Send email with token */
    public function sendEmail(): bool
    {
        $link = $this->buildLink();
        $subject = 'Camagru - ' . Lang::t("email.$this->type.subject");
        $body = $this->buildBody(
            Lang::t("email.$this->type.title"),
            Lang::t("email.$this->type.body"),
            $link,
            Lang::t("email.$this->type.link")
        );

        return $this->send($subject, $body);
    }

    /* Email link to Camagru */
    private function buildLink(): string
    {
        $base = $_ENV['APP_URL'] ?? 'http://localhost:8080';
        $lang = Lang::getLang();
        return "$base/$lang/verify?token=$this->token";
    }

    /* Email body */
    private function buildBody(string $title, string $message, string $link, string $btnText): string
    {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
        </head>
        <body style="margin:0; padding:0; background-color:#f4f4f4; font-family:Arial, sans-serif;">
            <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0;">
                <tr>
                    <td align="center">
                        <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; padding:40px;">
                            <tr>
                                <td align="center" style="padding-bottom:20px;">
                                    <h1 style="margin:0; color:#333333; font-size:24px;">' . htmlspecialchars($title) . '</h1>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-bottom:30px; color:#666666; font-size:16px; line-height:1.5; text-align:center;">
                                    ' . htmlspecialchars($message) . '
                                </td>
                            </tr>
                            <tr>
                                <td align="center" style="padding-bottom:30px;">
                                    <a href="' . htmlspecialchars($link) . '" style="display:inline-block; padding:14px 32px; background-color:#4a90d9; color:#ffffff; text-decoration:none; border-radius:6px; font-size:16px; font-weight:bold;">'
                                        . htmlspecialchars($btnText) .
                                    '</a>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top:20px; border-top:1px solid #eeeeee; color:#999999; font-size:12px; text-align:center;">
                                    ' . Lang::t('email.footer') . '
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>
        </html>';
    }

    /* Send email */
    private function send(string $subject, string $body): bool
    {
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "From: Camagru <noreply@camagru.com>\r\n";

        return @mail($this->to, $subject, $body, $headers);
    }
}