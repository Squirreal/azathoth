<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title><?php echo ($data["title"]); ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="renderer" content="webkit" />
<link rel="shortcut icon" href="/public/assets/img/favicon.ico" />
<meta name="keywords" content="<?php echo ($data["keywords"]); ?>" />
<meta name="description" content="<?php echo ($data["description"]); ?>" />
<meta name="robots" content="index, follow" />
<?php build_css(isset($data['css']) ? $data['css'] : '')?>
</head>
<body<?=body_class(isset($data['body_class']) ? $data['body_class'] : '')?>>
<?php if($data['body_class'] != 'home'):?>
<div class="top-banner">
	<div class="container">
		<a href="<?php echo LU('/');?>" class="logo animated" data-animate="fadeInDown"><img src="/public/assets/img/img_logo_black.png" /> </a>
		<div class="menu animated" data-animate="fadeInDown">
			<a href="javascript:" class="btn-lang-switcher">
				<svg viewBox="0 0 12 12" class="icon-lang"><path d="M3.48 3.5c.17-.85.43-1.6.75-2.18A5.02 5.02 0 001.67 3.5zm1.03 0h2.98C7.16 2 6.57 1 6 1S4.84 2 4.5 3.5zm4 0h1.82a5.02 5.02 0 00-2.56-2.18c.32.58.58 1.33.75 2.18zm.16 1a13.82 13.82 0 010 3h2.1a5 5 0 000-3zm-1.01 0H4.34a12.43 12.43 0 000 3h3.32a12.43 12.43 0 000-3zm-4.33 0h-2.1a5 5 0 000 3h2.1a13.82 13.82 0 010-3zm5.19 4a7.5 7.5 0 01-.75 2.18 5.02 5.02 0 002.56-2.18zm-1.03 0H4.51C4.84 10 5.43 11 6 11s1.16-1 1.5-2.5zm-4 0H1.66c.57 1 1.48 1.77 2.56 2.18a7.5 7.5 0 01-.75-2.18zM6 12A6 6 0 116 0a6 6 0 010 12z" fill="currentcolor"></path></svg>
				<span><?php echo ($data["current_lang_name"]); ?></span>
			</a>
			<?php if($data['userinfo']):?>
			<div class="userinfo">
				<span><?php echo ($data["userinfo"]["nickname"]); ?></span>
				<img src="<?php echo ($data["userinfo"]["avatar"]); ?>" />
			</div>
			<?php else:?>
			<a href="javascript:" class="btn-login"><?php echo ($data["lang"]["SIGN_IN"]); ?></a>
			<a href="javascript:" class="btn-login"><?php echo ($data["lang"]["SIGN_UP"]); ?></a>
			<?php endif;?>
		</div>
	</div>
</div>
<?php endif;?>

<div class="breadcrumb">
    <div class="container">
	    <span><a href="<?php echo LU('/');?>"><?php echo ($data["lang"]["HOMEPAGE"]); ?></a></span>
        <img src="/public/assets/img/icon_arrow_right_s.png" />
        <span><?php echo ($data["lang"]["PRIVACY"]); ?></span>
    </div>
</div>

<div class="container page-content">
    <h2 class="page-title"><?php echo ($data["lang"]["PRIVACY"]); ?></h2>
    <div class="page-body">

    </div>
</div>

<div class="footer">
	<div class="container">
		<p>
			<a href="<?php echo LU('/page/about');?>"><?php echo ($data["lang"]["ABOUT_US"]); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;<em>|</em>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="<?php echo LU('/page/agreement');?>"><?php echo ($data["lang"]["AGREEMENT"]); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;<em>|</em>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="<?php echo LU('/page/privacy');?>"><?php echo ($data["lang"]["PRIVACY"]); ?></a>
		</p>
		<p>
			<img class="logo" src="/public/assets/img/img_logo_gray.png" />
		</p>
		<p class="copyright">
			<?php echo ($data["lang"]["COPYRIGHT"]); ?><img src="/public/assets/img/icon_icp.png" /><a href="http://beian.miit.gov.cn/" target="_blank"><?php echo ($data["lang"]["ICP_NUMBER"]); ?></a>
		</p>
	</div>
</div>
<div class="sidebar animated" data-animate="fadeInRight">
	<div class="btn btn-top" id="btn-go-top"><img src="/public/assets/img/icon_top.png" /></div>
	<div class="btn btn-link" id="btn-share"><img src="/public/assets/img/icon_link.png" /></div>
	<div class="btn btn-wechat hide"><img src="/public/assets/img/icon_wechat_white.png" /></div>
</div>

<div id="layer-lang-switcher" class="layer">
	<div class="inner">
		<a href="javascript:" class="close"></a>
		<h2><?php echo ($data["lang"]["SELECT_LANGUAGE"]); ?></h2>
		<a class="lang-item<?php if($data['current_lang'] == 'cn'):?> active<?php endif;?>" href="<?php echo LU('', array('lang' => 'cn'));?>">
			<h3>简体中文</h3>
			<p>China</p>
		</a>
		<a class="lang-item<?php if($data['current_lang'] == 'en'):?> active<?php endif;?>" href="<?php echo LU('', array('lang' => 'en'));?>">
			<h3>ENGLISH</h3>
			<p>United States</p>
		</a>
	</div>
</div>

<div id="layer-login" class="layer">
	<div class="inner">
		<a href="javascript:" class="close"></a>
		<div class="login-title"><em></em><span><?php echo ($data["lang"]["WEB_LOGIN_TITLE"]); ?></span><em></em></div>
		<div class="qrcode" data-url="<?php echo LU('/login/wechat');?>">
			<img src="/public/assets/img/icon_wechat.png" />
		</div>
		<p><?php echo ($data["lang"]["WEB_LOGIN_INTRO"]); ?></p>
	</div>
</div>

<div id="layer-share" class="layer">
	<div class="inner">
		<a href="javascript:" class="close"></a>
		<div class="share-title"><em></em><span><?php echo ($data["lang"]["WEB_SHARE_TITLE"]); ?></span><em></em></div>
		<div class="qrcode" id="qrcode-share">
			<img class="wechat-logo" src="/public/assets/img/icon_wechat.png" />
		</div>
		<p><?php echo ($data["lang"]["WEB_SHARE_INTRO"]); ?></p>
	</div>
</div>

<div id="layer-message" class="layer">
	<div class="inner">
		<a href="javascript:" class="close"></a>
		<div class="message-title"><em></em><span><?php echo ($data["lang"]["WEB_MESSAGE_TITLE"]); ?></span><em></em></div>
		<div class="message-body">
			<form action="<?php echo LU('/message');?>" method="post" id="msg-form" onsubmit="return false" autocomplete="off">
				<input type="hidden" name="type" value="1" />
				<input type="hidden" name="id" value="" />
				<div class="form-item">
					<label><?php echo ($data["lang"]["WEB_MESSAGE_FIELD_TEL"]); ?></label>
					<div>
						<input class="input" type="tel" name="tel" placeholder="<?php echo ($data["lang"]["WEB_MESSAGE_TIP_TEL"]); ?>" maxlength="20" />
					</div>
				</div>
				<div class="form-item">
					<label><?php echo ($data["lang"]["WEB_MESSAGE_FIELD_MSG"]); ?></label>
					<div>
						<textarea class="input" rows="3" type="text" name="msg" placeholder="<?php echo ($data["lang"]["WEB_MESSAGE_TIP_MSG"]); ?>"></textarea>
					</div>
				</div>
				<div class="form-item">
					<label>&nbsp;</label>
					<div>
						<button type="submit" id="btn-send"><?php echo ($data["lang"]["WEB_MESSAGE_SUBMIT"]); ?></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">var module = "<?php echo ($data["js_module"]); ?>",shareUrl = "https://www.squirreal.cn/share?<?php echo ($data["shareUrl"]); ?>";</script>
<?php build_js(isset($data['js']) ? $data['js'] : '')?>
</body>
</html>