<?php include 'header.php' ?>
<article class="page-article">
	<div class="container page-container">
		<h1 class="container-header">Столи, столи, стільці та лавки</h1>
		<div class="product-grid">
			<?php $i=0; while ($i<25):
		       	include 'view/item-card.php';
		    $i++; endwhile; ?>
		</div>
		<div class="pagination-wp">
			<button class="pagi-btn pagi-btn-prev ic-icon"></button>
			<button class="pagi-btn">1</button>
			<button class="pagi-btn pagi-btn-active">2</button>
			<button class="pagi-btn">3</button>
			<button class="pagi-btn">4</button>
			<button class="pagi-btn">5</button>
			<button class="pagi-btn pagi-btn-next ic-icon"></button>
		</div>
	</div>
</article>
<?php include 'footer.php' ?>