</main>
<footer id="footer">
    <div class="container footer-container">
		<h2 class="container-header">Контакты</h2>
		<div class="footer-content-wp">
			
			<div class="footer-box">
				<div class="contacts-box">
					<div class="contacts-box-icon ic-pin"></div>
					<div class="contact-row">
						<div class="contact-link">Улица Под Дубом 7Б,<br>Львов, Львовская область,<br>79000</div>
					</div>
				</div>
				<div class="contacts-box">
					<div class="contacts-box-icon ic-phone"></div>
					<div class="contact-row">
						<a href="#" target="_blank" class="contact-link">+380 (99) <span>560 38 80</span></a>
					</div>
					<div class="contact-row">
						<a href="#" target="_blank" class="contact-link">+380 (99) <span>560 38 80</span></a>
					</div>
				</div>
				<div class="contacts-box">
					<div class="contacts-box-icon ic-mail"></div>
					<div class="contact-row">
						<a href="#" target="_blank" class="contact-link">leoikea@gmail.com</a>
					</div>
				</div>
			</div>

			<div class="footer-box">
				<ul class="footer-menu">
					<li><a href="#">Политика конфиденциальности</a></li>
					<li><a href="#">Оплата и доставка</a></li>
					<li><a href="#">Вопросы и ответы</a></li>
				</ul>
			</div>

			<div class="footer-box footer-box-bnts-wp">
				<a href="#" target="blank" class="btn btn-sm ic-facebook">Фейсбук</a>
				<a href="#" target="blank" class="btn btn-sm ic-instagram">Инстаграм</a>
			</div>

		</div>
    </div>
</footer>
<div class="copyright">
	<div class="container copyright-container">
		<div class="copyright-text">&copy; <?=date('Y')?> leoIkea — доставка товаров из Икеа</div>
	</div>
</div>

<v-modal ref="search" name="search">
    <div class="search-container">
        <form class="search-form" action="/" method="get">
            <div class="input-wp search-form-input-wp">
                <input type="text" v-model="searchString" name="query" class="search-form-input" required>
                <label>Введите фразу для поиска...</label>
                <button class="btn ic-close search-reset-btn" type="reset"></button>
            </div>
            <button class="btn btn-row">Поиск</button>
        </form>
        <div class="search-queries-wp">
            <h3 class="search-queries-header">Популярные запросы</h3>
            <div class="search-query-wp">
                <span class="search-query-icon ic-magnifier"></span>
                <a href="#" class="search-query">Шафа</a>
            </div>
            <div class="search-query-wp">
                <span class="search-query-icon ic-magnifier"></span>
                <a href="#" class="search-query">Стіл</a>
            </div>
            <div class="search-query-wp">
                <span class="search-query-icon ic-magnifier"></span>
                <a href="#" class="search-query">Mehham Adi</a>
            </div>
        </div>
    </div>
</v-modal>

<v-modal ref="booking" name="booking">
	<form class="booking-form" action="/" method="get" id="booking-form" @submit.prevent="ajaxForm('booking',$event)">
		<div class="container-header">
			Оформить заказ
		</div>
		<input type="hidden" name="cart" :value="getCartJson()">
	    <div class="input-wp">
	        <input type="text" name="fio" required>
	        <label>Имя и Фамилия</label>
	    </div>
	    <div class="input-wp">
	        <input type="text" name="phone" required>
	        <label>Номер телефона</label>
	    </div>
	    <div class="input-wp">
	        <input type="text" name="city" required>
	        <label>Город</label>
	    </div>
	    <div class="input-wp">
	        <input type="text" name="number" required>
	        <label>Номер отделения</label>
	    </div>
	    <div class="input-wp">
	        <textarea name="msg"></textarea>
	        <label>Комментарий к заказу</label>
	    </div>
	    <button class="btn btn-row">Зказать</button>
	</form>
</v-modal>

<v-modal ref="tnx" name="tnx">
	<div class="modal-tnx-container">
		<div class="modal-tnx-icon ic-cart"></div>
		<div class="modal-tnx-header">Благодарим за заказ!</div>
		<div class="modal-tnx-subheader">Наши менеджеры свяжутся<br>с вами в ближайшее время</div>
		<a href="../catalog" class="btn sm">В каталог</a>
	</div>
</v-modal>

<v-modal ref="cart" name="cart">
	<div class="container-header">Моя корзина</div>
	<v-cart ref="cartItems" />
</v-modal>

</div> <!-- #APP  -->

<?php include('components/modal.php') ?>
<?php include('components/cart.php') ?>
<?php include('components/cart-item.php') ?>
<?php include('components/qtcounter.php') ?>

<!-- ---------------------------------- SCRIPTS ----------------------------------- -->


<script type="text/javascript" src="../js/vue.js?ver=1.1"></script>

<script type="text/javascript" src="../js/slimselect.js?ver=1.1"></script>
<script type="text/javascript" src="../js/scripts.js?ver=1.1"></script>

<script type="text/javascript" src="../js/swiper.min.js?ver=1.1"></script>

<script>
try {
	var swiper = new Swiper('.our-clients-slider', {
		slidesPerView: 7,
		slidesPerColumn: 2,
		spaceBetween: 16,
		pagination: {
		  el: '.swiper-pagination',
		  clickable: true,
		},
		breakpoints: {
			1400: {
				slidesPerView: 6,
				spaceBetween: 10,
			},
			980: {
				slidesPerView: 4,
				spaceBetween: 8,
			},
			420: {
				slidesPerView: 2,
				spaceBetween: 8,
			},
		},
	});
} catch {
	console.log('.our-clients-slider is empty');
}

try {
	var swiper = new Swiper('.feedback-slider', {
		slidesPerView: 'auto',
      	// centeredSlides: false,
		spaceBetween: 10,
		pagination: {
		  el: '.swiper-pagination',
		  clickable: true,
		},
		breakpoints: {
			980: {
				// slidesPerView: 3,
				// centeredSlides: true,
			},
			420: {
				// slidesPerView: 1,
				// centeredSlides: true,
			},
		},
	});
} catch {
	console.log('.feedback-slider is empty');
}

var itemSlirers = document.querySelectorAll('.items-slider');
if (itemSlirers) {
	for (slider in itemSlirers) {
		try {
			new Swiper(itemSlirers[slider], {
				slidesPerView: 'auto',
				spaceBetween: 10,
				pagination: {
				  el: '.swiper-pagination',
				  clickable: true,
				},
			});
		} catch {
			console.warn('.items-slider is empty');
		}
	}
}

try {
	var siThumbs = new Swiper('.si-thumbs', {
		spaceBetween: 8,
		slidesPerView: 'auto',
 		watchSlidesVisibility: true,
    });

	var swiper = new Swiper('.si-slider', {
		slidesPerView: 'auto',
      	centeredSlides: true,
		spaceBetween: 5,
		thumbs: {
			swiper: siThumbs,
		},
	});
} catch {
	console.log('.feedback-slider is empty');
}
</script>

<script type="text/javascript">


//var sSelects = document.querySelectorAll('.ss-select');
//if (sSelects) {
//	for (sSelect in sSelects) {
//		try {
//			new SlimSelect({
//				select: sSelects[sSelect],
//				closeOnSelect: true,
//				showSearch: false,
//				valuesUseText: true,
//				showContent: 'down',
//				onChange: (info) => {
//				    console.log(info);
//				},
//				valuesUseText: false, // Use text instead of innerHTML for selected values - default false
//				data: [
//				  {innerHTML: '<span>цвет:</span>Bold Text', text: 'Цвет', value: 'bold text1'},
//				  {innerHTML: '<span>размер:</span>Bold Text', text: 'Размер', value: 'bold text2'},
//				  {innerHTML: '<span>Реечное дно кровати:</span>Bold Text', text: 'Дно кровати', value: 'bold text3'},
//				  {innerHTML: '<span>цвет:</span>Bold Text', text: 'Парам', value: 'bold text4'},
//				],
//			})
//		} catch {
//			console.warn('SlimSelect is not ready');
//		}
//	}
//}
</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-142259808-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-142259808-1');
</script>

<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '353791068615877');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=353791068615877&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////// CODE BY WYLE.STUDIO | https://wyle.studio ////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

</body>
</html>