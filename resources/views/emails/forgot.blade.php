<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title></title>
</head>
<body>
<p>Hi {{$user->name}},<br/></p>
<p>You recently requested to reset your password. To reset your password, just copy & past the key below, </p>

<p><b>{{$user->bcrypt_key}}</b></p>

<p><br/>If you didn't request to reset your password, please contact us immediately at support@your-domain.com so we can secure your account.</p>
<p><br/>Best wishes,</p>
<p>The Support Team</p>
<p><hr></p>
<p style='color:#a5a5a5;font-size:11px'>You received this email because you are a registered member on Your-domain, 
Replies to this email address will not be read</p>
<p style='color:#a5a5a5;font-size:11px'>Copyright {{date('Y')}} Your-domain.com Incorporated. All rights reserved.</p>
</body>
</html>