<?php get_header(); ?>
<style>
.industry_heading h1 {
    text-transform: capitalize;
    font-size: 40px;
    padding: 30px 0;
}
.single_industry_content {
    margin: 50px 0;
    padding: 20px;
}
.industry_content , .industry_content p{
    font-size: 13px;
}
.industry_content h2 {
    font-size: 20px;
}
.industry_content strong{
    font-size: 16px;
} 
.industry_content a{
    color: #57c8ca;
    text-decoration:underline;
    cursor:pointer;  
}
.go-back-text {
    font-size: 18px;
    color: #000; /* Change color if needed */
    text-decoration: none;
    font-family: Arial, sans-serif;
}

.go-back-text:hover {
    text-decoration: underline;
    color: rgb(87, 200, 202);
} 
</style>    
<section class="single_industry_main">
<div class="container">
<div class="single_industry_content">
<div class="row">
<div class="col-md-12">
<a href="javascript:history.back()" class="go-back-text">← Go Back</a>
<div class="industry_heading">
    <h1><strong><?php echo get_the_title(); ?></strong></h1>
</div>



   <div class="industry_content">
    <?php echo get_the_content(); ?>
    </div>
    </div>
    </div> 
</div>
    </div>
    </section>

<?php get_footer(); ?>

