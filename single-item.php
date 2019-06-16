<?php include 'header.php' ?>
<article class="item-article">
	<div class="container item-container">
		<div class="breadcrubs">
			<a href="#" class="ic-icon breadcrubs-element">Главная</a>
			<a href="#" class="ic-icon breadcrubs-element">Спальня и прихожая</a>
			<a href="#" class="ic-icon breadcrubs-element breadcrubs-element-current">Hammarn</a>
		</div>

		<div class="single-item-content-container">

			<div class="si-slider-container">
				<div class="swiper-container si-slider">
				    <!-- Additional required wrapper -->
				    <div class="swiper-wrapper">
				    <?php $i=0; while ($i<5): ?>
				    	<div class="swiper-slide card coub si-slide">
				    		<img src="img/demo/item-big.jpg">
				    	</div>
				    <?php $i++; endwhile; ?>
				    </div>
				</div>
				<!-- si-thumbs если картинок более чем 1 шт -->
				<div class="swiper-container si-thumbs">
					<div class="swiper-wrapper">
				   		<?php $i=0; while ($i<5): ?>
				   			<div class="swiper-slide card coub si-thumb">
				   				<img src="img/demo/item-big.jpg">
				   			</div>
				   		<?php $i++; endwhile; ?>
					</div>
				</div>
			</div>

			<div class="si-main-content">
				<div class="si-article"><span>Артикул</span>302.130.76</div>
				<h1 class="si-title">Massangeana</h1>
				<h2 class="si-subheader">Диван раскладной, Knis темно-серый, черный</h2>
				<div class="item-card-price-wp si-item-card-price-wp">
					<div class="item-card-price">11 599<span>&#8372;</span></div>
					<div class="item-card-price item-card-price-sale">13 891<span>&#8372;</span></div>
				</div>
			</div>

			<form action="/" class="si-form" method="POST">

				<div class="si-form-row">
					<div class="form-count-row">
						<div class="input-header form-count-title">Количество:</div>
						<div class="input-count-box">
							<button type="button" class="form-count-btn ic-cart minus"></button>
							<div class="form-count-wp" data-text="шт.">
								<input type="text" value="1" class="form-count" required>
							</div>
							<button type="button" class="form-count-btn ic-cart plus"></button>
						</div>
					</div>
				</div>

				<div class="si-form-row">
					<div class="input-wp input-select-wp">
						<select class="ss-select" required></select>
					</div>
				</div>

				<button class="btn btn-row ic-cart-add" type="submit">Добавить в корзину</button>
			</form>

		</div>

	</div>
</article>
<article class="si-tabs-article">
	<div class="container si-tabs-contaioner">
		<div class="si-tabs">

			<div class="si-tab active">
				<button type="button" class="si-tab-btn si-tab-header ic-icon">Описание и размеры</button>
				<div class="content si-tab-container">
					<!-- HARDCODE field 'info' -->
					<div class="prodInfoLeft">
						<div id="productDimensionsContainer">		
							<div id="measuresPart" class="productInformation prodInfoSub" style="display:block; margin-top:0 ! important;">
								<div id="assembledSize" class="productsubheadline" role="heading" aria-level="3">Главная информация</div>
								<div id="imperial" class="texts" style="display:none">					</div>
								<div id="metric" class="texts" style="display:block">
									Длина: 209 см<br>Ширина: 105 см<br>Высота изножья: 38 см / 100 см<br>Длина. матраса: 200 см<br>Ширина матраса: 90 см<br><	br>	
								</div>
								<div id="requiresAssembly" class="imagetext" style="display:block">	
									<span class="subTxt">Продукт требует сборки</span><div class="clear"></div>
								</div>		
							</div>
						</div>
						<div id="dessection_right" style="display:block">
							<div id="designDiv_right" class="productsubheadline" role="heading" aria-level="3"> Проект:</div>
							<div id="designer_right" class="texts"> Ева Лиля Löwenhielm</div>
						</div>
					</div>
					<!-- END of HARDCODE field 'info' -->
				</div>
			</div>

			<div class="si-tab">
				<button type="button" class="si-tab-btn si-tab-header ic-icon">Полезно знать</button>
				<div class="content si-tab-container">

					<div class="doc-table">
						<div class="doc-row">
							<div class="doc-title">HOLMSUND pokrycie sofy 3 osobowej rozkładane</div>
							<div class="doc-link-td"><a href="#3" target="blank">Смотреть документацию</a></div>
						</div>
						<div class="doc-row">
							<div class="doc-title">Lorem ipsum dolor.</div>
							<div class="doc-link-td"><a href="#3" target="blank">Смотреть документацию</a></div>
						</div>
						<div class="doc-row">
							<div class="doc-title">Lorem ipsum dolor sit amet.</div>
							<div class="doc-link-td"><a href="#3" target="blank">Смотреть документацию</a></div>
						</div>
						<div class="doc-row">
							<div class="doc-title">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</div>
							<div class="doc-link-td"><a href="#3" target="blank">Смотреть документацию</a></div>
						</div>
					</div>

				</div>
			</div>

			<div class="si-tab">
				<button type="button" class="si-tab-btn si-tab-header ic-icon">Упаковка и инструкции</button>
				<div class="content si-tab-container">
					<!-- HARDCODE field 'info' -->
					<div class="prodInfoLeft">
						<div id="productDimensionsContainer">		
							<div id="measuresPart" class="productInformation prodInfoSub" style="display:block; margin-top:0 ! important;">
								<div id="assembledSize" class="productsubheadline" role="heading" aria-level="3">Главная информация</div>
								<div id="imperial" class="texts" style="display:none">					</div>
								<div id="metric" class="texts" style="display:block">
									Длина: 209 см<br>Ширина: 105 см<br>Высота изножья: 38 см / 100 см<br>Длина. матраса: 200 см<br>Ширина матраса: 90 см<br><	br>	
								</div>
								<div id="requiresAssembly" class="imagetext" style="display:block">	
									<span class="subTxt">Продукт требует сборки</span><div class="clear"></div>
								</div>		
							</div>
						</div>
						<div id="dessection_right" style="display:block">
							<div id="designDiv_right" class="productsubheadline" role="heading" aria-level="3"> Проект:</div>
							<div id="designer_right" class="texts"> Ева Лиля Löwenhielm</div>
						</div>
					</div>
					<!-- END of HARDCODE field 'info' -->
				</div>
			</div>

			<div class="si-tab">
				<button type="button" class="si-tab-btn si-tab-header ic-icon">Что-либо еще</button>
				<div class="content si-tab-container">
					<!-- HARDCODE field 'info' -->
					<div class="prodInfoLeft">
						<div id="productDimensionsContainer">		
							<div id="measuresPart" class="productInformation prodInfoSub" style="display:block; margin-top:0 ! important;">
								<div id="assembledSize" class="productsubheadline" role="heading" aria-level="3">Главная информация</div>
								<div id="imperial" class="texts" style="display:none">					</div>
								<div id="metric" class="texts" style="display:block">
									Длина: 209 см<br>Ширина: 105 см<br>Высота изножья: 38 см / 100 см<br>Длина. матраса: 200 см<br>Ширина матраса: 90 см<br><	br>	
								</div>
								<div id="requiresAssembly" class="imagetext" style="display:block">	
									<span class="subTxt">Продукт требует сборки</span><div class="clear"></div>
								</div>		
							</div>
						</div>
						<div id="dessection_right" style="display:block">
							<div id="designDiv_right" class="productsubheadline" role="heading" aria-level="3"> Проект:</div>
							<div id="designer_right" class="texts"> Ева Лиля Löwenhielm</div>
						</div>
					</div>
					<!-- END of HARDCODE field 'info' -->
				</div>
			</div>

		</div><!-- si-tabs -->
	</div>
</article>

<?php include 'view/item-carousel.php' ?>
<?php include 'footer.php' ?>