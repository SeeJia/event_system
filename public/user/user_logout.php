<?php
session_start(); // 开始会话

// 销毁会话
session_unset(); // 清空会话变量
session_destroy(); // 销毁会话

// 重定向到登录页面或首页
header('Location: ../../index.php');
exit(); // 退出当前脚本
?>
