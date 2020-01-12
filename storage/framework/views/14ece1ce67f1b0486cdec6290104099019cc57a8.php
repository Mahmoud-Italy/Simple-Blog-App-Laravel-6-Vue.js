<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title></title>
</head>
<body>
<p>Hi <?php echo e($user->name); ?>,<br/></p>
<p>Thanks for signing up! in Your domain, </p>

<p>All you need to do now is complete your registration by copy & past the key below:</p>
<p><b><?php echo e($user->bcrypt_key); ?></b></p>

<p><br/>Best wishes,</p>
<p>The Support Team</p>
<p><hr></p>
<p style='color:#a5a5a5;font-size:11px'>You received this email because you are a registered member on Your-domain, 
Replies to this email address will not be read</p>
<p style='color:#a5a5a5;font-size:11px'>Copyright <?php echo e(date('Y')); ?> Your-domain.com Incorporated. All rights reserved.</p>
</body>
</html><?php /**PATH /Users/apple/Sites/github/BlogApp/resources/views/emails/verify.blade.php ENDPATH**/ ?>