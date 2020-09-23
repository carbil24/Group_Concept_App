@extends('layouts.guest')

@section('content')

<section id="slider" class="slider-parallax swiper_wrapper clearfix">

	<div class="slider-parallax-inner">

		<div class="swiper-container swiper-parent">
			<div class="swiper-wrapper">
				
				<div class="swiper-slide dark" style="background-image: url('/images/1-slider-bg_accueil_poutine.jpg');">
					<div class="container clearfix" >
						<div class="slider-caption slider-caption-center"   style="background-color: #59595980; padding-top: 50px; padding-bottom: 50px">
							<h2   data-caption-animate="fadeInUp" >Évadez-vous!</h2>
							<p data-caption-animate="fadeInUp" data-caption-delay="200" style="color:aliceblue;">avec une authentique poutine du Québec</p>
							
							
						</div>
					</div>
				</div>

				<div class="swiper-slide dark" style="background-image: url('/images/2c-slider-bg_accueil_erable.jpg');">
					<div class="container clearfix">
						<div class="slider-caption slider-caption-center" style="background-color: #59595980;padding-top: 50px; padding-bottom: 50px;">
							<h2 data-caption-animate="fadeInUp">Sucrez-vous le bec!</h2>
							<p data-caption-animate="fadeInUp" data-caption-delay="200"> sans vous sentir coupable</p>
							
						</div>
					</div>
				</div>

				<div class="swiper-slide dark" style="background-image: url('/images/3-slider-bg_accueil_bullshead.jpg');">
					<div class="container clearfix">
						<div class="slider-caption slider-caption-center" style="background-color: #59595980;padding-top: 50px; padding-bottom: 50px;">
							<h2 data-caption-animate="fadeInUp" >Désaltérez-vous!</h2>
							<p data-caption-animate="fadeInUp" data-caption-delay="200"  >avec un soda artisanal du Québec</p>
							
						</div>
					</div>
				</div>
				
			</div>
			
			<div id="slider-arrow-left"><i class="icon-angle-left"></i></div>
			<div id="slider-arrow-right"><i class="icon-angle-right"></i></div>
			<div id="slide-number"><div id="slide-number-current"></div><span>/</span><div id="slide-number-total"></div></div>
		</div>

	</div>

</section>


		<!-- Content
		============================================= -->
		<section id="content">

			<div class="content-wrap">

				<div class="promo promo-light promo-full bottommargin-lg header-stick notopborder">
					<div class="container clearfix">
						<h3>CANADIAN FOOD</h3>
						<h4>Une initiative pour vous rapprocher du Québec et de ses artisans agro-alimentaires!</h4>
						<a href="/boutique" class="button button-dark button-xlarge button-rounded">BOUTIQUE</a>
						
					</div>
				</div>
							

				<div class="container clearfix">

					<div class="col-md-12 nopadding">

						<div class="col-md-3 bottommargin-sm center">
							<span>
							<i class="fa fa-globe" style="font-size:96px"></i>
							</span>											 
							<h4 class="text-secondary"> Notre mission</h4>
							<p class="text-secondary notopmargin notoppadding"> Nous prenons sous notre aile les producteurs et artisans québécois pour exporter leurs produits distinctifs à l’international.</p>
							
						</div>

						<div class="col-md-3 noleftpadding bottommargin-sm center">
							<span>
							<i class="fa fa-arrows-h"  style="font-size:96px"></i>
							</span>
							<h4 class="text-secondary">Pas d'intermédiaire </h4>
							<p class="text-primarytext-secondary topmargin-sm"> Exportateur du Canada et Importateur en France: du producteur jusqu'à votre assiette.</p>
						</div>
						
						<div class="col-md-3 noleftpadding bottommargin-sm center">
							<i class="fa fa-credit-card"  style="font-size:96px"></i>
							<h4 class="text-secondary">Paiement sécurisé </h4>
							<p class="text-secondary topmargin-sm"> Commande et paiement sécurisé sur notre propre plateforme transactionnelle.</p>
						</div>

						<div class="col-md-3 noleftpadding bottommargin-sm center">
							<i class="fa fa-truck"  style="font-size:96px"></i>
							<h4 class="text-secondary">Livraison gratuite </h4>
							<p class="text-secondary topmargin-sm"> Livraison toute France métropolitaine. La livraison est offerte à partir de 60€ TTC d’achat.</p>
						</div>
						

					</div>

					
				</div>
			
				<!-- <div class="promo promo-light promo-full bottommargin-lg header-stick notopborder"> -->
				<div class="promo promo-light promo-full topmargin-lg  bottommargin-sm  notopborder">
					<div class="container clearfix">
						<h3>Découvrez <span>nos produits</span> </h3>
						<span>Nous préparerons le colis dès réception de votre commande et vous le livrerons dans un délai d’environ 5 jours ouvrés.</span>
						<a href="/boutique" class="button button-dark button-xlarge button-rounded">BOUTIQUE</a>
					</div>
				</div>
				
				<div class="nobottomborder nobottommargin footer-stick topmargin-sm">
					<div class="container clearfix nobottommargin">

						<div class="center">
					
						<ul class="clients-grid grid-5 clearfix">
							<a href="#" class="standard-logo" data-dark-logo="/images/1-marque_nyctea.jpg"><img src="/images/1-marque_nyctea.jpg" height="100" width="150" alt="Nyctea Logo"/></a>
							<a href="#" class="standard-logo" data-dark-logo="/images/2-marque_okaribou.jpg"><img src="/images/2-marque_okaribou.jpg" alt="Nyctea Logo" width="150" height="100" class="leftmargin-sm"/></a>
							<a href="#" class="standard-logo" data-dark-logo="/images/3-marque_fromagerie.jpg"><img src="/images/3-marque_fromagerie.jpg" alt="Nyctea Logo" width="150" height="100" class="leftmargin-sm"/></a>
							<a href="#" class="standard-logo" data-dark-logo="/images/4-marque_bullshead.jpg"><img src="/images/4-marque_bullshead.jpg" alt="Nyctea Logo" width="150" height="100" class="leftmargin-sm"/></a>
							<a href="#" data-dark-logo="/images/5-marque_kilosolutions.jpg"><img src="/images/5-marque_kilosolutions.jpg" alt="Nyctea Logo" width="150" height="100" class="leftmargin-sm"/></a>
							
						</ul>
							
					</div>
						
					</div>
				</div>
			</div>

		</section><!-- #content end -->

@endsection
