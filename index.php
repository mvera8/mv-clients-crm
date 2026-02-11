<?php
get_header();
?>

<div class="container-fluid px-0">
    <div class="row">
        <?php get_template_part('template-parts/dashboard-sidebar'); ?>

       <div class="col-12 col-md-10">
            <section id="dashboard-content" class="py-4 bg-light min-vh-100">
                <div class="container">
                    <?php
                    get_template_part(
                        'template-parts/dashboard',
                        'title',
                        array(
                            'title' => 'Blog',
                        )
                    );
                    ?>


  <?php if (have_posts()) : ?>
    
    <?php while (have_posts()) : the_post(); ?>
      
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        
        <h2>
          <a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
          </a>
        </h2>

        <p>
          Publicado el <?php echo get_the_date(); ?> 
          por <?php the_author(); ?>
        </p>

        <div>
          <?php the_excerpt(); ?>
        </div>

      </article>

      <hr>

    <?php endwhile; ?>

    <div class="pagination">
      <?php the_posts_pagination(); ?>
    </div>

  <?php else : ?>

    <p>No hay posts todavía. Tranquilo, el blog está en modo zen 🧘‍♂️</p>

  <?php endif; ?>


        
                </div>
            </section>
        </div>
    </div>
</div>

<?php
get_footer();
