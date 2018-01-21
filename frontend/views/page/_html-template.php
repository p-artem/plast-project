<?php
/**
 * @var $this \yii\web\View
 * @var $model \common\models\Page
 * @var $other_content string
 */

use yii\helpers\Url;
use frontend\widgets\SiteBreadcrumbs;

$this->title = ($model->metatitle) ?: $model->name;
$metadesc = ($model->metadesc) ?: $model->name;
$metakeys = ($model->metakeys) ?: $model->name;
if ($metadesc) $this->registerMetaTag(['name' => 'description', 'content' => $metadesc]);
if ($metakeys) $this->registerMetaTag(['name' => 'keywords', 'content' => $metakeys]);
$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::canonical()]);
?>



<!-- 1170_contacts ============== -->
<div class="">

	<div class="top-page-wrap">
		<div class="container-cust">
			<div class="page-title">
				<div class="h1-title">Contacts</div>
			</div>
		</div>
	</div><!-- top-page-wrap END -->


	<div class="container-cust">
		<div class="row">
			<div class="col-sm-4 col-lg-5">
				<div class="contact-txt-wrap">
					<div class="contact-txt">
						<p>
							"e + A studio" is a young architectural firm founded in 2012. 
						</p>
						<p>
							Name of our office is "e + A studio" that stands for "emotions + architecture".
						</p>
						<p>
							The concept of our work is a combination of architectural space and the emotional component of human rights.
						</p>
					</div>

					<?= $this->render('../_inc/soc-set') ?>
				</div>
			</div>

			<div class="col-sm-8 col-lg-7">
				<div class="team-lst-wrap">

					<ul class="team-lst flex-grid ">
						<li class="team-itm flex-grid-itm">
							<div class="team-img" style="background-image: url(/img/team/1.jpg);">
								<img src="/img/_style/square.png" alt="team">
							</div>
							<div class="team-txt">
								<div class="team-post">Architect</div>
								<div class="team-name">Kopeikin Victor</div>

								<ul class="team-cont">
									<li>+38 067 580 7442</li>
									<li><a href="mailto:kopeikin.v@gmail.com"><span>kopeikin.v@gmail.com</span></a></li>
								</ul>
							</div>
						</li>

						<li class="team-itm flex-grid-itm">
							<div class="team-img" style="background-image: url(/img/team/2.jpg);">
								<img src="/img/_style/square.png" alt="team">
							</div>
							<div class="team-txt">
								<div class="team-post">Architect</div>
								<div class="team-name">Zabotin Pavel</div>

								<ul class="team-cont">
									<li>+38 096 540 8342</li>
									<li><a href="mailto:zabotin.p@gmail.com"><span>zabotin.p@gmail.com</span></a></li>
								</ul>
							</div>
						</li>

					</ul>

				</div><!-- team-lst-wrap END -->
			</div>
		</div><!-- row END -->



		<div class="contact-form-wrap">
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<form action="#" class="contact-form">

						<div class="top-form-line">
							<div class="top-form-info">Ready to start a project? Let’s talk</div>
							<ul class="top-form-count">
								<li>1</li>
								<li>/</li>
								<li>4</li>
							</ul>
						</div>

						<div class="form-inputs">


							<label class="cust-inp">
								<span class="inp-title">Describe your question?</span>
								<input type="text" required placeholder="Type here...">
							</label>

							<label class="cust-inp">
								<span class="inp-title">What’s your eMail address?</span>
								<input type="text" required placeholder="Type here...">
							</label>

							<label class="cust-inp">
								<span class="inp-title">What’s your last name?</span>
								<input type="text" required placeholder="Type here...">
							</label>

							<label class="cust-inp active">
								<span class="inp-title">What’s your first name?</span>
								<input type="text" required placeholder="Type here...">
							</label>
						</div>

						<div class="btn-wrap">
							<span class="btn change-inp">Next</span>
							<button type="submit" class="btn">Submit</button>
						</div>

					</form><!-- conact-form END -->
				</div>
			</div>
		</div>

		<div class="btn-wrap">
			<br>
			<br>

			<a href="#" class="" data-toggle="modal" data-target="#notice-modal"><span>Modal Button</span></a>
			
			<br>
			<br>
		</div>
		
	</div><!-- container-cust END -->

</div>
<!-- 1170_contacts ============== END -->



<!-- 1170_news ============== -->
<div class="">

	<div class="top-page-wrap">
		<div class="container-cust">
			<div class="row">
				<div class="col-sm-5">
					<div class="page-title">
						<div class="h1-title">Publications</div>
					</div>
				</div>
				<div class="col-sm-7">

					<div class="top-filter news-fltr">

						<label class="cust-sel">
							<select name="select">
								<option value="1">For All time</option>
								<option value="2">2017</option>
								<option value="3">2016</option>
								<option value="4">2015</option>
							</select>
						</label>

					</div><!-- top-filter END -->

				</div>
			</div>
		</div>
	</div><!-- top-page-wrap END -->


	<div class="container-cust">

		<div class="news-lst-wrap">
			<div class="news-lst flex-grid">

				<div class="news-itm flex-grid-itm">
					<a href="#" class="news-img">
						<img src="/img/news/1.jpg" alt="news">
					</a>

					<div class="news-descr">
						<div class="news-date">10 november 2013</div>
						<a href="#" class="news-title"><span>Construction of office for IT company in Kharkov</span></a>
						<a href="#" class="news-brief">Completed the construction of office in for an IT-company</a>
					</div>
				</div><!-- news-itm END -->

				<div class="news-itm flex-grid-itm">
					<a href="#" class="news-img">
						<img src="/img/news/2.jpg" alt="news">
					</a>

					<div class="news-descr">
						<div class="news-date">10 november 2013</div>
						<a href="#" class="news-title"><span>Construction of office for IT company in Kharkov</span></a>
						<a href="#" class="news-brief">Completed the construction of office in for an IT-company Completed the construction of office in for an IT-company</a>
					</div>
				</div><!-- news-itm END -->

				<div class="news-itm flex-grid-itm">
					<a href="#" class="news-img">
						<img src="/img/news/4.jpg" alt="news">
					</a>

					<div class="news-descr">
						<div class="news-date">10 november 2013</div>
						<a href="#" class="news-title"><span>Construction of office for IT company in Kharkov</span></a>
						<a href="#" class="news-brief">Completed the construction of office in for an IT-company</a>
					</div>
				</div><!-- news-itm END -->

				<div class="news-itm flex-grid-itm">
					<a href="#" class="news-img">
						<img src="/img/news/3.jpg" alt="news">
					</a>

					<div class="news-descr">
						<div class="news-date">10 november 2013</div>
						<a href="#" class="news-title"><span>Construction of office for IT company in Kharkov</span></a>
						<a href="#" class="news-brief">Completed the construction of office in for an IT-company</a>
					</div>
				</div><!-- news-itm END -->

				<div class="news-itm flex-grid-itm">
					<a href="#" class="news-img">
						<img src="/img/news/1.jpg" alt="news">
					</a>

					<div class="news-descr">
						<div class="news-date">10 november 2013</div>
						<a href="#" class="news-title"><span>Construction of office for IT company in Kharkov</span></a>
						<a href="#" class="news-brief">Completed the construction of office in for an IT-company</a>
					</div>
				</div><!-- news-itm END -->

				<div class="news-itm flex-grid-itm">
					<a href="#" class="news-img">
						<img src="/img/news/2.jpg" alt="news">
					</a>

					<div class="news-descr">
						<div class="news-date">10 november 2013</div>
						<a href="#" class="news-title"><span>Construction of office for IT company in Kharkov</span></a>
						<a href="#" class="news-brief">Completed the construction of office in for an IT-company Completed the construction of office in for an IT-company</a>
					</div>
				</div><!-- news-itm END -->

				<div class="news-itm flex-grid-itm">
					<a href="#" class="news-img">
						<img src="/img/news/4.jpg" alt="news">
					</a>

					<div class="news-descr">
						<div class="news-date">10 november 2013</div>
						<a href="#" class="news-title"><span>Construction of office for IT company in Kharkov</span></a>
						<a href="#" class="news-brief">Completed the construction of office in for an IT-company</a>
					</div>
				</div><!-- news-itm END -->

				<div class="news-itm flex-grid-itm">
					<a href="#" class="news-img">
						<img src="/img/news/3.jpg" alt="news">
					</a>

					<div class="news-descr">
						<div class="news-date">10 november 2013</div>
						<a href="#" class="news-title"><span>Construction of office for IT company in Kharkov</span></a>
						<a href="#" class="news-brief">Completed the construction of office in for an IT-company</a>
					</div>
				</div><!-- news-itm END -->

			</div><!-- news-lst END -->
		</div><!-- news-lst-wrap END -->


	</div><!-- container-cust END -->

</div>
<!-- 1170_news ============== END -->




<!-- 1170_projects ============== -->
<div class="">

	<div class="top-page-wrap">
		<div class="container-cust">
			<div class="row">
				<div class="col-sm-5">
					<div class="page-title">
						<div class="h1-title">Projects</div>
					</div>
				</div>
				<div class="col-sm-7">

					<div class="top-filter ">

						<label class="cust-sel fz_2">
							<select name="select">
								<option value="1">All projects</option>
								<option value="2">ARCHITECTURE</option>
								<option value="3">PUBLIC SPACE</option>
								<option value="4">INTERIORS</option>
								<option value="4">CONCEPTUAL DESIGNS</option>
								<option value="4">ART</option>
							</select>
						</label>

						<label class="cust-sel">
							<select name="select">
								<option value="1">For All time</option>
								<option value="2">2017</option>
								<option value="3">2016</option>
								<option value="4">2015</option>
							</select>
						</label>

					</div><!-- top-filter END -->

				</div>
			</div>
		</div>
	</div><!-- top-page-wrap END -->


	<div class="container-cust">

		<div class="proj-lst-wrap">
			<div class="proj-lst flex-grid">

				<div class="proj-itm flex-grid-itm">
					<a href="#" class="proj-img">
						<img src="/img/projects/Layer1.png" alt="proj">
						<span class="img-overlay">
							<span class="btn">View project</span>
						</span>
					</a>

					<div class="proj-descr">
						<div class="proj-date">2013</div>
						<a href="#" class="proj-title"><span>Daily revolution of ideas</span></a>
						<a href="#" class="proj-brief">Conceptual designs</a>
					</div>
				</div><!-- proj-itm END -->

				<div class="proj-itm flex-grid-itm">
					<a href="#" class="proj-img">
						<img src="/img/projects/Layer2.png" alt="proj">
						<span class="img-overlay">
							<span class="btn">View project</span>
						</span>
					</a>

					<div class="proj-descr">
						<div class="proj-date">2013</div>
						<a href="#" class="proj-title"><span>Daily revolution of ideas</span></a>
						<a href="#" class="proj-brief">Conceptual designs</a>
					</div>
				</div><!-- proj-itm END -->

				<div class="proj-itm flex-grid-itm">
					<a href="#" class="proj-img">
						<img src="/img/projects/Layer3.png" alt="proj">
						<span class="img-overlay">
							<span class="btn">View project</span>
						</span>
					</a>

					<div class="proj-descr">
						<div class="proj-date">2013</div>
						<a href="#" class="proj-title"><span>Daily revolution of ideas</span></a>
						<a href="#" class="proj-brief">Conceptual designs</a>
					</div>
				</div><!-- proj-itm END -->

				<div class="proj-itm flex-grid-itm">
					<a href="#" class="proj-img">
						<img src="/img/projects/Layer4.png" alt="proj">
						<span class="img-overlay">
							<span class="btn">View project</span>
						</span>
					</a>

					<div class="proj-descr">
						<div class="proj-date">2013</div>
						<a href="#" class="proj-title"><span>Daily revolution of ideas</span></a>
						<a href="#" class="proj-brief">Conceptual designs</a>
					</div>
				</div><!-- proj-itm END -->

				<div class="proj-itm flex-grid-itm">
					<a href="#" class="proj-img">
						<img src="/img/projects/Layer3.png" alt="proj">
						<span class="img-overlay">
							<span class="btn">View project</span>
						</span>
					</a>

					<div class="proj-descr">
						<div class="proj-date">2013</div>
						<a href="#" class="proj-title"><span>Daily revolution of ideas</span></a>
						<a href="#" class="proj-brief">Conceptual designs</a>
					</div>
				</div><!-- proj-itm END -->

				<div class="proj-itm flex-grid-itm">
					<a href="#" class="proj-img">
						<img src="/img/projects/Layer4.png" alt="proj">
						<span class="img-overlay">
							<span class="btn">View project</span>
						</span>
					</a>

					<div class="proj-descr">
						<div class="proj-date">2013</div>
						<a href="#" class="proj-title"><span>Daily revolution of ideas</span></a>
						<a href="#" class="proj-brief">Conceptual designs</a>
					</div>
				</div><!-- proj-itm END -->

				<div class="proj-itm flex-grid-itm">
					<a href="#" class="proj-img">
						<img src="/img/projects/Layer1.png" alt="proj">
						<span class="img-overlay">
							<span class="btn">View project</span>
						</span>
					</a>

					<div class="proj-descr">
						<div class="proj-date">2013</div>
						<a href="#" class="proj-title"><span>Daily revolution of ideas</span></a>
						<a href="#" class="proj-brief">Conceptual designs</a>
					</div>
				</div><!-- proj-itm END -->

				<div class="proj-itm flex-grid-itm">
					<a href="#" class="proj-img">
						<img src="/img/projects/Layer2.png" alt="proj">
						<span class="img-overlay">
							<span class="btn">View project</span>
						</span>
					</a>

					<div class="proj-descr">
						<div class="proj-date">2013</div>
						<a href="#" class="proj-title"><span>Daily revolution of ideas</span></a>
						<a href="#" class="proj-brief">Conceptual designs</a>
					</div>
				</div><!-- proj-itm END -->

				<div class="proj-itm flex-grid-itm">
					<a href="#" class="proj-img">
						<img src="/img/projects/Layer2.png" alt="proj">
						<span class="img-overlay">
							<span class="btn">View project</span>
						</span>
					</a>

					<div class="proj-descr">
						<div class="proj-date">2013</div>
						<a href="#" class="proj-title"><span>Daily revolution of ideas</span></a>
						<a href="#" class="proj-brief">Conceptual designs</a>
					</div>
				</div><!-- proj-itm END -->

			</div><!-- proj-lst END -->
		</div><!-- proj-lst-wrap END -->

	</div><!-- container-cust END -->

</div>
<!-- 1170_projects ============== END -->




<!-- 1170_projects_inside ============== -->
<div class="">

	<div class="container-cust">


		<div class="proj-slider-wrap">
			<div class="proj-slider">
				<div class="proj-slide" style="background-image: url(/img/projects/_slider/1.jpg);">
					<img src="/img/projects/_slider/_proj_rect.png" alt="project">
				</div>
				<div class="proj-slide" style="background-image: url(/img/projects/_slider/2.jpg);">
					<img src="/img/projects/_slider/_proj_rect.png" alt="project">
				</div>
				<div class="proj-slide" style="background-image: url(/img/projects/_slider/3.jpg);">
					<img src="/img/projects/_slider/_proj_rect.png" alt="project">
				</div>
				
				<div class="proj-slide" style="background-image: url(/img/projects/_slider/1.jpg);">
					<img src="/img/projects/_slider/_proj_rect.png" alt="project">
				</div>
				<div class="proj-slide" style="background-image: url(/img/projects/_slider/2.jpg);">
					<img src="/img/projects/_slider/_proj_rect.png" alt="project">
				</div>
				<div class="proj-slide" style="background-image: url(/img/projects/_slider/3.jpg);">
					<img src="/img/projects/_slider/_proj_rect.png" alt="project">
				</div>

				<div class="proj-slide" style="background-image: url(/img/projects/_slider/1.jpg);">
					<img src="/img/projects/_slider/_proj_rect.png" alt="project">
				</div>
				<div class="proj-slide" style="background-image: url(/img/projects/_slider/2.jpg);">
					<img src="/img/projects/_slider/_proj_rect.png" alt="project">
				</div>
				<div class="proj-slide" style="background-image: url(/img/projects/_slider/3.jpg);">
					<img src="/img/projects/_slider/_proj_rect.png" alt="project">
				</div>

			</div>
		</div>


		<div class="proj-inner-txt-wrap">
			<div class="row">
				<div class="col-sm-8 col-sm-offset-4">
					<div class="page-title">
						<div class="h1-title">Citadel Skyscraper</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">

					<ul class="proj-info-lst">
						<li class="tr">
							<div class="td">Location:</div>
							<div class="td">Japan</div>
						</li>

						<li class="tr">
							<div class="td">Function:</div>
							<div class="td">Skyscraper </div>
						</li>

						<li class="tr">
							<div class="td">Size:</div>
							<div class="td">1600000 m2</div>
						</li>

						<li class="tr">
							<div class="td">Status:</div>
							<div class="td">2012 Skyscraper Competition</div>
						</li>

						<li class="tr">
							<div class="td">Architects:</div>
							<div class="td">Pavlo Zabotin, Viktor Kopeikin</div>
						</li>


						<li class="tr share-tr">
							<div class="td">share:</div>
							<div class="td">
								<?= $this->render('../_inc/soc-set') ?>
							</div>
						</li>

					</ul><!-- proj-info-lst END -->

				</div>

				<div class="col-sm-8">
					<div class="proj-inner-txt">
						<p>
							Global climate change (which provokes negative consequences in the form of earthquakes, hurricanes, floods, tsunamis), technological catastrophe of global scale, as well as the probability of threat to humanity from space indicate the need to develop new systems of typological units in the structure of modern engineering and design. Recent events in Turkey, Indonesia and Japan are striking and unambiguous illustration of the urgency of the problem of developing strategic programs of human survival on Earth.
						</p>
						<p>
							As of today, the most affected by the disaster region is Japan. On that example we see that even the most economically and technologically developed countries of the world are helpless towards the destructive forces of nature.
						</p>
						<p>
							Our view on this issue is focused on the development of the concept of a prevailing type of alternative settlement system in Japan. The main idea of the project is a creation of a "defensive shield" around Japan, graphically resembling a fortress. The so-called "defensive shield" is designed to protect the island from the inside against external natural and anthropogenic influences. The project provides carrying the residential functions of cities in the land out to self-supporting residential units located in the sea (residential skyscrapers, citadels).These citadels interact with each other on the shoreline, forming a single closed defensive chain that operates both on the surface and underground. Thereby proceeds the mastering of new territories for the human life.
						</p>
					</div>
				</div>
			</div>
		</div><!-- proj-inner-txt-wrap END -->

	</div><!-- container-cust END -->


	<div class="simillar-wrap">

		<div class="container-cust">
			<div class="row">
				<div class="col-sm-4">
					<div class="btn-wrap">
						<a href="#" class="btn">Back to projects</a>
					</div>
				</div>
				<div class="col-sm-8">
					<ul class="similar-lnks">
						<li class="similar-l">
							<a href="#">
								<span>Coworking in Kiev</span>
								<i class="arr-l-ic">&nbsp;</i>
							</a>
						</li>
						<li class="similar-r">
							<a href="#">
								<span>Ken Roberts Memorial Delineation Competition</span>
								<i class="arr-r-ic">&nbsp;</i>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>

	</div><!-- simillar-wrap END -->

</div>
<!-- 1170_projects_inside ============== END -->




<!-- 1170_news_inside ============== -->
<div class="">

	<div class="top-page-wrap">
		<div class="container-cust">
			<div class="page-title">
				<div class="h1-title">Publication project Citadel Skyscraper in the international magazine "Future" (Spain)</div>
			</div>
		</div>
	</div><!-- top-page-wrap END -->



	<div class="container-cust">

		<div class="news-inner-wrap">
			<div class="news-date">10 november 2013</div>

			<div class="news-inner-txt">
				<p>
					Established in 2006, the eVolo Skyscraper Competition has become the world’s most prestigious award for high-rise architecture. The contest recognizes outstanding ideas that redefine skyscraper design through the implementation of new technologies, materials, programs, aesthetics, and spatial organizations. Studies on globalization, flexibility, adaptability, and the digital revolution are some of the multi-layered elements of the competition. It is an investigation on the public and private space and the role of the individual and the collective in the creation of dynamic and adaptive vertical communities.
				</p>

				<p>
					Over the last six years, an international panel of renowned architects, engineers, and city planners have reviewed more than 4,000 projects submitted from 168 countries around the world. Participants include professional architects and designers, as well as students and artists. This book is the compilation of 300 outstanding projects selected for their innovative concepts that challenge the way we understand architecture and their relationship with the natural and built environments.
				</p>
				<p>
					Over the last six years, an international panel of renowned architects, engineers, and city planners have reviewed more than 4,000 projects submitted from 168 countries around the world. Participants include professional architects and designers, as well as students and artists. This book is the compilation of 300 outstanding projects selected for their innovative concepts that challenge the way we understand architecture and their relationship with the natural and built environments.
				</p>


				<img src="/img/news/5.jpg" alt="image">

				<p>eVolo Skyscrapers Collector's Edition - Volume 1 - 624 pages</p>

			</div>

		</div>

	</div><!-- container-cust END -->


	<div class="simillar-wrap">

		<div class="container-cust">
			<div class="row">
				<div class="col-sm-4">
					<div class="btn-wrap">
						<a href="#" class="btn">Back to publications</a>
					</div>
				</div>
				<div class="col-sm-8">
					<ul class="similar-lnks">
						<li class="similar-l">
							<a href="#">
								<span class="similar-date">10 november 2013</span>
								<span>Publication project "Urban dynamic line" in the international magazine "Seoul Public Design Competition" (Seoul)</span>
								<i class="arr-l-ic">&nbsp;</i>
							</a>
						</li>
						<li class="similar-r">
							<a href="#">
								<span class="similar-date">07 september 2013</span>
								<span>Publication project Daegu Gosan Public Library on the site ArchDaily ENG</span>
								<i class="arr-r-ic">&nbsp;</i>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>

	</div><!-- simillar-wrap END -->

</div>
<!-- 1170_news_inside ============== END -->





























<!-- Title_PSD ============== -->
<div class="hidden">

	<div class="container">
		<div class="breadcrumbs hidden-xs ">
			<ul>
				<li>
					<a href="#"><span>link_1</span></a>
				</li>
				<li>
					<a href="#"><span>link_2</span></a>
				</li>
				<li>
					<a href="#"><span>link_3</span></a>
				</li>
				<li>
					<span>link_4</span>
				</li>
			</ul>
		</div>
		<div class="top-margin"></div>
	</div>

	<div class="top-page-wrap">
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-lg-3">
					<div class="top-title">
						<div class="h2-title">Title</div>
					</div>
				</div>
				<div class="col-md-8 col-lg-9">
					<div class="top-page-filter">

						Filter

					</div>
				</div>
			</div>
		</div>

		<div class="top-page-img"></div>

	</div><!-- top-page-wrap END -->









</div>
<!-- Title_PSD ============== END -->
