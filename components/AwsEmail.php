<?php

namespace app\components;

use Yii;
use yii\base\Component;
use app\models\EmailTemplate;
use app\models\User;
use app\models\UserEmail;

require Yii::$app->vendorPath . '/autoload.php';
use Aws\Ses\SesClient;

class AwsEmail extends Component
{

    private static $__accessKey = 'AKIAJ3JZA2TENDIDQTBQ';
    private static $__secretKey = '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';

    const version = "1.0";
    const AWS_KEY = "AKIAJ3JZA2TENDIDQTBQ";
    const AWS_SEC = "9AAYUIryfs/Z+z7v1GHWy5xuv9jnbh1qLQSYr7/W";
    const AWS_REGION = "us-east-1";
    const BOUNCER = "info@hangshare.com";  //if used, this also needs to be a verified email
    const LINEBR = "\n";
    const MAX_ATTACHMENT_NAME_LEN = 60;

    /**
     * Usage
     * $result = SESUtils::deliver_mail_with_attachment(array('receipt@r.com', 'receipt2@b.com'), $subject_str, $body_str, 'validatedsender@aws', $attachment_str);
     * use $result->success to check if it was successful
     * use $result->message_id to check later with Amazon for further processing
     * use $result->result_text to look for error text if the task was not successful
     *
     * @param type $to - individual address or array of email addresses
     * @param type $subject - UTF-8 text for the subject line
     * @param type $body - Text for the email
     * @param type $from - email address of the sender (Note: must be validated with AWS as a sender)
     * @return \ResultHelper
     */
    public static function deliver_mail_with_attachment($to, $subject, $body, $from, &$attachment = "", $attachment_name = "doc.jpg", $attachment_type = "image/jpg", $is_file = false, $encoding = "base64", $file_arr = null)
    {
        $result = new ResultHelper();
        //get the client ready
        $client = SesClient::factory(array(
            'credentials' => array(
                'key' => self::$__accessKey,
                'secret' => self::$__secretKey,
            ),
            'region' => 'us-east-1',
            'version' => '2010-12-01'
        ));
        //build the message
        if (is_array($to)) {
            $to_str = rtrim(implode(',', $to), ',');
        } else {
            $to_str = $to;
        }
        $msg = "To: $to_str" . self::LINEBR;
        $msg .= "From: $from" . self::LINEBR;
        //in case you have funny characters in the subject
        $subject = mb_encode_mimeheader($subject, 'UTF-8');
        $msg .= "Subject: $subject" . self::LINEBR;
        $msg .= "MIME-Version: 1.0" . self::LINEBR;
        $msg .= "Content-Type: multipart/alternative;" . self::LINEBR;
        $boundary = uniqid("_Part_" . time(), true); //random unique string
        $msg .= " boundary=\"$boundary\"" . self::LINEBR;
        $msg .= self::LINEBR;
        //now the actual message
        $msg .= "--$boundary" . self::LINEBR;
        //first, the plain text
        $msg .= "Content-Type: text/plain; charset=utf-8" . self::LINEBR;
        $msg .= "Content-Transfer-Encoding: 7bit" . self::LINEBR;
        $msg .= self::LINEBR;
        $msg .= strip_tags($body);
        $msg .= self::LINEBR;
        //now, the html text
        $msg .= "--$boundary" . self::LINEBR;
        $msg .= "Content-Type: text/html; charset=utf-8" . self::LINEBR;
        $msg .= "Content-Transfer-Encoding: 7bit" . self::LINEBR;
        $msg .= self::LINEBR;
        $msg .= $body;
        $msg .= self::LINEBR;
        //add attachments
        if (!empty($attachment)) {
            $msg .= "--$boundary" . self::LINEBR;
            $msg .= "Content-Transfer-Encoding: base64" . self::LINEBR;
            $clean_filename = mb_substr($attachment_name, 0, self::MAX_ATTACHMENT_NAME_LEN);
            $msg .= "Content-Type: $attachment_type; name=$clean_filename;" . self::LINEBR;
            $msg .= "Content-Disposition: attachment; filename=$clean_filename;" . self::LINEBR;
            $msg .= self::LINEBR;
            $msg .= base64_encode($attachment);
            //only put this mark on the last entry
            if (!empty($file_arr))
                $msg .= "==" . self::LINEBR;
            $msg .= "--$boundary";
        }
        if (!empty($file_arr) && is_array($file_arr)) {
            foreach ($file_arr as $file) {
                $msg .= "Content-Transfer-Encoding: base64" . self::LINEBR;
                $clean_filename = mb_substr($attachment_name, 0, self::MAX_ATTACHMENT_NAME_LEN);
                $msg .= "Content-Type: application/octet-stream; name=$clean_filename;" . self::LINEBR;
                $msg .= "Content-Disposition: attachment; filename=$clean_filename;" . self::LINEBR;
                $msg .= self::LINEBR;
                $msg .= base64_encode($attachment);
                //only put this mark on the last entry
                if (!empty($file_arr))
                    $msg .= "==" . self::LINEBR;
                $msg .= "--$boundary";
            }
        }
        //close email
        $msg .= "--" . self::LINEBR;

        //now send the email out
        try {

            $ses_result = $client->sendRawEmail(array(
                'Source' => $from,
                'Destinations' => array($to_str),
                'RawMessage' => array(
                    'Data' => base64_encode($msg),
                ),
                'ReturnPathArn' => $from,
            ));


            if ($ses_result) {
                $result->message_id = $ses_result->get('MessageId');
            } else {
                $result->success = false;
                $result->result_text = "Amazon SES did not return a MessageId";
            }
        } catch (Exception $e) {
            $result->success = false;
            $result->result_text = $e->getMessage() . " - To: $to_str, Sender: $from, Subject: $subject";
        }
        return $result;
    }

    ///////////////////////////////////////////////////////////////////////////////


    public static function getDomainFromEmail($email)
    {
        $domain = substr(strrchr($email, "@"), 1);
        return strtolower($domain);
    }

    public static function SendMail($to, $subject, $body, $from = 'info@hangshare.com')
    {

        $allowed_domians = ['hotmail.com', 'gmail.com', 'live.com', 'yahoo.com', 'outlook.com', 'yahoo.fr', 'outlook.fr', 'hotmail.fr'];
        if (!filter_var($to, FILTER_VALIDATE_EMAIL) || !in_array(self::getDomainFromEmail($to), $allowed_domians)) {
            return false;
        }

        $client = SesClient::factory(array(
            'credentials' => array(
                'key' => self::$__accessKey,
                'secret' => self::$__secretKey,
            ),
            'region' => 'us-east-1',
            'version' => '2010-12-01'
        ));
        try {
            $emailSentId = $client->sendEmail(array(
                'Source' => "HangShare.com <$from>",
                'Destination' => array(
                    'ToAddresses' => array($to)
                ),
                'Message' => array(
                    'Subject' => array(
                        'Data' => $subject,
                        'Charset' => 'UTF-8',
                    ),
                    'Body' => array(
                        'Text' => array(
                            'Data' => $body,
                            'Charset' => 'UTF-8',
                        ),
                        'Html' => array(
                            'Data' => $body,
                            'Charset' => 'UTF-8',
                        ),
                    ),
                ),
                'ReplyToAddresses' => array('info@hangshare.com'),
                'ReturnPath' => 'info@hangshare.com'
            ));
        } catch (Exception $exc) {
            print $exc->getTraceAsString() . chr(10);
        }
    }

    public static function queueUser($userId, $type, $params = [], $lang = 'ar')
    {
        $email = EmailTemplate::find()->where("code = '{$type}' AND lang = '{$lang}'")->one();
        $user = User::find()->where("id = {$userId}")->one();
        $name = $user->name;
        $email_to = $user->email;
        if (filter_var($email_to, FILTER_VALIDATE_EMAIL)) {
            $key = md5(microtime() . rand());
            $userEmail = new UserEmail;
            $userEmail->userId = $userId;
            $userEmail->emailId = $type;
            $userEmail->key = $key;
            $userEmail->opened_at = 0;
            $userEmail->save();
            $params['__user_name__ '] = $name;
            $body = strtr($email->body, $params);
            $body .= "<img src='https://www.hangshare.com/site/email/{$key}/' width='1' height='1' />";
            self::SendMail($email_to, $email->subject, $body);
        }
    }


}

class ResultHelper
{

    public $success = true;
    public $result_text = "";
    public $message_id = "";

}
