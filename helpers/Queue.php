<?php

require_once( SERVER_PATH . '/helpers/Message.php');

class Queue {
    
    private static $queue = NULL;
  
    public static function getQueue() {
    
        if( self::$queue == NULL ){
            self::$queue = msg_get_queue(QUEUE_KEY);
        }
        
        return self::$queue;
      
    }

    public static function addMessage($key, $data = []) {        
        $message = new Message($key, $data);        
        $queue = self::getQueue();
        if(msg_send($queue , QUEUE_TYPE_START, $message)) {
            return true;
        } else {
            return false;
        }
    }
    
}

?>