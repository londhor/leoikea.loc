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
			<div class="pagi-btn first ic-arrow-left">
				<a href="#"></a>
			</div>
			<div class="pagi-btn">
				<a href="#">1</a>
			</div>
			<div class="pagi-btn active">
				<a href="#">2</a>
			</div>
			<div class="pagi-btn last ic-arrow-right">
				<a href="#"></a>
			</div>
		</div>
	</div>
</article>
<?php include 'footer.php' ?>