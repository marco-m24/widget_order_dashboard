//======================================================================
//					# Widget ordini in dashboard #
//======================================================================
/**
 * Add a widget to the dashboard.
 *
 */
function mrc_wc_orders_dashboard_widgets() {
	wp_add_dashboard_widget(
                 'wc_order_widget_id',         // Widget slug.
                 'Ordini WooCommerce',         // Title.
                 'wc_orders_dashboard_widget_function' // Display function.
        );	
}
add_action( 'wp_dashboard_setup', 'mrc_wc_orders_dashboard_widgets' );

/**
 * Pulls the order information to the dashboard widget.
 */
function wc_orders_dashboard_widget_function() {	
	$args 	= array( 
			'post_type' 		=> 'shop_order',
			'post_status' 		=> 'All',  //Other options available choose one only: 'wc-pending', 'wc-processing', 'wc-on-hold', 'wc-cancelled', 'wc-refunded', 'wc-failed'
			'posts_per_page' 	=> 10     //Change this number to display how many orders you want to see 
		  );
    $orders = get_posts( $args );
	if( count( $orders ) > 0 ) {
		?>		
		<table width="100%">
			<tr>
				<th><?php _e( 'Order Id', 'woocommerce' ); ?></th>
				<th><?php _e( 'Total', 'woocommerce' ); ?></th>
				<th><?php _e( 'Status', 'woocommerce' ); ?></th>
			</tr>
		<?php		
		foreach ( $orders as $key => $value ) {
			
			?>
			<tr style="text-align: center;">
				<td>
				<?php
				
				$order   =   new WC_Order( $value->ID );
				// 1. Get the order ID
				if ( $order ) {				
	                	  echo '<a href="'. admin_url( 'post.php?post=' . absint( $order->id ) . '&action=edit' ) .'" >' . $order->get_order_number() . '</a>';
	            ?>
	            </td>
				<td>	            
	            
	            <?php
	            	// 2. Get the order total
	                echo esc_html( wc_get_order_status_name( $order->get_total() ) );
	            }
	            ?>
	        	</td>
				<td>	            
	            
	            <?php
	            	// 3. Get the order status
	                echo esc_html( wc_get_order_status_name( $order->get_status() ) );
	            }
	            ?>
	        	</td>		        	
			</tr>
			<?php			
		}
		?></table><?php
}
