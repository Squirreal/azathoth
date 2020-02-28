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

<div class="country-info">
	<div class="flag" style="background-image:url(<?php echo ($data["info"]["national_flag"]); ?>)"></div>
	<div>
		<div class="country-name"><?php echo ($data["info"]["name"]); ?></div>
		<div class="country-meta">
			<div>
				<div><?php echo ($data["lang"]["POPULATION"]); ?>：<?php echo ($data["info"]["population"]); ?></div>
				<div><?php echo ($data["lang"]["CURRENCY"]); ?>：<?php echo ($data["info"]["currency"]); ?></div>
			</div>
			<div style="margin-left:12px">
				<div><?php echo ($data["lang"]["AREA"]); ?>：<?php echo ($data["info"]["area"]); ?></div>
				<div><?php echo ($data["lang"]["EXCHANGE_RATE"]); ?>：<?php echo ($data["info"]["exchange_rate"]); ?></div>
			</div>
		</div>
	</div>
</div><!-- //国家详情 -->

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
		<div class="swiper-pagination"></div>
	</div>
</div><!-- //轮播 -->
<?php endif;?>

<?php if($data['hot_city']):?>
<div class="section">
	<div class="section-title"><?php echo ($data["lang"]["HOT_CITY"]); ?></div>
	<div class="section-body">
		<div class="scroll-box">
			<div class="hot-city">
				<?php foreach ($data['hot_city'] as $k => $item):?>
				<div class="city-item link-item" style="background-image:url(<?php echo ($item["cover"]); ?>)" data-url="<?php echo U('city/'.$item['id']);?>">
					<div class="city-name"><?php echo ($item["name"]); ?></div>
				</div>
                <?php endforeach;?>
			</div>
		</div>
	</div>
</div><!-- //热门城市 -->
<?php endif;?>

<?php if($data['info']['feature']):?>

<div class="section feature">
	<div class="section-title"><?php echo ($data["lang"]["IMMIGRATION_POLICY"]); ?></div>
	<div class="section-body">
		<div><?php echo ($data["info"]["feature"]); ?></div>
	</div>
</div>

<?php endif;?>

<?php if($data['info']['name']):?>

<div class="section">
	<div class="section-title"><?php echo ($data["lang"]["ECONOMIC_PROFILE"]); ?></div>
	<div class="section-body">
		<div class="economy-item">
			<span>GDP</span>
			<span><?php echo ($data["info"]["gdp"]); ?></span>
		</div>
		<div class="economy-item">
			<span><?php echo ($data["lang"]["GDP_PER_CAPITA"]); ?></span>
			<span><?php echo ($data["info"]["gdp_per_capita"]); ?></span>
		</div>
		<div class="economy-item">
			<span><?php echo ($data["lang"]["GDP_GROWTH"]); ?></span>
			<span><?php echo ($data["info"]["gdp_growth"]); ?></span>
		</div>
	</div>
</div><!-- //经济概况 -->

<?php endif;?>

<?php if($data['buildings']):?>
<div class="section buildings">
    <div class="section-title"><?php echo ($data["lang"]["RELATED_BUILDINGS"]); ?></div>
    <div class="section-body">
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