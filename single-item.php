<?php include 'header.php' ?>
<article class="item-article">
	<div class="container item-container">
		<div class="breadcrubs">
			<a href="#" class="ic-arrow-right breadcrubs-element">Главная</a>
			<a href="#" class="ic-arrow-right breadcrubs-element">Спальня и прихожая</a>
			<a href="#" class="ic-arrow-right breadcrubs-element breadcrubs-element-current">Hammarn</a>
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

			<div class="si-main-content-wp">
				<div class="si-main-content-container">
					<div class="si-main-content">
						<div class="si-article"><span>Артикул</span>302.130.76</div>
						<h1 class="si-title">Massangeana</h1>
						<h2 class="si-subheader">Диван раскладной, Knis темно-серый, черный</h2>
						<div class="item-card-price-wp si-item-card-price-wp">
							<div class="item-card-price">11 599<span>&#8372;</span></div>
							<div class="item-card-price item-card-price-sale">13 891<span>&#8372;</span></div>
						</div>
					</div>
		
					<form action="/" class="si-form" method="POST"
						@submit.prevent="addToCart(
							{
								233:{
									img: '../img/demo/item.png',
                	    			title: 'Massangeana',
                	    			header: 'Диван розкладной. Серебро. Бронза. Золото.',
                	    			price: 150,
                	    			count: 103,
								}
							}
						)"
					>
	
						<input type="hidden" name="id" value="233">
						<input type="hidden" name="title" value="Messangenta">
						<input type="hidden" name="header" value="Диван раскладной, Knis темно-серый, черный">
						<input type="hidden" name="price" value="150">
	
						<div class="si-form-row">
							<div class="form-count-row">
								<div class="input-header form-count-title">Количество:</div>
								<qtcounter/>
							</div>
						</div>
		
						<div class="si-form-row" v-if="optionsData">
							<div class="input-wp input-select-wp">
								<select v-model="pageSlug" name="options" class="ss-select" required id="ssselect">
									<option data-placeholder="true">Пл</option>
								</select>
							</div>
						</div>
		
						<button class="btn btn-row ic-cart-add" v-if="!itemInCart('124')" type="submit">Добавить в корзину</button>
						<div class="btn btn-row add-to-cart-btn add-to-cart-btn-disable" v-else="">Товар уже в корзине</div>
						
						<div class="form_tnx">
							<div class="form_tnx_header">Товар добавлен в корзину</div>
							<div class="form_tnx_subheader">
								Откройте корзину, чтобы перейти к заказу или удалить товар з корзины
							</div>
							<button type="button" @click="modal('cart')" class="btn sm btn-white form_tnx_btn">Открыть корзину</button>
						</div>
	
					</form>
				</div>
			</div>	

		</div>
	</div>
</article>
<article class="si-tabs-article">
	<div class="container si-tabs-contaioner">
		<div class="si-tab-header-pc-wp">
			<button @click="siTab=1" :class="{active:siTab==1}" class="btn sm btn-white si-tab-header si-tab-header-pc" type="button">Описание и размеры</button>
			<button @click="siTab=2" :class="{active:siTab==2}" class="btn sm btn-white si-tab-header si-tab-header-pc" type="button">Инструкции по сборке</button>
			<button @click="siTab=3" :class="{active:siTab==3}" class="btn sm btn-white si-tab-header si-tab-header-pc" type="button">И еще</button>
			<button @click="siTab=4" :class="{active:siTab==4}" class="btn sm btn-white si-tab-header si-tab-header-pc" type="button">Полезно знать</button>
		</div>
		<div class="si-tabs">

			<div class="si-tab" :class="{active:siTab==1}">
				<button type="button" @click="siTab=1" class="si-tab-btn si-tab-header ic-arrow-down">Описание и размеры</button>
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

			<div class="si-tab" :class="{active:siTab==2}">
				<button type="button" @click="siTab=2" class="si-tab-btn si-tab-header ic-arrow-down">Полезно знать</button>
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

			<div class="si-tab" :class="{active:siTab==3}">
				<button type="button" @click="siTab=3" class="si-tab-btn si-tab-header ic-arrow-down">Упаковка и инструкции</button>
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

			<div class="si-tab" :class="{active:siTab==4}">
				<button type="button" @click="siTab=4" class="si-tab-btn si-tab-header ic-arrow-down">Что-либо еще</button>
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