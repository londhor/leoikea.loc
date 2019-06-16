<article class="hero-article">
	<div class="container hero-container">
		<div class="hero-illustration"></div>
		<div class="hero-content">
			<div class="hero-header">
				Быстрая доставка<br>товаров с&nbsp;Икея
			</div>
			<div class="hero-subheader">
				Отправка в день заказа. За необходимости доставим прямо под двери. 
			</div>
			<a href="../page-catalog.php" class="btn btn-row btn-white">В каталог</a>
		</div>
	</div>
</article>

<article class="container">
	<h2 class="container-header">
		Почему стоить заказывать достаку товаров из Икея у нас
	</h2>
	<div class="our-advantages-container">

		<div class="our-advantage-row">
			<div class="our-advantage-num">1</div>
			<div class="our-advantage-icon ic-ben-1"></div>
			<div class="our-advantage-text">
				Быстрая доставка
			</div>
		</div>

		<div class="our-advantage-row">
			<div class="our-advantage-num">2</div>
			<div class="our-advantage-icon ic-ben-2"></div>
			<div class="our-advantage-text">
				Большой асортимент товаров на складе
			</div>
		</div>

		<div class="our-advantage-row">
			<div class="our-advantage-num">3</div>
			<div class="our-advantage-icon ic-ben-3"></div>
			<div class="our-advantage-text">
				Более 800 позитивных отзывов в социальных сетях
			</div>
		</div>
		
		<div class="our-advantage-row">
			<div class="our-advantage-num">4</div>
			<div class="our-advantage-icon ic-ben-4"></div>
			<div class="our-advantage-text">
				Более 80.000 отправок
			</div>
		</div>

		<div class="our-advantage-row">
			<div class="our-advantage-num">5</div>
			<div class="our-advantage-icon ic-ben-5"></div>
			<div class="our-advantage-text">
				Большой асортимент на сайте и в соцсетях
			</div>
		</div>

		<div class="our-advantage-row">
			<div class="our-advantage-num">6</div>
			<div class="our-advantage-icon ic-ben-6"></div>
			<div class="our-advantage-text">
				Скидки и акции
			</div>
		</div>

		<div class="our-advantage-row">
			<div class="our-advantage-num">7</div>
			<div class="our-advantage-icon ic-ben-7"></div>
			<div class="our-advantage-text">
				Работаем с корпоративными клиентами
			</div>
		</div>

	</div>
</article>

<article>
	<div class="container">
		<h2 class="container-header">Нам доверяют</h2>
		<div class="swiper-container our-clients-slider">
		    <!-- Additional required wrapper -->
		    <div class="swiper-wrapper">
				<?php $i=0; while ($i<14): ?>
		        <div class="swiper-slide card coub our-clients-slide">
		        	<img src="img/demo/client.png">
		        </div>
		        <?php $i++; endwhile; ?>
		    </div>
		    
		    <div class="swiper-pagination"></div>
		</div>
	</div>
</article>

<article class="feedback-article">
	<div class="container">
		<h2 class="container-header">Отзывы наших клиентов</h2>
		<div class="swiper-container feedback-slider">
		    <!-- Additional required wrapper -->
		    <div class="swiper-wrapper">
		    <?php $i=0; while ($i<8): ?>
		    	<div class="swiper-slide coub coub-16n9 feedback-slide">
		    		<img class="card" src="img/demo/img-dark.jpg">
		    	</div>
		    <?php $i++; endwhile; ?>
		    </div>
		    <div class="swiper-pagination"></div>
		</div>
	</div>
</article>

<?php include 'view/item-carousel.php'; ?>
<?php include 'view/item-carousel.php'; ?>