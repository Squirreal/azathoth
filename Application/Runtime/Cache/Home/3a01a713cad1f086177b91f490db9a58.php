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

<?php if($data['banner']):?>
<div class="swiper">
	<div class="swiper-container">
		<div class="swiper-wrapper">
			<?php foreach ($data['banner'] as $k => $v):?>
			<div class="swiper-slide">
				<?php if($v['type'] == 1):?>
				<div class="image link-item" data-url="<?php echo U($v['target'].'/'.$v['targetId']);?>" style="background-image: url('<?php echo ($v["file"]); ?>')"></div>
				<?php elseif ($v['type'] == 2):?>
				<div class="video" data-file="<?php echo ($v["file"]); ?>" style="background-image: url('<?php echo ($v["file"]); ?>?x-oss-process=video/snapshot,t_1000')">
					<img src="/public/assets/img/icon_play.png" />
				</div>
				<?php endif;?>
			</div>
			<?php endforeach;?>
		</div>
	</div>
</div><!-- //轮播 -->
<?php endif;?>

<?php if($data['hot_country']):?>

<div class="card hot-country">
	<div class="card-title"><?php echo ($data["lang"]["HOT_COUNTRY"]); ?></div>
	<div class="card-body">
		<?php foreach ($data['hot_country'] as $k => $item):?>
		<div class="card-item">
			<div class="circle-item link-item" style="background-image:url(<?php echo ($item["cover"]); ?>)" data-url="<?php echo U('country/'.$item['id']);?>">
				<span class="txt-name"></span>
			</div>
			<div class="item-name"><?php echo ($item["name"]); ?></div>
			<div class="item-flag"><?php echo ($item["intro"]); ?></div>
		</div>
		<?php endforeach;?>
	</div>
</div><!-- //热门国家 -->

<?php endif;?>

<?php if($data['hot_city']):?>

<div class="card hot-city">
	<div class="card-title"><?php echo ($data["lang"]["HOT_CITY"]); ?></div>
	<div class="card-body">
		<?php foreach ($data['hot_city'] as $k => $item):?>
		<div class="card-item">
			<div class="circle-item link-item" style="background-image:url(<?php echo ($item["cover"]); ?>)" data-url="<?php echo U('city/'.$item['id']);?>">
				<span class="txt-name"></span>
			</div>
			<div class="item-name"><?php echo ($item["name"]); ?></div>
		</div>
        <?php endforeach;?>
	</div>
</div><!-- //热门城市 -->
<?php endif;?>

<?php if($data['hot_buildings']):?>
<div class="card hot-buildings">
	<div class="card-title"><?php echo ($data["lang"]["BEST_BUILDINGS"]); ?></div>
	<div class="card-body">
		<?php foreach ($data['hot_buildings'] as $k => $item):?>
		<div class="building-item link-item" data-url="<?php echo U('building/'.$item['id']);?>">
			<div class="building-cover" style="background-image:url(<?php echo ($item["cover"]); ?>)">
				<?php if($item['tag']):?>
				<span class="building-tag"><?php echo ($item["tag"]); ?></span>
				<?php endif;?>
			</div>
			<div class="building-info">
				<div class="building-name"><span><?php echo ($item["name"]); ?></span></div>
				<div class="building-location"><span><?php echo ($item["location"]); ?></span></div>
				<div class="building-price"><span><?php echo ($item["price"]); ?></span><span class="sp"><?php echo ($data["lang"]["SP"]); ?></span></div>
				<button class="btn"><?php echo ($data["lang"]["VIEW_MORE"]); ?></button>
			</div>
		</div>
        <?php endforeach;?>
	</div>
</div><!-- //精品楼盘 -->

<?php endif;?>

<script type="text/javascript">var module = "<?php echo ($data["js_module"]); ?>";</script>
<?php build_js(isset($data['js']) ? $data['js'] : '')?>
</body>
</html>