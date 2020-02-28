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
		<div class="swiper-pagination"></div>
	</div>
</div><!-- //轮播 -->
<?php endif;?>

<?php if($data['info']['feature']):?>
<div class="section building-intro">
	<div class="section-title"><?php echo ($data["lang"]["CITY_IDENTITY"]); ?></div>
	<div class="section-body">
		<div><?php echo ($data["info"]["feature"]); ?></div>
	</div>
</div>
<?php endif;?>

<?php if($data['info']['building_intro']):?>
<div class="section building-intro">
	<div class="section-title"><?php echo ($data["lang"]["BUILDING_INTRO"]); ?></div>
	<div class="section-body">
		<div><?php echo ($data["info"]["building_intro"]); ?></div>
	</div>
</div>
<?php endif;?>

<?php if($data['presales']):?>
<div class="section presales">
	<div class="section-title"><?php echo ($data["lang"]["PRESALES_LIST"]); ?></div>
	<div class="section-body">
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

		<button class="btn-more link-item" data-url="<?php echo U('city/presales/id/'.$data['id']);?>"><?php echo ($data["lang"]["MORE_INFO"]); ?></button>
	</div>
</div><!-- //楼花转让 -->
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
	    <button class="btn-more link-item" data-url="<?php echo U('city/buildings/id/'.$data['id']);?>"><?php echo ($data["lang"]["MORE_INFO"]); ?></button>
    </div>
</div><!-- //合作楼盘 -->

<?php endif;?>

<script type="text/javascript">var module = "<?php echo ($data["js_module"]); ?>";</script>
<?php build_js(isset($data['js']) ? $data['js'] : '')?>
</body>
</html>