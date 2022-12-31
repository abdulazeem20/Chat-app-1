<?php
$database = new Database;

class Message
{
    /**
     * construct
     *
     * @param $user = []
     *
     */
    public function __construct($data = [])
    {
        foreach ($data as $key => $detail) {
            $this->$key = $detail;
        };
    }

    public function saveMessage()
    {
        $data = [];
        $data['sender_id'] = $this->senderId;
        $data['receiver_id'] = $this->receiverId;
        $data['message'] = $this->messages;
        $conv_id1 = preg_replace(
            "/[^0-9]/",
            0,
            $this->senderId
        );
        $conv_id2 = preg_replace(
            "/[^0-9]/",
            0,
            $this->receiverId
        );

        $data['conv_id'] = $conv_id1 * $conv_id2;

        $query = "INSERT INTO messages(conv_id,sender_id,receiver_id,message,sent) VALUES (:conv_id,:sender_id, :receiver_id,:message,1)";
        $result = $GLOBALS['database']->insert($query, $data);
        return $result;
    }

    public function getMessages()
    {
        $data = [];
        $data['sender_id'] = $this->senderId;
        $data['receiver_id'] = $this->receiverId;
        $query = "SELECT * FROM message_info_v WHERE (sender_id = :sender_id AND receiver_id = :receiver_id ) OR (sender_id = :receiver_id AND receiver_id = :sender_id) ORDER BY msg_id ASC";
        return $GLOBALS['database']->fetchA($query, $data);
    }

    public function getChat()
    {
        $data = [];
        $data['id'] = $this->ussid;
        $query = "SELECT 
        miv.*
        FROM
            message_info_v miv
        JOIN (
        SELECT MAX(created_at) latest_time FROM message_info_v group by conv_id
        ) mv
        ON miv.created_at = mv.latest_time
        WHERE
        sender_id = :id
            OR receiver_id = :id 
        ORDER BY created_at DESC";
        return $GLOBALS['database']->fetchA($query, $data);
    }

    public function saveReceived()
    {
        $data = [
            'ussid' => $this->ussid,
        ];

        $query = "UPDATE messages SET received = 1 WHERE receiver_id = :ussid";

        return $GLOBALS['database']->insert($query, $data);
    }

    public function saveSeen()
    {
        $data = [
            'ussid' => $this->ussid,
            'conv_id' => $this->convId
        ];

        $query = "UPDATE messages SET seen = 1 WHERE receiver_id = :ussid AND conv_id = :conv_id";

        return $GLOBALS['database']->insert($query, $data);
    }

    public function getUnreadMessages()
    {
        $data = [
            'ussid' => $this->ussid,
            'conv_id' => $this->convId
        ];
        $query = "SELECT 
        COUNT(*)
        FROM
        message_info_v
        WHERE
        sent = 1 AND seen = 0
            AND receiver_id = :ussid
            AND conv_id = :conv_id
        ";
        return $GLOBALS['database']->countItem($query, $data);
    }
}
