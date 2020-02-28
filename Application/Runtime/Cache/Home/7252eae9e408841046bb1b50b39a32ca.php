<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title><?php echo ($data["title"]); ?></title>
<link rel="shortcut icon" href="/public/assets/img/favicon.ico" />
<meta name="keywords" content="<?php echo ($data["keywords"]); ?>" />
<meta name="description" content="<?php echo ($data["description"]); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="format-detection" content="telephone=no, email=no" />
<script type="text/javascript" src="/public/assets/vendor/flexible/flexible.js"></script>
<meta content="maximum-dpr=2" name="flexible" />
<?php build_css(isset($data['css']) ? $data['css'] : '')?>
</head>
<body<?=body_class(isset($data['body_class']) ? $data['body_class'] : '')?>>

<?php if($data['buildings']):?>
<div class="section buildings">
	<div class="section-body" style="padding-top: 0px">
        <?php foreach ($data['buildings'] as $k => $item):?>
		<div class="building-item link-item" data-url="<?php echo U('building/'.$item['id']);?>">
			<div class="building-cover" style="background-image:url(<?php echo ($item["cover"]); ?>)">
                <?php if($item['tag']):?>
					<span class="building-tag"><?php echo ($item["tag"]); ?></span>
                <?php endif;?>
			</div>
			<div class="building-info">
				<div class="building-name"><span><?php echo ($item["name"]); ?></span></div>
				<div class="building-location"><span><?php echo ($item["location"]); ?></span></div>
				<div class="building-price"><span><?php echo ($item["price"]); ?></span><text class="sp"><?php echo ($data["lang"]["SP"]); ?></text></div>
				<button class="btn"><?php echo ($data["lang"]["VIEW_MORE"]); ?></button>
			</div>
		</div>
        <?php endforeach;?>
	</div>
</div><!-- //合作楼盘 -->

<?php endif;?>

<script type="text/javascript">var module = "<?php echo ($data["js_module"]); ?>";</script>
<?php build_js(isset($data['js']) ? $data['js'] : '')?>
</body>
</html>