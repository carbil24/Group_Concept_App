@extends('layouts.guest')

@section('content')

		<!-- Page Title
		============================================= -->
		<section id="page-title">


		</section><!-- #page-title end -->

		<!-- Content
		============================================= -->
		<section id="content">


		</section><!-- #content end -->

<script type="text/javascript">

	jQuery(document).ready( function($){
		
		let product = window.location.pathname.split('/');
		$.ajax({
			type: "GET",
			url: "http://178.128.238.235/api/v1/products/" + product[2],
			cache: false,
			success: function(data){
				$("#page-title").append(`
					<div class="container clearfix">
						<h1>${data.title}</h1>
						<ol class="breadcrumb">
							<li class="active">Produits</li>
						</ol>
					</div>`);	

				$("#content").append(`
					<div class="content-wrap">
						<div class="container clearfix">
							<div class="single-product">
								<div class="product">
									<div class="col_two_fifth">

										<!-- Product Single - Gallery
										============================================= -->
										<div class="product-image">
											<div class="fslider" data-pagi="false" data-arrows="false" data-thumbs="true">
												<div class="flexslider">
													<div class="slider-wrap" data-lightbox="gallery">
														<div class="slide" data-thumb="/upload/${data.image_path}"><a href="/upload/${data.image_path}" title="" data-lightbox="gallery-item"><img src="/upload/${data.image_path}" alt="/upload/${data.image_path}"></a></div>												
													</div>
												</div>
											</div>
											
										</div><!-- Product Single - Gallery End -->

									</div>

									<div class="col_two_fifth product-desc">

										<!-- Product Single - Price
										============================================= -->
										<div class="product-price"><ins>${data.unity_price} EUR</ins></div><!-- Product Single - Price End -->

										<!-- Product Single - Rating
										============================================= -->
										<div class="product-rating">
											<a href="#myLogin" data-lightbox="inline"><button type="submit" class="add-to-cart button nomargin">Acheter</button></a>
										</div><!-- Product Single - Rating End -->

										

										<div class="clear"></div>
										<div class="line"></div>

										<!-- Product Single - Short Description
										============================================= -->
										<h5><strong>${data.short_desc} </strong></h5>
										<p>${data.detailed_desc}</p>
										

										<!-- Product Single - Meta
										============================================= -->
										<div class="panel panel-default product-meta">
											<div class="panel-body">
												<span class="posted_in">Marque: <a>${data.brand}</a>.</span>
												<span class="posted_in">Durée de vie: <a>24 mois</a>.</span>
												<span class="posted_in">Format: <a>${data.um}</a>.</span>
											</div>
										</div><!-- Product Single - Meta End -->

										

									</div>

									<div class="col_one_fifth col_last">

										<h3>${data.brand}</h3>

										<div class="divider divider-center"><i class="icon-circle-blank"></i></div>

										<div class="feature-box fbox-plain fbox-dark fbox-small">
											<div class="fbox-icon">
												<i class="icon-credit-cards"></i>
											</div>
											<h3>Options de paiement</h3>
											<div class="center">
												<i class="fa fa-cc-mastercard" style="font-size:36px">&nbsp;</i>
												<i class="fa fa-cc-visa" style="font-size:36px">&nbsp;</i>
												<i class="fa fa-cc-paypal" style="font-size:36px"></i>
											</div>
											
										</div>

										<div class="feature-box fbox-plain fbox-dark fbox-small">
											<div class="fbox-icon">
												<i class="icon-truck2"></i>
											</div>
											<h3>Livraison</h3>
											<p class="notopmargin">Livraison toute France métropolitaine. La livraison est offerte à partir de 60€ TTC d’achat.</p>
										</div>
										<div class="feature-box fbox-plain fbox-dark fbox-small">
											<div class="fbox-icon">
												<i class="icon-truck2"></i>
											</div>
											<h3>Le fromage </h3>
											<p class="notopmargin">Le fromage fait l’objet d’une commande et d’un envoi séparé. La livraison est offerte dès l’achat d’1 sac de fromage.</p>
										</div>

									</div>					
								</div>
							</div>
						</div>
					</div>`);
																
			}
		});
	});
</script>

@endsection