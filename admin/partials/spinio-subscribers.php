<?php

    $page_number = isset($_GET['cpage']) ? abs((int) $_GET['cpage']) : 1;
    $subscribers = $this->get_subscribers('10', $page_number);
?>

<div id="spinio-wrapper">
    <div class="container-fluid" style="padding-top: 20px; padding-bottom: 20px;">
        <div class="row text-center"><h2>Spinio Subscribers</h2> </div>
        <div class="table-responsive" >
            <table class="table table-striped table-hover">
                <?php if (!empty($subscribers['result'])) {
    ?>
                <thead>
                    <tr>
                        <th>
                            <?php _e('Name'); ?> 
                        </th>
                        <th>
                            <?php _e('Email'); ?> 
                        </th>
                        <th>
                            <?php _e('Date'); ?> 
                        </th>
                        <th>
                            <?php _e('Status'); ?> 
                        </th>
                    </tr>
                </thead>
                <tbody>
                    
                       <?php 

                       foreach ($subscribers['result'] as $sub) {
                           ?>
                       <tr>
                        <td>
                           <?php echo $sub['name']; ?>
                        </td>
                        <td>
                           <?php echo $sub['email']; ?>
                        </td>
                        <td>
                           <?php echo $sub['date']; ?>
                        </td>
                        
                        <td>
                           <?php echo $sub['status']; ?>
                        </td>
                        </tr>
                        
                    <?php 
                       } ?>
                    
                </tbody>
                <?php

} else {
    _e('<h2>No subscriber yet</h2>');
}
                    ?>
            </table>
            
        </div>
        <div class="pages clearfix">
        <?php 
        if (!empty($subscribers['pagination'])) : ?>
				<ul class="pagination">
					<?php foreach ($subscribers['pagination'] as $key => $page_link) : ?>
						<li class="paginated_link<?php if (strpos($page_link, 'current') !== false) {
            echo ' active';
        } ?>"><?php echo $page_link ?></li>
					<?php endforeach ?>
				</ul>
			<?php endif;
            if (!empty($subscribers['result'])) {
                ?>
			<div class="right"> <a id="spinio_export" class="button" data-loading-text="<i class='dashicons dashicons-update fa-spin'></i> Exporting" href="<?php echo esc_url(admin_url('admin-ajax.php?action=export_spinio_subscribers')); ?>"><?php _e('Export All'); ?></a> </div>
			<?php 
            } ?>
        </div>
    </div>
</div>