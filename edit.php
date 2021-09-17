<?php
include 'config.php';
include 'utility.php';

$uid = isset($_GET['uid']) ? $_GET['uid'] : 0;

// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
$sqlstr = "SELECT * FROM person WHERE uid=? ";

$sth = $pdo->prepare($sqlstr);
$sth->bindValue(1, $uid, PDO::PARAM_INT);

// 執行SQL及處理結果
if($sth->execute())
{
   // 成功執行 query 指令
   if($row = $sth->fetch(PDO::FETCH_ASSOC))
   {
      $uid = $row['uid'];

      $usercode = convert_to_html($row['usercode']);
      $username = convert_to_html($row['username']);
      $address  = convert_to_html($row['address']);
      $birthday = convert_to_html($row['birthday']);
      $height   = convert_to_html($row['height']);
      $weight   = convert_to_html($row['weight']);
      $remark   = convert_to_html($row['remark']);
      
      $data = <<< HEREDOC
      <form action="edit_save.php" method="post">

        <div class="form-group row">
          <label for="usercode" class="col-2">代碼</label>
          <div class="col-10">
            <input type="text" class="form-control" name="usercode" id="usercode" placeholder="" value="{$usercode}">
          </div>
        </div>
        <div class="form-group row">
          <label for="username" class="col-2">姓名</label>
          <div class="col-10">
            <input type="text" class="form-control" name="username" id="username" placeholder="" value="{$username}">
          </div>
        </div>
        <div class="form-group row">
          <label for="address" class="col-2">地址</label>
          <div class="col-10">
            <input type="text" class="form-control" name="address" id="address" placeholder="" value="{$address}">
          </div>
        </div>
        <div class="form-group row">
          <label for="birthday" class="col-2">生日</label>
          <div class="col-10">
            <input type="text" class="form-control" name="birthday" id="birthday" placeholder="yyy-mm-dd" value="{$birthday}">
          </div>
        </div>
        <div class="form-group row">
          <label for="height" class="col-2">身高</label>
          <div class="col-3">
            <input type="text" class="form-control" name="height" id="height" placeholder="" value="{$height}">
          </div>
          <label for="weight" class="col-2 offset-2">體重</label>    
          <div class="col-3">
            <input type="text" class="form-control" name="weight" id="weight" placeholder="" value="{$weight}">
          </div>
        </div>
        <div class="form-group row">
          <label for="remark" class="col-2">備註</label>
          <div class="col-10">
            <input type="text" class="form-control" name="remark" id="remark" placeholder="" value="{$remark}">
          </div>
        </div>

        <div class="row">
          <input type="hidden" name="uid" value="{$uid}">
          <input type="submit" value="送出" class="btn btn-success">
        </div>

      </form>
HEREDOC;
   }
   else
   {
 	   $data = '查不到相關記錄！';
   }
}
else
{
   // 無法執行 query 指令時
   $data = error_message('edit');
}


$html = <<< HEREDOC
<button onclick="history.back();" class="btn btn-primary">返回</button>
<h2>修改資料</h2>
{$data}
HEREDOC;

include 'pagemake.php';
pagemake($html, '');
?>