<?php
include'bootstrap.php';

if ($_POST && ajaxCanEdit()) {
	getAndDoAction();
}// if-post