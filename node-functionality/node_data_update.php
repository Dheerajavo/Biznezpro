<?php

function update_node_data(){
    global $wpdb;

}
add_action('wp_ajax_get_node_data', 'handle_get_node_data');
add_action('wp_ajax_nopriv_get_node_data', 'handle_get_node_data');