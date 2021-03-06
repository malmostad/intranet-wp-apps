<?php get_header(); ?>
<main role="main" class="post">
  <article class="body-copy">
    <?php while (have_posts()): the_post(); ?>

      <h1><?php the_title(); ?></h1>
      <time><?php echo get_the_date() . ' ' . get_the_time() ?></time>
      <p class="preamble"><?php $mb_preamble->the_value('preamble'); ?></p>

      <?php the_content(); ?>

      <?php if ( !!$mb_facts->the_meta() ) { ?>
        <section class="box light facts">
          <h1 class="box-title">Fakta</h1>
          <div class="box-content">
            <?php  $facts = get_post_meta($post->ID, '_metabox_facts', true); echo wpautop($facts['facts']); ?>
          </div>
        </section>
      <?php } ?>

      <?php if ( $mb_links->the_meta() ) : ?>
        <section class="box light read-more">
          <h1 class="box-title">Läs mer</h1>
          <div class="box-content">
            <ul>
              <?php while( $mb_links->have_fields('links')) : ?>
                <li><a href="<?php  $mb_links->the_value('link')  ?>"><?php $mb_links->the_value('title') ?></a></li>
              <?php endwhile; ?>
            </ul>
          </div>
        </section>
      <?php endif; ?>

      <section class="meta">
        <?php get_template_part('author-meta') ?>

        <dl class="entry-meta">
          <dt class="meta-prep meta-prep-tags">Kategorier:</dt>
          <dd>
            <ul>
              <?php $terms = array_merge(wp_get_post_terms($post->ID, 'target'), get_the_category() ); ?>
              <?php foreach( ($terms ) as $term ) { ?>
                <li>
                  <a href="<?php echo bloginfo("url") . '/' . $term->taxonomy . '/' . $term->slug ?>"><?php echo $term->name ?></a><?php if ($term != end($terms)) { echo ","; }?>
                </li>
              <?php } ?>
            </ul>
          </dd>
        </dl>
        <dl class="entry-tags">
          <dt class="meta-prep meta-prep-tags">Etiketter:</dt>
          <dd><ul><?php echo get_the_tag_list('<li>',', </li><li>','</li>'); ?></ul></dd>
        </dl>
        <script>
          var newsTracking = {
            author: "<?php the_author() ?>",
            categories: [ <?php foreach((get_the_category()) as $category) { echo '"' . htmlspecialchars_decode($category->cat_name) . '",'; } ?> ]
          };
        </script>
      </section>

    <?php
      $postID = $post->ID;
      endwhile; ?>
  </article>

  <?php edit_post_link('Redigera', '<span class="btn btn-default btn-sm edit">', '</span>'); ?>

  <?php comments_template( '', true ); ?>

  <nav>
    <ul class="pagination">
      <li class="previous"><?php previous_post_link( '%link', 'Föregående' ); ?></li>
      <li class="next"><?php next_post_link( '%link', 'Nästa' ); ?></li>
    </ul>
  </nav>
</main>


<?php
  $template_vars = array('postID' => $postID);
  get_template_part('aside');
  get_footer();
?>
