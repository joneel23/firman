<?php
/**
 * Text Post Content
 *
 * @since MX 1.0
 */
 global $blog_style, $blog_default_post_with_thumbs;
 
 ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('post-entry animate blog-style-'.(intval($blog_style)+1)); ?> data-effect="fadeInUp" itemscope itemtype="http://schema.org/Article">
	<?php if(intval($blog_style) == 0){ ?>
	<aside class="post-date-type">
    	<div class="date entry-date updated" itemprop="datePublished">
        	<div class="day"><?php echo esc_html( get_the_date('d') ); ?></div>
            <div class="month-year"><?php echo esc_html( get_the_date('M').', '.get_the_date('Y') ); ?></div>
        </div>
    	<div class="post-type"><i class="fa fa-file"></i></div>
    </aside>
	<section class="post-content">
	<?php if($blog_default_post_with_thumbs == "on" && has_post_thumbnail(get_the_ID())) { ?>
	<div class="post-element-content">
	<div class="post-img">
		<a href="<?php echo esc_url(get_permalink()); ?>">
		<?php 
				    echo get_the_post_thumbnail(get_the_ID(), "post-thumbnail" , array('alt' => get_the_title(),'title' => ''));
		$full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); 
				    ?>
		</a>
	    </div>
	</div>
	<?php } ?>
    	<header class="entry-header">
        	<?php the_title( '<h3 class="entry-title" itemprop="name"><a href="' . esc_url( get_permalink() ) . '" itemprop="url">', '</a></h3>' ); ?>
            <div class="entry-meta">
                <?php mx_posted_on(); ?>
            </div>
        </header><!-- .entry-header -->
        <div class="entry-summary" itemprop="articleSection">
		<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
        <?php echo '<a class="more-link btn btn-border" href="'.esc_url( get_permalink() ).'">'.__('Read More','MX').'</a>'; ?>
    </section>
    <?php }else{
		if($blog_default_post_with_thumbs == "on" && has_post_thumbnail(get_the_ID())){
		?>
		<div class="row">
			<aside class="col-md-4 col-sm-6">
				<div class="post-element-content">
				    <div class="post-img">
					    <a href="<?php echo esc_url(get_permalink()); ?>">
					<?php 
							    echo get_the_post_thumbnail(get_the_ID(), "post-thumbnail" , array('alt' => get_the_title(),'title' => ''));
							     $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); 
							    ?>
					</a>
				    </div>
				</div>
			</aside>
			    <section class="post-content col-md-8 col-sm-6">
				    <header class="entry-header">
				    <span class="entry-date"><i class="fa fa-clock-o"></i><a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><time class="entry-date updated" itemprop="datePublished" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></a></span>
				    <?php the_title( '<h3 class="entry-title" itemprop="name"><a href="' . esc_url( get_permalink() ) . '" itemprop="url">', '</a></h3>' ); ?>
				<div class="entry-meta">
				    <?php mx_posted_on(); ?>
				</div>
			    </header><!-- .entry-header -->
			    <div class="entry-summary" itemprop="articleSection">
				    <?php the_excerpt(); ?>
				    </div><!-- .entry-summary -->
			    <?php echo '<a class="more-link btn btn-border" href="'.esc_url( get_permalink() ).'">'.__('Read More','MX').'</a>'; ?>
			</section>
			</div>
		<?php
			
		}else{
	?>
	<section class="post-content">
    	<span class="entry-date"><i class="fa fa-clock-o"></i><a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><time class="entry-date updated" itemprop="datePublished" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></a></span>
    	<header class="entry-header">
        	<?php the_title( '<h3 class="entry-title" itemprop="name"><a href="' . esc_url( get_permalink() ) . '" itemprop="url">', '</a></h3>' ); ?>
            <div class="entry-meta">
                <?php mx_posted_on(); ?>
            </div>
        </header><!-- .entry-header -->
        <div class="entry-summary" itemprop="articleSection">
		<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
        <?php echo '<a class="more-link btn btn-border" href="'.esc_url( get_permalink() ).'">'.__('Read More','MX').'</a>'; ?>
    </section>
    <?php
		}
    
    
    } ?>
</article>