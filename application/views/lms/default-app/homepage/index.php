<?php $this->load->view('lms/default-app/_layouts/header'); ?>
<?php $this->load->view('lms/default-app/_layouts/nav'); ?>
<?php $this->load->view('lms/default-app/homepage/part/jumbotron'); ?>

<div class="container u-mv-small">                   

	<div class="row">

		<?php if (!empty($courses['data'])): ?>

			<div class="col-lg-12 col-md-12">

				<div class="u-mb-small u-pv-small u-border-bottom">		
					<div class="row">

						<div class="col-12 col-xl-10 col-lg-9">
							<h3 class="u-h3">
								<?php echo $site['breadcrumbs'] ?>
							</h3>
						</div>
						<div class="col-12 col-xl-2 col-lg-3">
							<?php $this->load->view('lms/default-app/_layouts/select-filter'); ?>
						</div>

					</div>
				</div>

				<div class="row">					
					<?php foreach ($courses['data'] as $post): ?>

						<div class="col-sm-12 col-lg-4">

							<article class="c-event u-p-zero">
								<div class="c-event__img u-m-zero" data-mh="imaged">
									<a title="<?php echo $post['title'] ?>" class="u-color-primary" href="<?php echo $post['url'] ?>">
										<img width="100%" src="<?php echo $post['image']['thumbnail'] ?>" alt="<?php echo $post['title'] ?>">
									</a>
									
									<span class="c-event__status u-bg-secondary u-color-primary">
										<?php if ($post['sub_category']['icon']): ?>
											<i class="fa <?php echo $post['sub_category']['icon'] ?>"></i>
										<?php endif ?>
										<?php if (empty($post['sub_category']['icon'])): ?>
											<i class="fa fa-folder"></i>
										<?php endif ?>
										<a class='u-text-dark' href="<?php echo $post['sub_category']['url'] ?>" title="<?php echo $post['sub_category']['name'] ?>">
											<?php echo $post['sub_category']['name'] ?>
										</a>
									</span>
								</div>
								<div class="c-event__meta u-ph-small" data-mh="heading">
									<a title="<?php echo $post['title'] ?>" class="u-color-primary u-h4 u-text-bold" href="<?php echo $post['url'] ?>">
										<?php echo $post['title'] ?>
									</a>
								</div>
								<div class="c-event__meta u-ph-small u-pt-xsmall u-border-top">
									<div class="o-media">
										<div class="o-media__img u-mr-xsmall">
											<div class="c-avatar c-avatar--xsmall">
												<img class="c-avatar__img" src="<?php echo $post['author']['photo'] ?>" alt="<?php echo $post['author']['name'] ?>">
											</div>
										</div>
										<div class="o-media__body">
											<?php echo $post['author']['name'] ?>
											<small class="u-block u-text-mute">
												<?php echo $post['author']['headline'] ?>
											</small>
										</div>
									</div>
									<div class="u-ml-auto">
										<div class='rating-stars u-flex u-justify-between u-pt-xsmall'>
											<ul id='stars'>
												<li class='star selected' title='Poor' data-value='1'>
													<i class='fa fa-star fa-fw'></i>
												</li>
												<li class='star selected' title='Fair' data-value='2'>
													<i class='fa fa-star fa-fw'></i>
												</li>
												<li class='star selected' title='Good' data-value='3'>
													<i class='fa fa-star fa-fw'></i>
												</li>
												<li class='star selected' title='Excellent' data-value='4'>
													<i class='fa fa-star fa-fw'></i>
												</li>
												<li class='star selected' title='WOW!!!' data-value='5'>
													<i class='fa fa-star fa-fw'></i>
												</li>
											</ul>
										</div>
									</div>
								</div>
								<style type="text/css">
								/* Rating Star Widgets Style */
								.rating-stars ul {
									list-style-type:none;
									padding:0;

									-moz-user-select:none;
									-webkit-user-select:none;
								}
								.rating-stars ul > li.star {
									display:inline-block;

								}

								/* Idle State of the stars */
								.rating-stars ul > li.star > i.fa {
									font-size:14px; /* Change the size of the stars */
									color:#ccc; /* Color on idle state */
								}

								/* Hover state of the stars */
								.rating-stars ul > li.star.hover > i.fa {
									color:#FFCC36;
								}

								/* Selected state of the stars */
								.rating-stars ul > li.star.selected > i.fa {
									color:#FF912C;
								}

							</style>
							<div class="c-event__meta u-ph-small u-pt-xsmall u-border-top">
								<span class="cursor-default c-btn c-event__btn c-btn--custom u-bg-secondary u-color-primary u-border-zero"><i class="fa fa-eye u-mr-xsmall"></i><?php echo $post['views'] ?></span>          
								<?php if (empty($post['price'])): ?>
									<span class="cursor-default c-btn c-event__btn c-btn--custom u-bg-secondary u-color-primary u-border-zero">
										<i class="fa fa-shopping-cart u-mr-xsmall"></i>
										<?php echo $this->lang->line('free') ?>
									</span>
								<?php endif ?>
								<?php if (!empty($post['price'])): ?>
									<span class="cursor-default c-btn c-event__btn c-btn--custom u-bg-info u-text-small">
										<?php if (!empty($post['discount'])): ?>
											<s class="u-text-xsmall u-mr-xsmall"><?php echo $post['price'] ?></s>
											<?php echo $post['price_total'] ?>
										<?php endif ?>
										<?php if (empty($post['discount'])): ?>
											<?php echo $post['price_total'] ?>
										<?php endif ?>
									</span>
								<?php endif ?>
							</div>								
						</article>

					</div>

				<?php endforeach ?>	

				<div class="col-12">
					<?php $this->load->view('lms/default-app/_layouts/pagination');?>	
				</div>	
			</div>

		</div>

		<?php else: ?><div class="col-sm-12 col-lg-12">
			<div class="c-card u-p-medium u-pv-xlarge" data-mh="landing-cards">

				<div class="u-text-center u-justify-between">
					<div class="c-avatar c-avatar--large u-mb-small u-inline-flex">
						<img class="c-avatar__img" src="<?php echo base_url('storage/assets/app/img/logo.png') ?>" alt="<?php echo $this->lang->line('courses_not_found') ?>">
					</div>

					<p class="u-h5"><?php echo $this->lang->line('courses_not_found') ?></p>

				</div>

			</div>
		</div>
	<?php endif ?>

</div><!-- // .row -->

</div><!-- // .container -->

<?php $this->load->view('lms/default-app/_layouts/footer-widget'); ?>
<?php $this->load->view('lms/default-app/_layouts/footer'); ?>

<script type="text/javascript">
$(document).ready(function(){
  
  /* 1. Visualizing things on Hover - See next part for action on click */
  $('#stars li').on('mouseover', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
   
    // Now highlight all the stars that's not after the current hovered star
    $(this).parent().children('li.star').each(function(e){
      if (e < onStar) {
        $(this).addClass('hover');
      }
      else {
        $(this).removeClass('hover');
      }
    });
    
  }).on('mouseout', function(){
    $(this).parent().children('li.star').each(function(e){
      $(this).removeClass('hover');
    });
  });
  
  
  /* 2. Action to perform on click */
  $('#stars li').on('click', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
    var stars = $(this).parent().children('li.star');
    
    for (i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass('selected');
    }
    
    for (i = 0; i < onStar; i++) {
      $(stars[i]).addClass('selected');
    }
    
    // JUST RESPONSE (Not needed)
    var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
    var msg = "";
    if (ratingValue > 1) {
        msg = "Thanks! You rated this " + ratingValue + " stars.";
    }
    else {
        msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
    }
    responseMessage(msg);
    
  });
  
  
});


function responseMessage(msg) {
  $('.success-box').fadeIn(200);  
  $('.success-box div.text-message').html("<span>" + msg + "</span>");
}	
</script>