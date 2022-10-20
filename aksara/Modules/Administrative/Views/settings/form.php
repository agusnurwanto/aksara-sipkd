<div class="container-fluid pb-3">
	<form action="<?php echo current_page(); ?>" method="POST" class="--validate-form" enctype="multipart/form-data">
		<div class="row border-bottom bg-white mb-3 sticky-top" style="overflow-x:auto">
			<ul class="nav nav-pills" style="flex-wrap: nowrap">
				<li class="nav-item">
					<a href="#pills-setting" data-bs-toggle="pill" id="pills-setting-tab" class="nav-link rounded-0 no-wrap active">
						<i class="mdi mdi-cogs"></i>
						<?php echo phrase('configuration'); ?>
					</a>
				</li>
				<li class="nav-item">
					<a href="#pills-membership" data-bs-toggle="pill" id="pills-membership-tab" class="nav-link rounded-0 no-wrap">
						<i class="mdi mdi-account-group-outline"></i>
						<?php echo phrase('membership'); ?>
					</a>
				</li>
				<li class="nav-item">
					<a href="#pills-apis" data-bs-toggle="pill" id="pills-apis-tab" class="nav-link rounded-0 no-wrap">
						<i class="mdi mdi-code-braces"></i>
						<?php echo phrase('apis'); ?>
					</a>
				</li>
				<li class="nav-item">
					<a href="#pills-oauth" data-bs-toggle="pill" id="pills-oauth-tab" class="nav-link rounded-0 no-wrap">
						<i class="mdi mdi-shield-lock-outline"></i>
						OAuth
					</a>
				</li>
				<li class="nav-item">
					<a href="#pills-notifier" data-bs-toggle="pill" id="pills-notifier-tab" class="nav-link rounded-0 no-wrap">
						<i class="mdi mdi-bullhorn"></i>
						<?php echo phrase('notifier'); ?>
					</a>
				</li>
			</ul>
		</div>
		<div class="row">
			<div class="col-md-8">
				<div class="tab-content" id="pills-tabContent">
					<div class="tab-pane fade show active" id="pills-setting">
						<h5>
							<?php echo phrase('application_identity'); ?>
						</h5>
						<div class="form-group mb-3">
							<label class="text-muted d-block" for="app_name_input">
								<?php echo $results->form_data->app_name->label; ?>
								<?php echo ($results->form_data->app_name->required ? '<span class="float-end text-sm text-danger">' . phrase('required') . '</span>' : null); ?>
							</label>
							<?php echo $results->form_data->app_name->content; ?>
						</div>
						<div class="form-group mb-3">
							<label class="text-muted d-block" for="app_description_input">
								<?php echo $results->form_data->app_description->label; ?>
								<?php echo ($results->form_data->app_description->required ? '<span class="float-end text-sm text-danger">' . phrase('required') . '</span>' : null); ?>
							</label>
							<?php echo $results->form_data->app_description->content; ?>
						</div>
						<div class="row">
							<div class="col-6 col-md-4">
								<div class="form-group mb-3">
									<label class="text-muted text-center d-block" for="app_logo_input">
										<?php echo $results->form_data->app_logo->label; ?>
									</label>
									<div class="row">
										<div class="col-md-8 offset-md-2">
											<?php echo $results->form_data->app_logo->content; ?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-6 col-md-4">
								<div class="form-group mb-3">
									<label class="text-muted text-center d-block" for="app_icon_input">
										<?php echo $results->form_data->app_icon->label; ?>
									</label>
									<div class="row">
										<div class="col-md-8 offset-md-2">
											<?php echo $results->form_data->app_icon->content; ?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-6 col-md-4">
								<div class="form-group mb-3">
									<label class="text-muted d-block" for="app_language_input">
										<?php echo $results->form_data->app_language->label; ?>
										<?php echo ($results->form_data->app_language->required ? '<span class="float-end text-sm text-danger">' . phrase('required') . '</span>' : null); ?>
									</label>
									<?php echo $results->form_data->app_language->content; ?>
								</div>
							</div>
						</div>
						
						<hr class="border-secondary" />
						
						<h5>
							<?php echo phrase('contact_information'); ?>
						</h5>
						
						<div class="form-group mb-3">
							<label class="text-muted d-block" for="office_name_input">
								<?php echo $results->form_data->office_name->label; ?>
								<?php echo ($results->form_data->office_name->required ? '<span class="float-end text-sm text-danger">' . phrase('required') . '</span>' : null); ?>
							</label>
							<?php echo $results->form_data->office_name->content; ?>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group mb-3">
									<label class="text-muted d-block" for="office_email_input">
										<?php echo $results->form_data->office_email->label; ?>
										<?php echo ($results->form_data->office_email->required ? '<span class="float-end text-sm text-danger">' . phrase('required') . '</span>' : null); ?>
									</label>
									<?php echo $results->form_data->office_email->content; ?>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group mb-3">
									<label class="text-muted d-block" for="office_phone_input">
										<?php echo $results->form_data->office_phone->label; ?>
										<?php echo ($results->form_data->office_phone->required ? '<span class="float-end text-sm text-danger">' . phrase('required') . '</span>' : null); ?>
									</label>
									<?php echo $results->form_data->office_phone->content; ?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group mb-3">
									<label class="text-muted d-block" for="office_fax_input">
										<?php echo $results->form_data->office_fax->label; ?>
										<?php echo ($results->form_data->office_fax->required ? '<span class="float-end text-sm text-danger">' . phrase('required') . '</span>' : null); ?>
									</label>
									<?php echo $results->form_data->office_fax->content; ?>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group mb-3">
									<label class="text-muted d-block" for="whatsapp_number_input">
										<?php echo $results->form_data->whatsapp_number->label; ?>
										<?php echo ($results->form_data->whatsapp_number->required ? '<span class="float-end text-sm text-danger">' . phrase('required') . '</span>' : null); ?>
									</label>
									<?php echo $results->form_data->whatsapp_number->content; ?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group mb-3">
									<label class="text-muted d-block" for="instagram_username_input">
										<?php echo $results->form_data->instagram_username->label; ?>
										<?php echo ($results->form_data->instagram_username->required ? '<span class="float-end text-sm text-danger">' . phrase('required') . '</span>' : null); ?>
									</label>
									<?php echo $results->form_data->instagram_username->content; ?>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group mb-3">
									<label class="text-muted d-block" for="twitter_username_input">
										<?php echo $results->form_data->twitter_username->label; ?>
										<?php echo ($results->form_data->twitter_username->required ? '<span class="float-end text-sm text-danger">' . phrase('required') . '</span>' : null); ?>
									</label>
									<?php echo $results->form_data->twitter_username->content; ?>
								</div>
							</div>
						</div>
						<div class="form-group mb-3">
							<label class="text-muted d-block" for="office_address_input">
								<?php echo $results->form_data->office_address->label; ?>
								<?php echo ($results->form_data->office_address->required ? '<span class="float-end text-sm text-danger">' . phrase('required') . '</span>' : null); ?>
							</label>
							<?php echo $results->form_data->office_address->content; ?>
						</div>
						<div class="form-group mb-3">
							<label class="text-muted d-block" for="office_map_input">
								<?php echo $results->form_data->office_map->label; ?>
								<?php echo ($results->form_data->office_map->required ? '<span class="float-end text-sm text-danger">' . phrase('required') . '</span>' : null); ?>
							</label>
							<?php echo $results->form_data->office_map->content; ?>
						</div>
					</div>
					<div class="tab-pane fade" id="pills-membership">
						<h5>
							<?php echo phrase('membership'); ?>
						</h5>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group mb-3">
									<label class="text-muted d-block" for="frontend_registration_input">
										<?php echo $results->form_data->frontend_registration->label; ?>
									</label>
									<?php echo $results->form_data->frontend_registration->content; ?>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group mb-3">
									<label class="text-muted d-block" for="default_membership_group_input">
										<?php echo $results->form_data->default_membership_group->label; ?>
									</label>
									<?php echo $results->form_data->default_membership_group->content; ?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group mb-3">
									<label class="text-muted d-block" for="default_membership_group_input">
										<?php echo $results->form_data->auto_active_registration->label; ?>
										<i class="mdi mdi-help-circle-outline" data-bs-toggle="tooltip" title="<?php echo phrase('activate_user_after_registration'); ?>"></i>
									</label>
									<?php echo $results->form_data->auto_active_registration->content; ?>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group mb-3">
									<label class="text-muted d-block" for="username_changes_input">
										<?php echo $results->form_data->username_changes->label; ?>
									</label>
									<?php echo $results->form_data->username_changes->content; ?>
								</div>
							</div>
						</div>
						<hr class="border-secondary" />
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group mb-3">
									<label class="text-muted d-block">
										<?php echo $results->form_data->login_attempt->label; ?>
									</label>
									<div class="input-group">
										<?php echo $results->form_data->login_attempt->content; ?>
										<span class="input-group-text">
											<?php echo phrase('times'); ?>
										</span>
									</div>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group mb-3">
									<label class="text-muted d-block">
										<?php echo $results->form_data->blocking_time->label; ?>
									</label>
									<div class="input-group">
										<?php echo $results->form_data->blocking_time->content; ?>
										<span class="input-group-text">
											<?php echo phrase('minutes'); ?>
										</span>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group mb-3">
									<label class="text-muted d-block">
										<?php echo $results->form_data->one_device_login->label; ?>
									</label>
									<?php echo $results->form_data->one_device_login->content; ?>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="pills-apis">
						<h5>
							<?php echo phrase('apis'); ?>
						</h5>
						<div class="row">
							<div class="col-md-5">
								<div class="form-group mb-3">
									<label class="text-muted d-block" for="openlayers_search_provider_input">
										<?php echo $results->form_data->openlayers_search_provider->label; ?>
										<?php echo ($results->form_data->openlayers_search_provider->required ? '<span class="float-end text-sm text-danger">' . phrase('required') . '</span>' : null); ?>
									</label>
									<?php echo $results->form_data->openlayers_search_provider->content; ?>
								</div>
							</div>
							<div class="col-md-7">
								<div class="form-group mb-3">
									<label class="text-muted d-block" for="openlayers_search_key_input">
										<?php echo $results->form_data->openlayers_search_key->label; ?>
										<?php echo ($results->form_data->openlayers_search_key->tooltip ? '<i class="mdi mdi-information-outline text-primary" data-bs-toggle="tooltip" title="' . $results->form_data->openlayers_search_key->tooltip . '"></i>' : null); ?>
										<?php echo ($results->form_data->openlayers_search_key->required ? '<span class="float-end text-sm text-danger">' . phrase('required') . '</span>' : null); ?>
									</label>
									<?php echo $results->form_data->openlayers_search_key->content; ?>
								</div>
							</div>
						</div>
						<div class="form-group mb-3">
							<label class="text-muted d-block" for="default_map_tile_input">
								<?php echo $results->form_data->default_map_tile->label; ?>
								<?php echo ($results->form_data->default_map_tile->tooltip ? '<i class="mdi mdi-information-outline text-primary" data-bs-toggle="tooltip" title="' . $results->form_data->default_map_tile->tooltip . '"></i>' : null); ?>
								<?php echo ($results->form_data->default_map_tile->required ? '<span class="float-end text-sm text-danger">' . phrase('required') . '</span>' : null); ?>
							</label>
							<div class="input-group">
								<?php echo $results->form_data->default_map_tile->content; ?>
								<a href="//wiki.openstreetmap.org/wiki/Tile_servers" class="btn btn-secondary" target="_blank">
									<?php echo phrase('reference'); ?>
								</a>
							</div>
						</div>
						<hr class="border-secondary" />
						<div class="row">
							<div class="col-md-5">
								<div class="form-group mb-3">
									<label class="text-muted d-block" for="google_analytics_key_input">
										<?php echo $results->form_data->google_analytics_key->label; ?>
										<?php echo ($results->form_data->google_analytics_key->required ? '<span class="float-end text-sm text-danger">' . phrase('required') . '</span>' : null); ?>
									</label>
									<?php echo $results->form_data->google_analytics_key->content; ?>
								</div>
							</div>
							<div class="col-md-7">
								<div class="form-group mb-3">
									<label class="text-muted d-block" for="disqus_site_domain_input">
										<?php echo $results->form_data->disqus_site_domain->label; ?>
										<?php echo ($results->form_data->disqus_site_domain->required ? '<span class="float-end text-sm text-danger">' . phrase('required') . '</span>' : null); ?>
									</label>
									<?php echo $results->form_data->disqus_site_domain->content; ?>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="pills-oauth">
						<h5>
							<?php echo phrase('third_party_authentication'); ?>
						</h5>
						<div class="row">
							<div class="col-md-5">
								<div class="form-group mb-3">
									<label class="text-muted d-block" for="facebook_app_id_input">
										<?php echo $results->form_data->facebook_app_id->label; ?>
										<?php echo ($results->form_data->facebook_app_id->required ? '<span class="float-end text-sm text-danger">' . phrase('required') . '</span>' : null); ?>
									</label>
									<?php echo $results->form_data->facebook_app_id->content; ?>
								</div>
							</div>
							<div class="col-md-7">
								<div class="form-group mb-3">
									<label class="text-muted d-block" for="facebook_app_secret_input">
										<?php echo $results->form_data->facebook_app_secret->label; ?>
										<?php echo ($results->form_data->facebook_app_secret->required ? '<span class="float-end text-sm text-danger">' . phrase('required') . '</span>' : null); ?>
									</label>
									<?php echo $results->form_data->facebook_app_secret->content; ?>
								</div>
							</div>
						</div>
						<hr class="border-secondary" />
						<div class="row">
							<div class="col-md-5">
								<div class="form-group mb-3">
									<label class="text-muted d-block" for="google_client_id_input">
										<?php echo $results->form_data->google_client_id->label; ?>
										<?php echo ($results->form_data->google_client_id->required ? '<span class="float-end text-sm text-danger">' . phrase('required') . '</span>' : null); ?>
									</label>
									<?php echo $results->form_data->google_client_id->content; ?>
								</div>
							</div>
							<div class="col-md-7">
								<div class="form-group mb-3">
									<label class="text-muted d-block" for="google_client_secret_input">
										<?php echo $results->form_data->google_client_secret->label; ?>
										<?php echo ($results->form_data->google_client_secret->required ? '<span class="float-end text-sm text-danger">' . phrase('required') . '</span>' : null); ?>
									</label>
									<?php echo $results->form_data->google_client_secret->content; ?>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="pills-notifier">
						<h5>
							<?php echo phrase('application_notifier'); ?>
						</h5>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group mb-3">
									<label class="text-muted d-block" for="action_sound_input">
										<?php echo $results->form_data->action_sound->label; ?>
										<?php echo ($results->form_data->action_sound->required ? '<span class="float-end text-sm text-danger">' . phrase('required') . '</span>' : null); ?>
										<i class="mdi mdi-help-circle-outline" data-bs-toggle="tooltip" title="<?php echo phrase('turn_the_action_sound_effect_on_or_off'); ?>"></i>
									</label>
									<?php echo $results->form_data->action_sound->content; ?>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group mb-3">
									<label class="text-muted d-block" for="update_check_input">
										<?php echo $results->form_data->update_check->label; ?>
										<?php echo ($results->form_data->update_check->required ? '<span class="float-end text-sm text-danger">' . phrase('required') . '</span>' : null); ?>
										<i class="mdi mdi-help-circle-outline" data-bs-toggle="tooltip" title="<?php echo phrase('check_for_aksara_core_updates'); ?>"></i>
									</label>
									<?php echo $results->form_data->update_check->content; ?>
								</div>
							</div>
						</div>
						<hr class="border-secondary" />
						<h5 class="mb-3">
							<?php echo phrase('email_notifier'); ?>
						</h5>
						<div class="alert alert-warning">
							<?php echo phrase('to_working_with_google_smtp_make_sure_to_activate_less_secure_apps_setting_on_your_google_account'); ?>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group mb-3">
									<label class="text-muted d-block" for="smtp_email_masking_input">
										<?php echo $results->form_data->smtp_email_masking->label; ?>
										<?php echo ($results->form_data->smtp_email_masking->required ? '<span class="float-end text-sm text-danger">' . phrase('required') . '</span>' : null); ?>
									</label>
									<?php echo $results->form_data->smtp_email_masking->content; ?>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group mb-3">
									<label class="text-muted d-block" for="smtp_sender_masking_input">
										<?php echo $results->form_data->smtp_sender_masking->label; ?>
										<?php echo ($results->form_data->smtp_sender_masking->required ? '<span class="float-end text-sm text-danger">' . phrase('required') . '</span>' : null); ?>
									</label>
									<?php echo $results->form_data->smtp_sender_masking->content; ?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-8">
								<div class="form-group mb-3">
									<label class="text-muted d-block" for="smtp_host_input">
										<?php echo $results->form_data->smtp_host->label; ?>
										<?php echo ($results->form_data->smtp_host->required ? '<span class="float-end text-sm text-danger">' . phrase('required') . '</span>' : null); ?>
									</label>
									<?php echo $results->form_data->smtp_host->content; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group mb-3">
									<label class="text-muted d-block" for="smtp_port_input">
										<?php echo $results->form_data->smtp_port->label; ?>
										<?php echo ($results->form_data->smtp_port->required ? '<span class="float-end text-sm text-danger">' . phrase('required') . '</span>' : null); ?>
									</label>
									<?php echo $results->form_data->smtp_port->content; ?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group mb-3">
									<label class="text-muted d-block" for="smtp_username_input">
										<?php echo $results->form_data->smtp_username->label; ?>
										<?php echo ($results->form_data->smtp_username->required ? '<span class="float-end text-sm text-danger">' . phrase('required') . '</span>' : null); ?>
									</label>
									<?php echo $results->form_data->smtp_username->content; ?>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group mb-3">
									<label class="text-muted d-block" for="smtp_password_input">
										<?php echo $results->form_data->smtp_password->label; ?>
										<?php echo ($results->form_data->smtp_password->required ? '<span class="float-end text-sm text-danger">' . phrase('required') . '</span>' : null); ?>
									</label>
									<?php echo $results->form_data->smtp_password->content; ?>
								</div>
							</div>
						</div>
					</div>
					
					<div class="--validation-callback mb-0"></div>
					
				</div>
			</div>
		</div>
		<div class="opt-btn-overlap-fix"></div><!-- fix the overlap -->
		<div class="row opt-btn">
			<div class="col-md-8">
				<a href="<?php echo base_url('administrative'); ?>" class="btn btn-link --xhr">
					<i class="mdi mdi-arrow-left"></i>
					<?php echo phrase('administrative'); ?>
				</a>
				<button type="submit" class="btn btn-primary float-end">
					<i class="mdi mdi-check"></i>
					<?php echo phrase('update'); ?>
					<em class="text-sm">(ctrl+s)</em>
				</button>
			</div>
		</div>
	</form>
</div>
