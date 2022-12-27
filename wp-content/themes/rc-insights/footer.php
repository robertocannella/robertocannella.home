
</div><!-- #content -->



<footer class="site-footer">
    <div class="site-footer__inner container container--narrow">
        <div class="group">
            <div class="site-footer__col-one">
                <h1 class="school-logo-text school-logo-text--alt-color">
                    <a href="<?php echo site_url() ?>"><strong>Roberto</strong> Cannella</a>
                </h1>
                <p><a class="site-footer__link" href="#">781.504.1228</a></p>
            </div>

            <div class="site-footer__col-two-three-group">
                <div class="site-footer__col-two">
                    <h3 class="headline headline--small">Explore</h3>
                    <nav class="nav-list">
                        <?php
                        wp_nav_menu(['theme_location'=>'left-footer-menu'])
                        ?>
<!--                        <ul>-->
<!--                            <li><a href="--><?php //echo site_url('about') ?><!--">About Me</a></li>-->
<!--                            <li><a href="#">Projects</a></li>-->
<!--                            <li><a href="#">Events</a></li>-->
<!--                            <li><a href="#">Campuses</a></li>-->
<!--                        </ul>-->
                    </nav>
                </div>

                <div class="site-footer__col-three">
                    <h3 class="headline headline--small">Learn</h3>
                    <nav class="nav-list">
                        <?php
                        wp_nav_menu([
                                'theme_location'=>'right-footer-menu'
                            ])
                        ?>
<!--                        <ul>-->
<!--                            <li><a href="#">Legal</a></li>-->
<!--                            <li><a href="--><?php //echo site_url('privacy-policy') ?><!--">Privacy</a></li>-->
<!--                            <li><a href="#">Careers</a></li>-->
<!--                        </ul>-->
                    </nav>
                </div>
            </div>

            <div class="site-footer__col-four">
                <h3 class="headline headline--small">Connect With Me</h3>
                <nav>
                    <ul class="min-list social-icons-list group">
<!--                        <li>-->
<!--                            <a href="#" class="social-color-facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>-->
<!--                        </li>     -->
                        <li>
                            <a href="https://github.com/robertocannella" class="social-color-github"><i class="fa fa-github" aria-hidden="true"></i></a>
                        </li>
<!--                        <li>-->
<!--                            <a href="#" class="social-color-twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>-->
<!--                        </li>-->
                        <li>
                            <a href="https://www.youtube.com/channel/UC2kU6zwot4qTn2QfOUkDAdg" class="social-color-youtube"><i class="fa fa-youtube" aria-hidden="true"></i></a>
                        </li>
                        <li>
                            <a href="https://www.linkedin.com/in/robertocannella" class="social-color-linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                        </li>
<!--                        <li>-->
<!--                            <a href="#" class="social-color-instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>-->
<!--                        </li>-->
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</footer>


<!--<footer id="colophon" class="site-footer" role="contentinfo">-->
<!---->
<!--    <a href="--><?php //echo esc_url( __( 'https://wordpress.org/', 'wphierarchy' ) ); ?><!--">-->
<!--        --><?php //printf( esc_html__( 'Proudly powered by %s', 'wphierarchy' ), 'WordPress' ); ?>
<!--    </a>-->
<!---->
<!--</footer>-->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
