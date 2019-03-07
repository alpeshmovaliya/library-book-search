<?php

$html = "";

$html .= '<div class="wrapper">';
$html .= '<div class="book_form">';
$html .= '<h1>Book Search <button class="reset_data">RESET</button></h1>';
$html .= '<form class="search_book" name="search_book" id="search_book" action="" method="POST">';

$html .= '<div class="row">';
$html .= '<div class="col-xs-6"><label>Book Name : </label><input type="text" name="book_name" id="book_name" value=""></div>';

$author_terms = get_terms([
    'taxonomy' => 'book_author',
    'hide_empty' => false,
        ]);
$html .= '<div class="col-xs-6"><label>Author : </label>
    <select name="book_author" id="book_author"><option value="">--</option>';
foreach ($author_terms as $at) {
    $html .= '<option value="' . $at->term_id . '">' . $at->name . '</option>';
}
$html .= '</select></div>';
$html .= '</div>';

$html .= '<div class="row">';

$publisher_terms = get_terms([
    'taxonomy' => 'publisher',
    'hide_empty' => true,
        ]);
$html .= '<div class="col-xs-6"><label>Publisher : </label>
    <select name="book_publisher" id="book_publisher">
        <option value="">--</option>';
foreach ($publisher_terms as $pt) {
    $html .= '<option value="' . $pt->term_id . '">' . $pt->name . '</option>';
}
$html .= '</select></div>';
$html .= '<div class="col-xs-6"><label>Rating (1-5) : </label>
    <select name="book_rating" id="book_rating">
        <option value="">--</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select></div>';
$html .= '</div>';

$html .= '<label>Price ($1-$3000) : </label>';
$html .= '<input type="text" id="book_price" readonly style="border:0; color:#f6931f; font-weight:bold;"><div id="slider-range"></div>';
$html .= '<input type="hidden" name="start_price" id="start_price" value="1">';
$html .= '<input type="hidden" name="end_price" id="end_price" value="3000">';
$html .= '<div class="row">';
$html .= '<div class="col-xs-6"><input type="button" name="book_search_btn" id="book_search_btn" value="Search"></div>';
$html .= '<div class="col-xs-6"><img class="ajax_loader_image" src="'.plugins_url( 'images/ajax-loader.gif', __FILE__ ).'"></div>';
$html .= '</div>';
$html .= '</form>';

$wpb_all_query = new WP_Query(array('post_type' => 'book', 'post_status' => 'publish', 'posts_per_page' => get_option('posts_per_page')));
$html .= '<table class="table" id="table">';
$html .= '<thead><tr><th>No</th><th>Book Name</th><th>Price</th><th>Author</th><th>Publisher</th><th>Rating</th></tr></thead><tbody>';
$l = 1;
foreach ($wpb_all_query->posts as $post) {
    $html .= '<tr>';
    $html .= '<td>' . $l . '</td>';
    $html .= '<td><a href="'.  get_permalink($post->ID).'">' . $post->post_title . '</a></td>';
    $html .= '<td>$' . get_post_meta($post->ID, 'book_price', true) . '</td>';

    $term_list_author = wp_get_post_terms($post->ID, 'book_author');
    $au_list = "";
    $a=0;
    foreach ($term_list_author as $au){
        if($a!=0){ $au_list .= ", "; }
        $au_list .= '<a href="'.get_term_link($au).'">'.$au->name.'</a>';
        $a++;
    }
    $html .= '<td>' . $au_list . '</td>';

    $term_list_publisher = wp_get_post_terms($post->ID, 'publisher');
    $pu_list = "";
    $p=0;
    foreach ($term_list_publisher as $pu){
        if($p!=0){ $pu_list .= ", "; }
        $pu_list .= '<a href="'.get_term_link($pu).'">'.$pu->name.'</a>';
        $p++;
    }
    $html .= '<td>' . $pu_list . '</td>';

    //$html .= '<td>' . get_post_meta($post->ID, 'book_review', true) . '</td>';

    $rev_cnt = get_post_meta($post->ID, 'book_review', true);
    $rem_rev_cnt = 5 - $rev_cnt;

    $html .= '<td>';
    for($i=0; $i<$rev_cnt; $i++){
        $html .= '<img src="'.plugins_url( 'images/star_black.png', __FILE__ ).'">';
    }
    for($i=0; $i<$rem_rev_cnt; $i++){
        $html .= '<img src="'.plugins_url( 'images/star_normal.png', __FILE__ ).'">';
    }
    $html .= '</td>';

    $html .= '</tr>';

    $l++;
}
$html .= '</tbody></table>';
//echo "<pre>";
//print_r($wpb_all_query->posts);
//echo "</pre>";
//exit;

$html .= '</div>';
$html .= '</div>';

return $html;
?>