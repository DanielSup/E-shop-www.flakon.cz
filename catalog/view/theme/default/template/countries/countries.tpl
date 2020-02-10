<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content">
	<?php echo $content_top; ?>
	<h1><?php echo $text_heading; ?></h1>
	<p><?php echo $text_introduction; ?></p>
	<div style="text-align: right;">
		<input type="text" id="searchcountries" name="searchcountries" placeholder="Search country"/>
	</div>
	<?php foreach ($selected_countries as $country) { ?>
		<a href="/index.php?route=countries/countries#<?php echo $country; ?>"><span class="flag-icons <?php echo $country; ?>"></span></a>
	<?php } ?>
	<?php $categoryIndex = 1; ?>
	<?php foreach ($categories as $category) { ?>
		<h2><?php echo $category; ?></h2>
		<?php foreach ($countries[$categoryIndex] as $countryInCategory) { ?>
			<div class="country">
				<h3 id="<?php echo $countryInCategory->getAbbreviation(); ?>"><span class="flag-icons <?php echo $countryInCategory->getAbbreviation(); ?>"></span><?php echo $countryInCategory->getTitle(); ?></h3>
				<?php foreach ($countryInCategory->getTransportations() as $transportation) { ?>
					<p><strong><?php echo $transportation->getCompany(); ?></strong> -
					<?php echo $text_delivery_time_begin; echo $transportation->getDeliveryTime(); echo $text_delivery_time_end; ?>,
					<?php echo $text_delivery_cost; echo $transportation->getCost(); ?>
					<?php if ($transportation->getCashOnDeliveryFee() > 0) { ?>
						, <?php echo $text_delivery_cash_on_delivery; echo $transportation->getCashOnDeliveryFee(); ?>
					<?php } ?>
					</p>
				<?php } ?>
				<?php if (count($countryInCategory->getTransportations()) == 0) { ?>
					<p><?php echo $text_no_delivery; ?></p>
				<?php } ?>
			</div>
		<?php } ?>
		<?php $categoryIndex++; ?>
	<?php } ?>
	<?php echo $content_bottom; ?>
</div>
<?php echo $footer; ?>