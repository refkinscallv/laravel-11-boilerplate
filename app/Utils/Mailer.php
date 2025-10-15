<?php

namespace App\Utils;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Log;

class Mailer
{
    protected static PHPMailer $mailer;
    protected static array $config = [];

    public static function init(array $opts): void
    {
        self::$config = $opts;
        $cfg = $opts['credentials'];

        $opts['to_name'] = config('app.name');

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPDebug = $opts['debug'] ? SMTP::DEBUG_SERVER : false;
        $mail->Host       = $cfg['host'];
        $mail->SMTPAuth   = $cfg['auth'];
        $mail->Username   = $cfg['user'];
        $mail->Password   = $cfg['pass'];
        $mail->SMTPSecure = $cfg['secure'] ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $cfg['secure'] ? 465 : 587;

        $mail->setFrom($cfg['user'], config('app.name'));
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        self::$mailer = $mail;
    }

    public static function send(array $opts): bool
    {
        try {
            $mail = clone self::$mailer;

            $mail->addAddress($opts['to'], $opts['to_name'] ?? '');

            if (!empty($opts['cc'])) {
                foreach ((array) $opts['cc'] as $cc) $mail->addCC($cc);
            }

            if (!empty($opts['bcc'])) {
                foreach ((array) $opts['bcc'] as $bcc) $mail->addBCC($bcc);
            }

            if (!empty($opts['reply_to'])) {
                $mail->addReplyTo($opts['reply_to']);
            } else {
                $mail->addReplyTo('no-reply@gmail.com');
            }

            if (!empty($opts['attachments'])) {
                foreach ((array) $opts['attachments'] as $file) $mail->addAttachment($file);
            }

            $mail->Subject = $opts['subject'] ?? '(No Subject)';
            $mail->Body    = $opts['body'] ?? '';
            $mail->AltBody = $opts['alt'] ?? strip_tags($opts['body'] ?? '');

            $mail->send();
            return true;
        } catch (Exception $e) {
            Log::error('[MAILER ERROR] ' . $e->getMessage());
            return false;
        }
    }
}
