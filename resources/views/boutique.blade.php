@extends('layouts.guest')

@section('content')

		<!-- Page Title
		============================================= -->
		<section id="page-title">

			<div class="container clearfix">
				<h1>DÃ©couvrez nos produits</h1>
				<span>Bienvenue sur la boutique en ligne de Canadian Food, une initiative pour vous rapprocher du QuÃ©bec et de ses artisans agro-alimentaires!</span>
			</div>

		</section><!-- #page-title end -->

		<!-- Content
		============================================= -->
		<section id="content">

			<div class="section notopmargin nobottommargin">

				<div class="container clearfix">

					<!-- Post Content
					============================================= -->
					<div class="postcontent nobottommargin col_last">

						<!-- Shop
						============================================= -->
						<div id="shop" class="shop product-3 grid-container clearfix">
							
						</div><!-- #shop end -->

					</div><!-- .postcontent end -->

					<!-- Sidebar
					============================================= -->
					<div class="sidebar nobottommargin">
						<div class="sidebar-widgets-wrap">

							<div class="widget widget-filter-links clearfix">

								<h4>CatÃ©gories</h4>
								<ul id="cat" class="custom-filter" data-container="#shop" data-active-class="active-filter">
									<li class="widget-filter-reset active-filter"><a href="#" data-filter="*">Clear</a></li>
									
									<!--====CAtegorias en el left========== -->
									<!--<li><a href='#' data-filter='.sf-0000000633'>BiÃ¨res du QuÃ©bec</a></li>
									<li><a href='#' data-filter='.sf-0000000636'>Camerises du QuÃ©bec</a></li>
									<li><a href='#' data-filter='.sf-0000000635'>Confitures</a></li>
									<li><a href='#' data-filter='.sf-0000000647'>Fromage Ã  poutine</a></li>
									<li><a href='#' data-filter='.sf-0000000631'>Healthy</a></li>
									<li><a href='#' data-filter='.sf-0000000637'>Les essentiels</a></li>
									<li><a href='#' data-filter='.sf-0000000630'>Produits de l'Ã©rable</a></li>
									<li><a href='#' data-filter='.sf-0000000634'>Sodas du QuÃ©bec</a></li>-->
								</ul>
							</div>
						</div>
					</div><!-- .sidebar end -->

				</div>
				
			</div>
			
			<div class="nobottomborder topmargin-sm bottommargin-sm">
					<div class="container clearfix nobottommargin">

						<div class="center">
					
						
						<ul class="clients-grid grid-5 clearfix">
							<a href="https://www.canadianfood.org/DefaultPage.aspx?Key=15655" class="standard-logo" data-dark-logo="/images/1-marque_nyctea.jpg"><img src="/images/1-marque_nyctea.jpg" height="100" width="150" alt="Nyctea Logo"/></a>
							<a href="https://www.canadianfood.org/DefaultPage.aspx?Key=15655" class="standard-logo" data-dark-logo="/images/2-marque_okaribou.jpg"><img src="/images/2-marque_okaribou.jpg" alt="Nyctea Logo" width="150" height="100" class="leftmargin-sm"/></a>
							<a href="https://www.canadianfood.org/DefaultPage.aspx?Key=15655" class="standard-logo" data-dark-logo="/images/3-marque_fromagerie.jpg"><img src="/images/3-marque_fromagerie.jpg" alt="Nyctea Logo" width="150" height="100" class="leftmargin-sm"/></a>
							<a href="https://www.canadianfood.org/DefaultPage.aspx?Key=15655" class="standard-logo" data-dark-logo="/images/4-marque_bullshead.jpg"><img src="/images/4-marque_bullshead.jpg" alt="Nyctea Logo" width="150" height="100" class="leftmargin-sm"/></a>
							<a href="https://www.canadianfood.org/DefaultPage.aspx?Key=15655" class="standard-logo" data-dark-logo="/images/5-marque_kilosolutions.jpg"><img src="/images/5-marque_kilosolutions.jpg" alt="Nyctea Logo" width="150" height="100" class="leftmargin-sm"/></a>
							
						</ul>
							
					</div>
						
					</div>
				</div>
			

		</section><!-- #content end -->


	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="icon-angle-up"></div>

	<!-- External JavaScripts
	============================================= -->
	<script type="text/javascript" src="/js/jquery.js"></script>
	<script type="text/javascript" src="/js/plugins.js"></script>

	<!-- Footer Scripts
	============================================= -->
	<script type="text/javascript" src="/js/functions.js"></script>


		<script>
		jQuery(document).ready( function($){
			$.ajax({
				type: "GET",
				url: "http://178.128.238.235/api/v1/products",
				cache: false,
				success: function(data){
                	$.each(data,function(index,value){
						$("#shop").append(`<div class='product ${value.category_id} clearfix'>
                                <div class='product-image'>
                                    <a href='/products/${value.id}'>
                                        <img src='/upload/${value.image_path}' alt='BiÃ¨re Gamme Ã” - Ã”Tabarnak Blanche 4,1%'>
                                    </a>            
									<div class='sale-flash'>${value.unity_price} EUR</div>
                                	<div class='product-overlay'>
                                    	<a href="#myLogin" data-lightbox="inline" class="add-to-cart">
                                     	   <i class='icon-shopping-cart'></i>
                                        	<span> Se connecter</span>
                                    	</a>        
                                    	<a href='/products/${value.id}' class='item-quick-view' >
                                        	<i class='icon-zoom-in2'></i>
                                        	<span> Voir plus</span>
                                    	</a>        
                                	</div>    
                            	</div>    
								<div class='product-desc center'>       
									<div style='color:#000;' class='product-title'>
										<h4 style='color:#000;'>
											<a style='color:#000;' href='/products/${value.id}'>${value.title}
											</a>
										</h4>
									</div>    
								</div>
                        	</div>`);
					})
							
					$('#shop').isotope({
						transitionDuration: '0.65s',
						getSortData: {
							name: '.product-title',
							mark: '.product-mark',
							price_lh: function( itemElem ) {
								if( $(itemElem).find('.product-price').find('ins').length > 0 ) {
									var price = $(itemElem).find('.product-price ins').text();
								} else {
									var price = $(itemElem).find('.product-price').text();
								}

								priceNum = price.split("$");

								return parseFloat( priceNum[1] );
							},
							price_hl: function( itemElem ) {
								if( $(itemElem).find('.product-price').find('ins').length > 0 ) {
									var price = $(itemElem).find('.product-price ins').text();
								} else {
									var price = $(itemElem).find('.product-price').text();
								}

								priceNum = price.split("$");

								return parseFloat( priceNum[1] );
							}
						},
						sortAscending: {
							name: true,
							price_lh: true,
							price_hl: false
						}
					});				
				}
			});

			$.ajax({
				type: "GET",
				url: "http://178.128.238.235/api/v1/categories",
				cache: false,
				success: function(data){
                	$.each(data,function(index,value){
						$("#cat").append(`<li><a href='' data-filter='.${value.id}'>${value.title}</a></li>`);
					})
							
					$('.custom-filter:not(.no-count)').children('li:not(.widget-filter-reset)').each( function(){
						var element = $(this),
						elementFilter = element.children('a').attr('data-filter'),
						elementFilterContainer = element.parents('.custom-filter').attr('data-container');

						elementFilterCount = Number( jQuery(elementFilterContainer).find( elementFilter ).length );

						element.append('<span>'+ elementFilterCount +'</span>');

					});

					$('.shop-sorting li').click( function() {
						$('.shop-sorting').find('li').removeClass( 'active-filter' );
						$(this).addClass( 'active-filter' );
						var sortByValue = $(this).find('a').attr('data-sort-by');
						$('#shop').isotope({ sortBy: sortByValue });
						return false;
					});			
				}
			});
		});
	</script>

		@endsection
	