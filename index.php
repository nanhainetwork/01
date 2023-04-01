//作者：chatgpt3.5（ui页面）+葫芦侠下载的源码（curl）+本人微调（缝合）。
//使用方法：20行改成你的key密钥，找个虚拟主机（国外ip）上传就可以使用了。
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>ChatGPT-3.5</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

<?php
$question = "";
if (isset($_POST['question'])) {
	$question = $_POST['question'];
	$answer = chatgpt($question);
}

function chatgpt($question){
	$apikey="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";//只需要改成你的key密钥就可以使用了。//api获取：https://platform.openai.com/account/org-settings
	
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //验证curl对等证书(一般只要此项)
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); //检查服务器SSL证书中是否存在一个公用名
	curl_setopt($curl, CURLOPT_SSLVERSION, 0);  //传递一个包含SSL版本的长参数。
	curl_setopt_array($curl, [
	  CURLOPT_URL => "https://api.openai.com/v1/chat/completions",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 100,
	  CURLOPT_TIMEOUT => 10000,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => "{\r\n  \"model\": \"gpt-3.5-turbo\",\r\n  \"messages\": [{\"role\": \"user\", \"content\": \"'" . $question . "'\"}]\r\n}\r\n",
	  CURLOPT_HTTPHEADER => [
		"Authorization: Bearer ".$apikey,
		"Content-Type: application/json",
		"content-type: application/json"
	  ],
	]);
	
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	
	// 解析响应JSON并输出生成的文本 
	$json = json_decode($response, true); 
	if ($err) { 
		return "生成文本失败！错误信息：" . $err;
	} else {
		return $json['choices']['0']['message']['content'];
	}
}
?>

</head>
<body>
	<div class="container">
		<h1 class="text-center mt-5 mb-3">ChatGPT-3.5</h1>
		<form action="" method="post" class="border p-3">
			<div class="form-group">
				<label for="content">提问：</label>
				<textarea id="content" name="question" rows="5" class="form-control"><?php echo $question;?></textarea>
			</div>
			<button type="submit" class="btn btn-primary">提交</button>
		</form>

		<div class="border p-3">
			<div class="form-group">
				<label for="content">回答：</label>
				<textarea rows="8" class="form-control"><?php echo $answer;?></textarea>
			</div>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>


