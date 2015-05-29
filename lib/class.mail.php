<?php

    class mail {

        public function __construct() {
            
        }

        /**
         * $to array
         * @param type $to
         */
        public function send($to = array()) {
            if (!is_array($to)) {
                die("输入数据格式必须是array");
            }
            header("content-type:text/html;charset=utf-8");
            ini_set("magic_quotes_runtime", 0);
            require_once PATH_LIB . DS . 'phpmailer' . DS . 'class.phpmailer.php';
            try {
                $mail = new PHPMailer(true);
                $mail->IsSMTP();
                $mail->CharSet = 'UTF-8'; //设置邮件的字符编码，这很重要，不然中文乱码
                $mail->SMTPAuth = true;                  //开启认证
                $mail->Port = 25;
                $mail->Host = "smtp.qq.com";
                $mail->Username = "1127827675@qq.com";
                $mail->Password = "markfang";
                //$mail->IsSendmail(); //如果没有sendmail组件就注释掉，否则出现“Could  not execute: /var/qmail/bin/sendmail ”的错误提示
                $mail->AddReplyTo("1127827675@qq.com", "markfang"); //回复地址
                $mail->From = "1127827675@qq.com";
                $mail->FromName = "markfang";
                $mail->AddAddress($to[0]);
                $mail->Subject = $to[1];
                $mail->Body = $to[2];
                $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; //当邮件不支持html时备用显示，可以省略
                $mail->WordWrap = 80; // 设置每行字符串的长度
                //$mail->AddAttachment("f:/test.png");  //可以添加附件
                $mail->IsHTML(true);
                $mail->Send();
                //echo '邮件已发送';
            } catch (phpmailerException $e) {
                oo::logs()->debug(date("Y-m-d H:i:s") . $e->errorMessage(), "mailerror.txt");
            }
        }

    }
    