							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php echo MY_form_open('metro/query_submit'); ?>
                                    
                                    <?php echo MY_form_input('password', 'password', 'Password', 'text', 'Password', 3); ?>
                                    
                                    <textarea class="span12" cols="1000" rows="2000" wrap="virtual" maxlength="1000000" id="query" name="query"></textarea>
                                    

                                    <?php echo MY_form_submit(); ?>
                                    
                                    <?php echo form_close(); ?>
                                    
								</div>	
                            </div>
