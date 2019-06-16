<article>
	<div class="container">
		<h2 class="container-header">Популярные товары</h2>
		<div class="swiper-container items-slider">
		    <!-- Additional required wrapper -->
		    <div class="swiper-wrapper">
				<?php $i=0; while ($i<8):
		        	include 'view/item-card.php';
		    	$i++; endwhile;
		    	include 'view/last-item.php';
		    	?>
		    </div>
		    <div class="swiper-pagination"></div>
		    <a href="#" class="btn">В каталог</a>
		</div>
	</div>
</article>