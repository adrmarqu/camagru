<?php

final class SendEmail
{
    private function __construct() {}

    public static function account(string $to, string $token): bool
    {
        $link = self::buildLink($token);
        $subject = 'Camagru - ' . Lang::t('email.account.subject');
        $body = self::buildBody(
            Lang::t('email.account.title'),
            Lang::t('email.account.body'),
            $link,
            Lang::t('email.account.link')
        );

        return self::send($to, $subject, $body);
    }

    public static function password(string $to, string $token): bool
    {
        $link = self::buildLink($token);
        $subject = 'Camagru - ' . Lang::t('email.subject.reset');
        $body = self::buildBody(
            Lang::t('email.title.reset'),
            Lang::t('email.body.reset'),
            $link,
            Lang::t('email.btn.reset')
        );

        return self::send($to, $subject, $body);
    }

    public static function email(string $to, string $token): bool
    {
        $link = self::buildLink($token);
        $subject = 'Camagru - ' . Lang::t('email.subject.confirm');
        $body = self::buildBody(
            Lang::t('email.title.confirm'),
            Lang::t('email.body.confirm'),
            $link,
            Lang::t('email.btn.confirm')
        );

        return self::send($to, $subject, $body);
    }

    private static function buildLink(string $token): string
    {
        $base = $_ENV['APP_URL'] ?? 'http://localhost:8080';
        $lang = Lang::getLang();
        return "$base/$lang/verify?token=$token";
    }

    private static function buildBody(string $title, string $message, string $link, string $btnText): string
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

    private static function send(string $to, string $subject, string $body): bool
    {
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "From: Camagru <noreply@camagru.com>\r\n";

        return @mail($to, $subject, $body, $headers);
    }
}
