<?php

get_header('min');

get_template_part('template-parts/content' , 'min-banner');

?>

<div class="hero-slider">
    <div data-glide-el="track" class="glide__track">
        <div class="glide__slides">
            <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/IMG_8BitComputer.jpg')?>)">
                <div class="hero-slider__interior container">
                    <div class="hero-slider__overlay">
                        <h2 class="headline headline--medium t-center">8 Bit Computer</h2>
                        <p class="t-center">A simple as possible 8 bit computer</p>
                        <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
                    </div>
                </div>
            </div>
            <div class="hero-slider__slide" style="background-position: bottom; background-image: url(<?php echo get_theme_file_uri('/images/AIDataPipes.jpg')?>)">
                <div class="hero-slider__interior container">
                    <div class="hero-slider__overlay">
                        <h2 class="headline headline--medium t-center">A.I. DataPipes</h2>
                        <p class="t-center">HVAC anomaly detection</p>
                        <p class="t-center no-margin"><a href="https://www.aidatapipes.com" class="btn btn--blue">Learn more</a></p>
                    </div>
                </div>
            </div>
            <div class="hero-slider__slide" style="background-position: bottom; background-image: url(<?php echo get_theme_file_uri('/images/AlgoViz.jpg')?>)">
                <div class="hero-slider__interior container">
                    <div class="hero-slider__overlay">
                        <h2 class="headline headline--medium t-center">Algorithm Visualizations</h2>
                        <p class="t-center">Interactive C.S. visualizations</p>
                        <p class="t-center no-margin"><a href="https://ng2.robertocannella.com/datastructures" class="btn btn--blue">Learn more</a></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="slider__bullets glide__bullets" data-glide-el="controls[nav]"></div>
    </div>
</div>

<?php
get_footer();