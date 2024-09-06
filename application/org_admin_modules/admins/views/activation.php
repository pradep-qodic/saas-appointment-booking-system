
	
	<div class="row">
		<div class="span6 offset3">
			
            <?php if(isset($act_error)): ?>
			<h1>Error</h1>
			<div class="well">
                        <p style="color: red;text-align: center;">
                        <?php echo $act_error; ?>
                        </p>
            </div>
			<?php endif; ?>	
            <?php
                    if(isset($activation_success) && $activation_success !=NULL && $activation_success !=""){
                        ?>	
            <h1>Success</h1>
			<div class="well">
                        <p>Thank you!!!</p>
                        <p>
                        <?php echo $activation_success; ?>
                        </p>
            </div>
                        <?php
                    }
                 ?>
			
		</div>
	</div>
