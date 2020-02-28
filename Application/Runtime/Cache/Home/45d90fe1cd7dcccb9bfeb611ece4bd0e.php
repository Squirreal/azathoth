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

<?php if($data['info']):?>
<div class="section info">
	<div class="section-title">
		<div class="title"><?php echo ($data["info"]["name"]); ?></div>
	</div>
	<div class="section-body">
		<div class="location"><img src="/public/assets/img/icon_location.png" /><span><?php echo ($data["info"]["location"]); ?></span></div>
		<div class="meta">
			<div class="meta-item">
				<span class="meta-title"><?php echo ($data["lang"]["PROPERTY_YEARS"]); ?></span>
				<?php if($data['info']['property_years'] >= 0):?>
				<span class="meta-value"><?php echo ($data["info"]["property_years"]); echo ($data["lang"]["YEAR"]); ?></span>
				<?php endif;?>
				<?php if($data['info']['property_years'] == -1):?>
				<span class="meta-value"><?php echo ($data["lang"]["FOREVER"]); ?></span>
				<?php endif;?>
			</div>
			<div class="meta-item">
				<span class="meta-title"><?php echo ($data["lang"]["DELIVERY_TIME"]); ?></span>
				<span class="meta-value"><?php echo ($data["info"]["delivery_time"]); ?></span>
			</div>
			<div class="meta-item">
				<span class="meta-title"><?php echo ($data["lang"]["PROJECT_STATUS"]); ?></span>
				<span class="meta-value"><?php echo ($data["info"]["project_status"]); ?></span>
			</div>
		</div>
	</div>
</div><!-- //楼盘详情 -->
<?php endif;?>

<div class="section project waypoint" id="project">
	<div class="section-title">
		<span class="title"><?php echo ($data["lang"]["PROJECT_INFO"]); ?></span>
	</div>
	<div class="section-body">
		<div>
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

		<?php if ($data['tags']):?>
		<div class="feature-box">
			<div class="swiper-tags">
				<div class="swiper-container">
					<div class="swiper-wrapper">
						<?php foreach ($data['tags'] as $k => $item):?>
						<div class="swiper-slide">
							<div class="feature-title">
								<?php foreach ($item as $i => $cell):?>
								<div class="title-item <?php echo ($cell["active"]); ?>">
									<div class="icon">
										<img src="<?php echo ($cell["icon"]); ?>" />
									</div>
									<div class="title"><?php echo ($cell["name"]); ?></div>
								</div>
								<?php endforeach;?>
							</div>
							<div class="feature-intro">
                                <?php foreach ($item as $i => $cell):?>
								<div class="intro-item <?php echo ($cell["active"]); ?>">
									<span><?php echo ($cell["intro"]); ?></span>
								</div>
								<?php endforeach;?>
							</div>
						</div>
						<?php endforeach;?>
					</div>
				</div>
			</div>
		</div>
		<?php endif;?>
	</div>
</div><!-- //项目信息 -->

<div class="section process waypoint" id="process">
	<div class="section-title">
		<div class="title"><?php echo ($data["lang"]["BROKER"]); ?></div>
	</div>
	<div class="section-body">
		<div class="process-list">
			<?php foreach($data['process'] as $k => $item):?>
			<?php if($item['type'] == 1):?>
			<img src="<?php echo ($item["file"]); ?>" />
			<?php elseif ($item['type'] == 2):?>
			<video controls="true" src="<?php echo ($item["file"]); ?>" poster="<?php echo ($item["file"]); ?>?x-oss-process=video/snapshot,t_1000"></video>
			<?php endif;?>
			<?php endforeach;?>
		</div>
		<?php if($data['broker']):?>
		<div>
			<div class="broker">
				<div class="broker-info">
					<div class="avatar" style="background-image:url(<?php echo ($data["broker"]["avatar"]); ?>)"></div>
					<div class="info">
						<div class="name"><?php echo ($data["broker"]["name"]); ?></div>
						<span class="intro"></span>
					</div>
				</div>
				<button class="btn-contact"><img src="/public/assets/img/icon_talk.png" class="icon-talk" /></button>

			</div>

			<?php if($data['broker']['languages']):?>
			<div class="broker-item">
				<span><?php echo ($data["lang"]["LANGUAGES"]); ?></span>
				<span class="right"><?php echo ($data["broker"]["languages"]); ?></span>
			</div>
			<?php endif;?>
            <?php if($data['broker']['certificate']):?>
			<div class="broker-item">
				<span><?php echo ($data["lang"]["CERTIFICATE"]); ?></span>
				<span class="right"><?php echo ($data["broker"]["certificate"]); ?></span>
			</div>
            <?php endif;?>
            <?php if($data['broker']['experience']):?>
			<div class="broker-item">
				<span><?php echo ($data["lang"]["INDUSTRY_EXPERIENCE"]); ?></span>
				<span class="right"><?php echo ($data["broker"]["experience"]); ?></span>
			</div>
            <?php endif;?>
            <?php if($data['broker']['education']):?>
			<div class="broker-item">
				<span><?php echo ($data["lang"]["EDUCATION"]); ?></span>
				<span class="right"><?php echo ($data["broker"]["education"]); ?></span>
			</div>
            <?php endif;?>
		</div>
		<?php endif;?>

	</div>
</div><!-- //购房流程 -->

<div class="btn-calc-container">
	<button id="btn-calc" class="btn-calc"><img src="/public/assets/img/icon_calc.svg" /></button>
</div>

<?php if($data['broker']):?>
<div class="borker-fixed">
	<div class="broker-info">
		<div class="avatar" style="background-image:url(<?php echo ($data["broker"]["avatar"]); ?>)"></div>
		<div class="info">
			<div class="name"><?php echo ($data["broker"]["name"]); ?></div>
			<span class="intro"></span>
		</div>
	</div>
	<button class="btn-contact"><?php echo ($data["lang"]["WECHAT"]); ?></button>
</div>
<?php endif;?>

<div class="calc-container" id="calc-container">
	<div class="calc-inner">
		<div class="calc-title"><?php echo ($data["lang"]["LOAN_CALC"]); ?></div>
		<div class="calc-item">
			<div class="left-col"><?php echo ($data["lang"]["PURCHASE_PRICE"]); ?></div>
			<div class="right-col">
				<input placeholder="<?php echo ($data["lang"]["PLEASE_ENTER_PURCHASE_AMOUNT"]); ?>" value="" type="number" id="calc-amount" />
			</div>
		
		</div>
		<div class="calc-item">
			<div class="left-col"><?php echo ($data["lang"]["LOAN_TERM"]); ?></div>
			<div class="right-col">
				<select dir="rtl" id="calc-year">
					<?php foreach($data['loan_year'] as $k => $item):?>
					<option value="<?php echo ($item["year"]); ?>" <?php if($item['year'] == 30):?> selected="selected"<?php endif;?>><?php echo ($item["name"]); ?></option>
					<?php endforeach;?>
				</select>
			</div>
		</div>
		<div class="calc-item">
			<div class="left-col"><?php echo ($data["lang"]["DOWN_PAYMENT"]); ?></div>
			<div class="right-col">
				<input id="calc-payment-ratio" placeholder="<?php echo ($data["lang"]["PLEASE_ENTER_PAYMENT_RATIO"]); ?>" value="<?php echo ($data["info"]["payment_ratio"]); ?>" maxlength="2" type="number" />
				<span>%</span>
			</div>
		</div>
		<div class="calc-item">
			<div class="left-col"><?php echo ($data["lang"]["INTEREST_RATE"]); ?></div>
			<div class="right-col">
				<input id="calc-lending-rate" placeholder="<?php echo ($data["lang"]["PLEASE_ENTER_INTEREST_RATE"]); ?>" value="<?php echo ($data["info"]["lending_rate"]); ?>" maxlength="6" />
				<span>%</span>
			</div>
		</div>
		<div class="calc-actions">
			<button class="btn-confirm"><?php echo ($data["lang"]["START_CALC"]); ?></button>
			<button class="btn-reset"><?php echo ($data["lang"]["RESET"]); ?></button>
		</div>
		<div class="calc-result hide">
			<div class="calc-title"><?php echo ($data["lang"]["result"]); ?></div>
			<div class="calc-item">
				<div class="left-col"><?php echo ($data["lang"]["LOAN_AMOUNT"]); ?></div>
				<div class="right-col" id="calc-result-loan-amount">{{calc.loanAmount}</div>
			</div>
			<div class="calc-item">
				<div class="left-col"><?php echo ($data["lang"]["MONTHLY_MORTGAGE_PAYMENT"]); ?></div>
				<div class="right-col" id="calc-result-monthly-payment">{{calc.monthlyPayment}</div>
			</div>
			<div class="calc-item">
				<div class="left-col"><?php echo ($data["lang"]["ANNUAL_MORTGAGE_PAYMENT"]); ?></div>
				<div class="right-col" id="calc-result-yearly-payment">{{calc.yearlyPayment}</div>
			</div>
		</div>
	</div>
	<div class="btn-close"><?php echo ($data["lang"]["CLOSE"]); ?></div>
</div>

<script type="text/javascript">var module = "<?php echo ($data["js_module"]); ?>";</script>
<?php build_js(isset($data['js']) ? $data['js'] : '')?>
</body>
</html>