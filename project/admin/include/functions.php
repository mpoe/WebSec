<?php

function hasAccess($required_level) {
	if (!isset($_SESSION["ar_id"])) {
		return false;
	}
	if ($_SESSION["ar_id"] >= $required_level) {
		return true;
	}
	return false;
}
