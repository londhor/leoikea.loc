<?php  
require_once('../../../../../wp-load.php');
if ($_POST['id']) {

	$loop = array(
        'post_type' => 'item',
        'post__in' => array($_POST['id']),
    );
    $loop = new WP_Query( $loop );

	if ($loop->have_posts()) :
   		while($loop->have_posts()) : $loop->the_post();

        $new_data['id'] = $_POST['id'];

   			$img = get_field('img');
   			if ($img) {
   				$new_data['img'] = $img[0]['sizes']['item'];
   			}

        if ($_POST['size']) {
          $size = get_term($_POST['size'], 'item-size');  
          $new_data['size'] = $size->name;
        } 

        if ($_POST['color']) {
   				$color = get_term($_POST['color'], 'item-color');	
   				$new_data['color'] = $color->name;
   			}

   			if (isset($_POST['count']) && $_POST['count'] !=null) {
   				$new_data['count']	= $_POST['count'];
   			} else {
   				$new_data['count'] = 1;
   			}

   			$new_data['name'] = get_the_title();
   			$new_data['link'] = get_the_permalink();

        $price = get_field('price');
        if ($price) {
          $new_data['price'] = $price;
        }


        $new_data['pricetoshow'] = $price;


    	endwhile;
	endif;
}

print_r(json_encode($new_data));
?>