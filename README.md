### 咕咕机非官方SDK
---

示例代码：
```
<?php
include 'MemobirdSDK.php';
//实例化
//传入:你自己的手机号
$memobird = new Memobird(your_phone_number);
//获取用户信息
//传入:用户咕咕ID或者手机号
print_r($memobird->getUserInfo(102979));
//搜索用户
//传入:用户手机号
print_r($memobird->searchUser(other_user_phone_number));
//获取自己的UserID
print_r($memobird->getSelfUserID());
//获取设备列表
//传入:用户的userID
print_r($memobird->getUserDeviceList($memobird->getSelfUserID()));
//获取设备信息
//传入:设备ID
print_r($memobird->getDeviceInfo(device_Guid));
//打印
//传入:用户名字,用户的userID,对方用户名字,咕咕机ID,内容
print_r($memobird->printPaper('Satori', $memobird->getSelfUserID(), 'DIYgod', gugu_id, content));
```