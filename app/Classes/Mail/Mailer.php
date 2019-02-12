<?php
    namespace oTikets\Classes\Mail;

    use Mailgun\Mailgun;

    class Mailer
    {
        protected $container;
        protected $mailer;

        protected $mgClient;
        protected $domain;

        public function __construct($container, $mailer)
        {
            $this->container = $container;
            $this->mailer = $mailer;

            $this->mgClient = Mailgun::create($mailer['mailgun-api']);
            $this->domain = $mailer['mailgun-domain'];
        }

        public function send(array $data)
        {
            try {
                $mail = $this->mgClient->messages()->send($this->domain, [
                    'from'    => "oTikets <{$data['from']}>",
                    'to'      => $data['to'],
                    'subject' => $data['subject'],
                    'text'    => $data['text'],
                    'html'    => $data['body']
                ]);

                return true;
            } catch (Mailgun\Exception $e) {
                return false;
            }
        }
    }
    