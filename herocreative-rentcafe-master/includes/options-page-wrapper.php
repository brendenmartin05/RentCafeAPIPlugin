<div class="wrap">
	<h2>Official RentCafe Integration Plugin</h2>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"></div>
		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">

				<!-- main content -->
				<div id="post-body-content">

					<div class="meta-box-sortables ui-sortable">

						<div class="postbox">

							<div class="handlediv" title="Click to toggle"><br></div>
							<!-- Toggle -->

							<h2 class="hndle">Enter Property Details</h2>

							<div class="inside">
								<div id="icon-options-general" class="icon32"></div>

								<form name="herocreative_rentcafe_form" method="post" action="">

									<input type="hidden" name="herocreative_form_submitted" value="Y">

									<table class="form-table">
										<tbody>
											<tr>
												<td class="row-title">
													<label for="rentcafe_company_code"><h3>Company Code</h3></label>
												</td>
												<td class="row-title">
													<input name="rentcafe_company_code" id="rentcafe_company_code" type="text" value="<?php echo $rentcafe_company_code ?>" class="regular-text" />
												</td>
											</tr>
											<tr>
												<td class="row-title">
													<label for="rentcafe_property_code"><h3>Property Code</h3></label>
												</td>
												<td class="row-title">
													<input name="rentcafe_property_code" id="rentcafe_property_code" type="text" value="<?php echo $rentcafe_property_code ?>" class="regular-text" />
												</td>
											</tr>
										</tbody>
									</table>
									<input class="button-primary" type="submit" name="herocreative_rentcafe_submit" value="Submit" />
								</form>
							</div>
							<!-- .inside -->
						</div>
						<!-- .postbox -->

						<?php include("rentcafe-template.php"); ?>

						<?php if( $display_json == true && $property_data && !property_exists($property_data[0], 'Error' ) ) : ?>

						<div class="postbox json-feed">
							<div class="shortcode-box">
								<h3>Your Shortcode (copy and paste on a page or post to render the above widget)</h3>
								<input type="text" value="[rentcafe]">
							</div>


							<h3>JSON Feed</h3>
							<div class="inside">
								<pre>
									<?php echo json_encode($property_data, JSON_PRETTY_PRINT); ?>
								<pre>
							</div>
						</div>

            <?php elseif($form_post) : ?>

            <div class="postbox error">
              <p>An error occurred when accessing RentCafe. Please type in valid company and property codes.</p>
            </div>

						<?php endif; ?>

					</div> <!-- .meta-box-sortables .ui-sortable -->

				</div> <!-- post-body-content -->

			</div>
			<!-- #post-body .metabox-holder .columns-2 -->

			<br class="clear">
		</div>
		<!-- #poststuff -->

	</div> <!-- .wrap -->
</div> <!-- .wrap -->
