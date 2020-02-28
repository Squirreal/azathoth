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
	    <span><a href="<?php echo LU('/country/'.$data['info']['country_id']);?>"><?php echo ($data["info"]["country_name"]); ?></a></span>
        <img src="/public/assets/img/icon_arrow_right_s.png" />
	    <span><a href="<?php echo LU('/city/'.$data['info']['city_id']);?>"><?php echo ($data["info"]["city_name"]); ?></a></span>
        <img src="/public/assets/img/icon_arrow_right_s.png" />
	    <span><a href="<?php echo LU('/city/presales/id/'.$data['info']['city_id']);?>"><?php echo ($data["lang"]["PRESALES_LIST"]); ?></a></span>
	    <img src="/public/assets/img/icon_arrow_right_s.png" />
        <span><?php echo ($data["info"]["name"]); ?></span>
    </div>
</div>
<div class="building-banner">
    <?php if($data['banner_video']):?>

    <div class="building-video fl">
        <video poster="<?php echo ($data["banner_video"]); ?>?x-oss-process=video/snapshot,t_1000" controls>
            <source src="<?php echo ($data["banner_video"]); ?>" type="video/mp4">
        </video>
    </div>

    <div class="building-images fl">
        <?php foreach ($data['banner_images'] as $k => $v):?>
        <div class="building-image<?php if($k > 3): ?> hide<?php endif;?>">
            <a class="inner js-img-viwer" href="<?php echo ($v["file"]); ?>" data-group="0" data-id="<?php echo ($k); ?>" style="background-image: url('<?php echo ($v["file"]); ?>')"><img src="<?php echo ($v["file"]); ?>" /></a>
        </div>
        <?php endforeach;?>

    </div>

    <?php else:?>

    <?php foreach ($data['banner_images'] as $k => $v):?>
    <div class="building-image<?php if($k > 7): ?> hide<?php endif;?>">
        <a class="inner js-img-viwer" href="<?php echo ($v["file"]); ?>" data-group="0" data-id="<?php echo ($k); ?>" style="background-image: url('<?php echo ($v["file"]); ?>')"><img src="<?php echo ($v["file"]); ?>" /> </a>
    </div>
    <?php endforeach;?>


    <?php endif;?>

</div>


<div class="section">
    <div class="container">
        <div class="building animated" data-animate="fadeInUp">
            <h2 class="building-name"><?php echo ($data["info"]["name"]); ?></h2>
            <p class="building-location"><?php echo ($data["info"]["location"]); ?></p>
            <div class="building-meta">
                <div class="meta-item">
                    <div class="meta-head">
                        <h3><?php echo ($data["lang"]["PROPERTY_YEARS"]); ?></h3>
                        <div><img src="/public/assets/img/icon_timeline.png"/></div>
                    </div>
                    <?php if($data['info']['property_years'] > 0):?><p><?php echo ($data["info"]["property_years"]); echo ($data["lang"]["YEAR"]); ?></p><?php endif;?>
                    <?php if($data['info']['property_years'] == -1):?><p><?php echo ($data["lang"]["FOREVER"]); ?></p><?php endif;?>
                </div>
                <div class="meta-item">
                    <div class="meta-head">
                        <h3><?php echo ($data["lang"]["DELIVERY_TIME"]); ?></h3>
                        <div><img src="/public/assets/img/icon_today.png"/></div>
                    </div>
                    <p><?php echo ($data["info"]["delivery_time"]); ?></p>
                </div>
                <div class="meta-item">
                    <div class="meta-head">
                        <h3><?php echo ($data["lang"]["PROJECT_STATUS"]); ?></h3>
                        <div><img src="/public/assets/img/icon_dashboard.png"/></div>
                    </div>
                    <p><?php echo ($data["info"]["project_status"]); ?></p>
                </div>
            </div>
            <div class="building-info waypoint animated" data-animate="fadeInUp" id="building-info">
                <h3 class="info-title">
	                <span><?php echo ($data["lang"]["PROJECT_INFO"]); ?></span>
	                <?php if($data['info']['pdf']):?>
	                <a href="<?php echo ($data["info"]["pdf"]); ?>" target="_blank"><?php echo ($data["lang"]["PROJECT_DOWNLOAD"]); ?><img src="/public/assets/img/icon_download.png" /> </a>
	                <?php endif;?>
                </h3>
                <div class="info-body">
					<div class="presale-info">
                        <?php if($data['info']['type']):?>
						<div class="apartment-item">
							<span><?php echo ($data["lang"]["TYPE"]); ?></span>
							<div class="right"><span><?php echo ($data["info"]["type"]); ?></span></div>
						</div>
                        <?php endif;?>
                        <?php if($data['info']['layout']):?>
						<div class="apartment-item">
							<span><?php echo ($data["lang"]["HOUSE_LAYOUT"]); ?></span>
							<div class="right"><span><?php echo ($data["info"]["layout"]); ?></span></div>
						</div>
                        <?php endif;?>
                        <?php if($data['info']['floor']):?>
						<div class="apartment-item">
							<span><?php echo ($data["lang"]["FLOOR"]); ?></span>
							<div class="right"><span><?php echo ($data["info"]["floor"]); ?></span></div>
						</div>
                        <?php endif;?>
                        <?php if($data['info']['room']):?>
						<div class="apartment-item">
							<span><?php echo ($data["lang"]["ROOM_NUMBER"]); ?></span>
							<div class="right"><span><?php echo ($data["info"]["room"]); ?></span></div>
						</div>
                        <?php endif;?>
                        <?php if($data['info']['area']):?>
						<div class="apartment-item">
							<span><?php echo ($data["lang"]["AREA_OF_HOUSE"]); ?></span>
							<div class="right"><span><?php echo ($data["info"]["area"]); ?></span></div>
						</div>
                        <?php endif;?>
                        <?php if($data['info']['balcony_area']):?>
						<div class="apartment-item">
							<span><?php echo ($data["lang"]["BALCONY_AREA"]); ?></span>
							<div class="right"><span><?php echo ($data["info"]["balcony_area"]); ?></span></div>
						</div><?php endif;?>
                        <?php if($data['info']['price']):?>
						<div class="apartment-item">
							<span><?php echo ($data["lang"]["PRICE"]); ?></span>
							<div class="right"><span><?php echo ($data["info"]["price"]); ?></span></div>
						</div>
                        <?php endif;?>
					</div>

                    <div class="tags">
                        <?php if($data['tags']):$tag_count=0;foreach($data['tags'] as $tags):?>
                        <?php foreach($tags as $k => $v):?>
                        <div class="tag-item <?php if($tag_count > 0 && ($tag_count + 1) % 4 == 0):?>side<?php endif;?>">
                            <div class="icon"><img src="<?php echo ($v["icon"]); ?>" /></div>
                            <h4><?php echo ($v["name"]); ?></h4>
                            <p><?php echo ($v["intro"]); ?></p>
                        </div>
                        <?php if($tag_count > 0 && ($tag_count + 1) % 4 == 0):?><div class="clear"></div><?php endif;?>
                        <?php $tag_count++;endforeach;?>
                        <?php endforeach;endif;?>
                    </div>
                </div>
            </div>

	        <?php if($data['process']):?>
	        <div class="purchase-process waypoint animated" data-animate="fadeInUp" id="purchase-process">
		        <h3 class="pp-title"><?php echo ($data["lang"]["PURCHASE_PROCESS"]); ?></h3>
		        <div class="pp-body">
                    <?php foreach ($data['process'] as $k => $v):?>
                        <?php if($v['type'] == 1):?>
					        <img src="<?php echo ($v["file"]); ?>" />
                        <?php elseif($v['type'] == 2):?>
					        <video poster="<?php echo ($v["file"]); ?>?x-oss-process=video/snapshot,t_1000" controls>
						        <source src="<?php echo ($v["file"]); ?>" type="video/mp4">
					        </video>
                        <?php endif;?>
                    <?php endforeach;?>
		        </div>
	        </div>
	        <?php endif;?>
        </div>
        <div class="broker animated" data-animate="fadeInUp" id="broker">
	        <div class="broker-inner">
	            <div class="broker-name">
	                <div style="background-image: url('<?php echo ($data["broker"]["avatar"]); ?>')" class="avatar"></div>
	                <span><?php echo ($data["broker"]["name"]); ?></span>
	            </div>
	            <p><span class="title"><?php echo ($data["lang"]["LANGUAGES"]); ?>：</span><span><?php echo ($data["broker"]["languages"]); ?></span></p>
	            <p><span class="title"><?php echo ($data["lang"]["CERTIFICATE"]); ?>：</span><span><?php echo ($data["broker"]["certificate"]); ?></span></p>
	            <?php if($data['broker']['experience']):?>
	            <p><span class="title"><?php echo ($data["lang"]["INDUSTRY_EXPERIENCE"]); ?>：</span><span><?php echo ($data["broker"]["experience"]); ?></span></p>
	            <?php endif;?>
	            <?php if($data['broker']['education']):?>
	            <p><span class="title"><?php echo ($data["lang"]["EDUCATION"]); ?>：</span><span><?php echo ($data["broker"]["education"]); ?></span></p>
	            <?php endif;?>
	            <?php if($data['broker']['tel']):?>
		        <p><span class="title"><?php echo ($data["lang"]["TELEPHONE"]); ?>：</span><span><?php echo ($data["broker"]["tel"]); ?></span></p>
	            <?php endif;?>
	            <button id="btn-consult" data-type="2" data-id="<?php echo ($data["id"]); ?>"><?php echo ($data["lang"]["CONSULT_NOW"]); ?></button>
	        </div>

	        <img src="/public/assets/img/img_qrcode.jpg" class="qrcode" />
        </div>
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