<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Infinity_Seeker
 */

?>

<article id="post-<?php the_ID(); ?>" class="container container--page">


    <div class="container--page__visuals">
        <a href="<?php the_post_thumbnail_url();?>" class="venobox">
            <?php echo get_the_post_thumbnail( $post_id, 'large' ); ?>
        </a>
    </div>

    <div class="container--page__copy">
        <?php  
            $terms = get_the_terms( $post->ID , 'painting-type' );
            if ( $terms != null ){
            foreach( $terms as $term ) {
                echo '<a href="/painting-type/' . $term->slug . '" class="button button--frame">' . $term->name . '</a>';
                unset($term);
            } } 
        ?>
        
        <h2 class="page-heading"><?php the_title() ?></h2>
        <p><?php the_content() ?></p>

        <a class="venobox button button--text button--text-archive" data-vbtype="inline" title="Buy <?php the_title(); ?>" href="#inline">Buy <?php the_title();?></a>
    </div>
    
</article><!-- #post-<?php the_ID(); ?> -->

<span style="display: none">

<div id="inline">
    
<?php echo do_shortcode('[contact-form-7 id="4731" title="Painting"]');?>
<style>
.vbox-inline {
    width: 50%;
}
form {
    padding: 2rem;
}
label{
    width: 100%;
    font-weight: bold;
}
input[type="submit"]{
    float: right;
    margin-bottom: 3rem;
}
@media screen and (max-width: 767px){
    .vbox-inline {
    width: 100%;
}
}
</style>
</div>

</span>

