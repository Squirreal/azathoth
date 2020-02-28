<?php
/**
 * @TODO add user log
 * @param $uid
 * @param string $code
 * @param string $type
 * @param string $operating
 * @param int $result
 * @param string $username
 * @param string $content
 * @param string $data
 */
function user_log($uid, $code = 'null', $type = 'null', $operating = 'null', $result = 0, $username = '', $content = '', $data = '') {
    M('sys_users_log')->add(array(
        'uid' => $uid,
        'code' => $code,
        'type' => $type,
        'operating' => $operating,
        'result' => $result,
        'username' => $username,
        'content' => $content,
        'data' => json_encode($data ? $data : $_REQUEST),
        'addtime' => date('Y-m-d H:i:s'),
        'addip' => get_client_ip()
    ));
}