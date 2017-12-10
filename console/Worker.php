<?php

require_once( SERVER_PATH . '/helpers/Queue.php');
require_once( SERVER_PATH . '/helpers/Mailer.php');

class Worker {
    /**
     * Store the semaphore queue handler.
     * @var resource
     */
    private $queue = NULL;
    /**
     * Store an instance of the read Message
     * @var Message
     */
    private $message = NULL;
    /**
     * Constructor: Setup our enviroment, load the queue and then
     * process the message.
     */
    public function __construct() {
        $this->queue = Queue::getQueue();
        $this->process();
    }

    private function process() {
        $messageType = NULL;
        $messageMaxSize = 1024;
        print "Listening on Queue with PID : " . getmypid() . "\n";
        while(msg_receive($this->queue, QUEUE_TYPE_START, $messageType, $messageMaxSize, $this->message)) {
            print "Message Received\n";
            $mailData = $this->message->getData();

            if( $mailData['requestType'] != 'email' ){
                print "Error : Given data is not for email\n";
                continue;
            }
            //'https://blog.caranddriver.com/wp-content/uploads/2017/05/Huracan_Performante_orange_097-626x383.jpg'
            $mailObj = new Mailer();
            $attachment = ''; // Check if this order has invoice prepared and get the file path into this variable

            $res = false;
            if( strlen($attachment) > 0 ){
                $res = $mailObj->mail_attachment($mailData['recepient'], $mailData['subject'], $mailData['message']);
            }else{
                    $res = $mailObj->plain_mail($mailData['recepient'], $mailData['subject'], $mailData['message'], $attachment);
            }

            # Reset the message state
            $messageType = NULL;
            $this->message = NULL;

            if( !$res && $mailData['retries'] < 3 ){
                $mailData['retries'] = isset( $mailData['retries'] ) ? $mailData['retries']++ : 1 ;
                Queue::addMessage($mailData['orderId'], $mailData);
                continue;
            }

            echo "Mail sent for Order ID : " . $mailData['orderId'] . "\n";
       }
    }
}

?>