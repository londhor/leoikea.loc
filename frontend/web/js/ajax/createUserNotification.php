<?php  
    require_once('../../../../../wp-load.php');

    $order_id = $_POST['order_id'];

    $data = $wpdb->get_row("SELECT * FROM ct_shop_bookings WHERE id=$order_id", ARRAY_A);
    $cart = json_decode($data['cart']);
?>

<style>
ul {
    list-style-type: none;
}
a {
    display: inline-block;
    text-decoration: none !important;
}
.mail_wp {
    font-family: Tahoma, sans-serif;
    text-align: center;
    width: 100%;
    background-color: #fff;
    font-size: 14px;
    padding-top: 50px;
    padding-bottom: 40px;
}
    .mail_body {
    margin: 0 auto;
    text-align: left;
    max-width: 560px;
}
    .mail_header{
    display: inline-block;
    margin: 0 auto;
    width: 100%;
    text-align: center;
    margin-bottom: 50px;
}
    .mail_logo{
    width: 139px;
}
    .mail_header_text {
    font-weight: 900;
    font-family: Tahoma, sans-serif;
    color: #000;
    margin-bottom: 35px;
    font-size: 16px;
}
    .mail_string {
    margin-bottom: 30px;
    line-height: 1.3;
}
.mail_string.order_info{
    margin-top: 25px;
}
.mail_string span {
    color: #e90000;
}
    .mail_button {
    border: 1px solid #e90000;
    color: #e90000;
    padding: 10px 25px;
    display: inline-block;
    text-transform: uppercase;
}
    .mail_button:hover {
    color: #fff;
    background-color: #e90000;
}
    .mail_info{
    padding: 50px 0;
    border-top: 1px solid #000;
    border-bottom: 1px solid #000;
    margin-top: 25px;
}
    .mail_contacts {}
    .mail_contacts span {
    font-weight: 500;
    color: #000;
    margin-right: 5px;
}
    .mail_contacts a {
    color: #586f7c;
}
    .mail_contacts a:hover {
    color: #e90000;
}
    .mail_contacts .col{
    display: inline-block;
    width: calc(50% - 10px);
    min-width: 140px;
}
</style>

<div class="mail_wp">
	<div class="mail_body">
		<a href="<?=get_home_url()?>" class="mail_header">
			<img src="<?=uri()?>/img/logo.png" class="mail_logo">
		</a>
		<div class="mail_header_text"><?php _e('Thanks for your order');?>!</div>
		<div class="mail_string">
			<?php _e('Congratulations! You just  purchased in our store');?> <span>moonrock.store</span>
		</div>
		<div class="mail_string"><?php _e('YOUR ORDER ID');?>#: <?=$order_id?></div>
		<a href="<?=get_home_url()?>/check/?check=<?=$order_id?>" class="mail_button"><?php _e('track order');?></a>

        <div class="mail_string order_info">
            <?php _e('ORDER INFO');?>:
            <br>
            <?php $i=0; foreach ($cart as $key): ?>
                <div>
                    <a href="<?=$key->link?>" class="bag_name"><?=$key->name?> - <?=$key->count?> <?php _e('pc');?></a>
                </div>
            <?php $i++; endforeach; ?>
        </div>
        <div class="mail_string">
            <div class="check_info_row">
                <div class="check_info_name"><?php _e('Payment method');?>:</div>
                <div class="check_info_value"><?=$data['payment_method']?></div>
            </div>
        </div>
        <div class="mail_string">
            <div class="check_info_row">
                <div class="check_info_name"><?php _e('shippeing method');?>:</div>
                <div class="check_info_value"><?=$data['shipping_method']?></div>
            </div>
        </div>

		<div class="mail_string mail_info">
			<?php _e('The order will be processed automatically');?>.<br>
			<?php _e('Our manager will contact you if necessary');?>.
		</div>
		<div class="mail_string">
			<?php _e('Sincerely yours');?><br>
			<span>moonrock.store</span>
		</div>
		<div class="mail_string mail_contacts">
			<div class="col">
				<?php
					$email = get_field('email', 'option');
					$telegram = get_field('telegram', 'option');
				?>
                <div>
				    <span>Email:</span><a href="mailto:<?=$email?>" target="blank"><?=$email?></a>
                </div>
                <div>
				    <span>Telegram:</span><a href="tg://resolve?domain=<?=$telegram?>" target="blank">@<?=$telegram?></a>
                </div>
			</div>
			<div class="col">
				<?php
            	    wp_nav_menu( array(
            	     'menu'            => 'footer_3',
            	     'container'       => '<ul>', 
            	     'menu_class'      => 'menu footer_menu',
            	     'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
            	    ) );
            	?>
			</div>
		</div>
	</div>
</div>