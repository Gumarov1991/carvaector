<?php /** @noinspection SpellCheckingInspection */
/** @noinspection PhpUndefinedVariableInspection */

/**
 * $auc_mode = 'login' - при входе либо восстановлении токена
 * требуются $email, $pass
 *
 * $auc_mode = 'register' - при регистрации
 * требуются все переменные для регистрации, в том числе $email, $pass
 */
if (empty($auc_mode)) die('404');

$default_placeholder = '_';

/**
 * @param $s
 * @param string $placeholder
 * @return string
 */
function stringOrPlaceholder($s, $placeholder = null) {
    global $default_placeholder;
    return empty($s) ? (
    ($placeholder === null) ? $default_placeholder : $placeholder
    ) : $s;
}

function processUsername($name) {
    if ($name === 'carvector@carvector.com') {
        return 'carvector.com';
    }
    return $name;
}

/** @noinspection PhpUndefinedVariableInspection */
$user_auc = array(
    /**
     * required
     */
    'username' => processUsername($email),
    'email' => $email,
    'fio' => $default_placeholder,
    'country' => $default_placeholder,
    'town' => $default_placeholder,
    'tel' => $default_placeholder,
    'password' => $pass,

    'magent' => $default_placeholder,
    'regmiliage' => $default_placeholder,
    'regyear' => $default_placeholder,
    'fax' => $default_placeholder,

    /**
     * optional
     */
    'skype' => '',
    'port' => '',
    'about' => '',
);

if ($auc_mode === 'register') {
    $user_auc['fio'] = mb_convert_encoding($fio, 'Windows-1251');
    $user_auc['country'] = stringOrPlaceholder($ip_country);
    $user_auc['town'] = stringOrPlaceholder($ip_region);
    $user_auc['tel'] = stringOrPlaceholder($mphone);

    $user_auc['magent'] = stringOrPlaceholder($car_preferences);
    $user_auc['regmiliage'] = stringOrPlaceholder($car_preferredMileage);
    $user_auc['regyear'] = stringOrPlaceholder($car_preferredYear);
    $user_auc['fax'] = stringOrPlaceholder($car_preferredPrice);

    $user_auc['skype'] = $skype;
    $user_auc['about'] = $info;
}

$s = aj_user($user_auc);
list($answer, $user_id) = explode(' ', $s);

require_once 'auc_methods.php';
$s2 = aj_login($user_auc['username'], $user_auc['password'], $user_id, $s3);

/**
 * @param $user
 * @return false|string
 */
function aj_user($user) {
    $adminCookieValue = 'Y2FydmVjdG9yLmNvbTozOTdkMTc0MTEyM2RiNzQ3M2M2NDE3MTg0ZTQ5ZGNmNjozNzM3Mjc6MTowMDAwMDAwMDAwOjE%3D';

    $post = '';
    foreach ($user as $key => $val) {
        $post = $post . '&' . $key . '=' . $val;
    }

    $ch = curl_init('http://auc.carvector.com/register');
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_POST, 1);        /* add &balance2=1000 if need update balance */
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post . '&password2=' . $user['password'] . '&is_login=from_register&ip_new=' . $_SERVER['REMOTE_ADDR']);
    curl_setopt($ch, CURLOPT_COOKIE, 'ajuser=' . $adminCookieValue);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
    ]);

    ob_start();
    curl_exec($ch);
    curl_close($ch);
    $s = ob_get_contents();
    ob_end_clean();
    return $s;
}