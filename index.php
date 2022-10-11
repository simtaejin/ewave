<?php
session_start();
include_once "connect.php";


if (!empty($_REQUEST['user_id']) &&
    !empty($_REQUEST['user_pw'])) {

    $err = "";

    foreach ($_REQUEST as $k => $v) {
        $$k = $v;
    }

    $sql = "select * from member where id='{$user_id}' ";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    if (isset($row[0])) {


        $password = $row['password'];

        $sql = "SELECT CONCAT('*', UPPER(SHA1(UNHEX(SHA1('{$user_pw}'))))) as pass";
        $result = mysqli_query($conn, $sql);
        $row_p = mysqli_fetch_array($result);

        if ($password != $row_p['pass']) {
            $err = "패스워드 틀림";
        } else {
            $_SESSION['user_idx'] = $row['idx'];
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
        }
    } else {
        $err = "아이디가 없음";
    }

}

?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
    </head>
    <body>
    <?php if (!$_SESSION['user_idx']) { ?>
    <form method='post' action='/'>
        <table>
            <tr>
                <td>아이디</td>
                <td><input type='text' name='user_id' tabindex='1'/></td>
                <td rowspan='2'><input type='submit' tabindex='3' value='로그인' style='height:50px'/></td>
            </tr>
            <tr>
                <td>비밀번호</td>
                <td><input type='password' name='user_pw' tabindex='2'/></td>
            </tr>
        </table>
    </form>
    <?php } else { ?>
        <a href="./view.day.php">차트 1</a><br/>
        <a href="./view.month.php">차트 2</a><br/>
    <?php } ?>
    </body>
</html>
<?php
    echo $err;
?>