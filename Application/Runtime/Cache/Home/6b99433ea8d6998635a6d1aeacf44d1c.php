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

<?php if($data['presales']):?>
<div class="section presales">
	<div class="section-body" style="padding-top: 0px">
        <?php foreach ($data['presales'] as $k => $item):?>
		<div class="presale-item link-item" data-url="<?php echo U('presale/'.$item['id']);?>">
			<div class="presale-meta">
				<div class="presale-cover" style="background-image:url(<?php echo ($item["cover"]); ?>)"></div>
				<div class="presale-info">
                    <?php if($item['name']):?>
						<span class="item-left"><?php echo ($item["name"]); ?></span>
                    <?php endif;?>
                    <?php if($item['type']):?>
						<span><?php echo ($item["type"]); ?></span>
                    <?php endif;?>
				</div>
				<div class="presale-info">
                    <?php if($item['layout']):?>
						<span class="item-left"><?php echo ($item["layout"]); ?></span>
                    <?php endif;?>
                    <?php if($item['area']):?>
						<span><?php echo ($item["area"]); ?></span>
                    <?php endif;?>
				</div>
			</div>
			<div class="presale-price">
				<span><?php echo ($item["price"]); ?></span>
			</div>
		</div>
        <?php endforeach;?>
	</div>
</div><!-- //楼花转让 -->
<?php endif;?>

<script type="text/javascript">var module = "<?php echo ($data["js_module"]); ?>";</script>
<?php build_js(isset($data['js']) ? $data['js'] : '')?>
</body>
</html>