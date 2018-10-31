<?php
//The easiest way to validate email addresses in PHP

function valid_email($email) {
    return !!filter_var($email, FILTER_VALIDATE_EMAIL);
}

function valid_url($url) {
    return !!filter_var($url, FILTER_VALIDATE_URL);
}