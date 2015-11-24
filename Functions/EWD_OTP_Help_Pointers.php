<?php

function EWD_OTP_Return_Pointers() {
  $pointers = array();
  
  $pointers['tutorial-one'] = array(
    'title'     => "<h3>" . 'Order Tracking Intro' . "</h3>",
    'content'   => "<div><p>Thanks for installing OTP! These 7 slides will help get you started using the plugin.</p></div><div class='ewd-otp-pointer-count'><p>1 of 7</p></div>",
    'anchor_id' => '.Header',
    'edge'      => 'top',
    'align'     => 'left',
    'nextTab'   => 'Orders',
    'width'     => '320',
    'where'     => array( 'toplevel_page_EWD-OTP-options') // <-- Please note this
  );
  
  $pointers['tutorial-two'] = array(
    'title'     => "<h3>" . 'Create Orders' . "</h3>",
    'content'   => "<div><p>In the 'Orders' tab, you can create orders that visitors will be able to check. Use the form on the left to create an order, and then send the order number to a client so that can view progress on their order. You can also update the status of an order from this tab.</p></div><div class='ewd-otp-pointer-count'><p>2 of 7</p></div>",
    'anchor_id' => '#Orders_Menu',
    'edge'      => 'top',
    'align'     => 'left',
    'nextTab'   => 'Statuses',
    'width'     => '320',
    'where'     => array( 'toplevel_page_EWD-OTP-options') // <-- Please note this
  );

  $pointers['tutorial-three'] = array(
    'title'     => "<h3>" . 'Add Statuses' . "</h3>",
    'content'   => "<div><p>You can create your own statuses, or use the default ones that are available when the plugin is installed. The 'Email to Send' field contains a list of all email messages you've created, and you can select a different message to go out with each status.</p></div><div class='ewd-otp-pointer-count'><p>3 of 7</p></div>",
    'anchor_id' => '#Statuses_Menu',
    'edge'      => 'top',
    'align'     => 'left',
    'nextTab'   => 'Emails',
    'width'     => '320',
    'where'     => array( 'toplevel_page_EWD-OTP-options') // <-- Please note this
  );

  $pointers['tutorial-four'] = array(
    'title'     => "<h3>" . 'Create Email Messages' . "</h3>",
    'content'   => "<div><p>You can as many different email update messages as you'd like. Different messages can be set to go out whenever an order is set to a certain status (ex. 'Completed' status could have a message saying 'Order completed ... etc.')</p></div><div class='ewd-otp-pointer-count'><p>4 of 7</p></div>",
    'anchor_id' => '#Statuses_Menu',
    'edge'      => 'top',
    'align'     => 'left',
    'nextTab'   => 'Options',
    'width'     => '320',
    'where'     => array( 'toplevel_page_EWD-OTP-options') // <-- Please note this
  );

  $pointers['tutorial-five'] = array(
    'title'     => "<h3>" . 'Set Options' . "</h3>",
    'content'   => "<div><p>The 'Options' tab has options to help customize the plugin for your uses, including:<ul><li>Choosing what order information is displayed</li><li>Setting when emails are sent about orders</li><li>Added security by requiring users to enter their email and more!</li></ul></p></div><div class='ewd-otp-pointer-count'><p>5 of 7</p></div>",
    'anchor_id' => '#Options_Menu',
    'edge'      => 'top',
    'align'     => 'left',
    'nextTab'   => 'Dashboard',
    'width'     => '320',
    'where'     => array( 'toplevel_page_EWD-OTP-options') // <-- Please note this
  );
  
  $pointers['tutorial-six'] = array(
    'title'     => "<h3>" . 'Use Shortcodes' . "</h3>",
    'content'   => "<div><p>The basic OTP shortcode is [tracking-form], which you can add to any page. There are also shortcodes for customers, sales reps and accepting orders from visitors. For a complete shortcode list, <a href='https://wordpress.org/plugins/order-tracking/'>visit the plugin page</a>.</p></div><div class='ewd-otp-pointer-count'><p>6 of 7</p></div>",
    'anchor_id' => '#menu-pages',
    'edge'      => 'top',
    'align'     => 'left',
    'nextTab'   => 'Dashboard',
    'width'     => '320',
    'where'     => array( 'toplevel_page_EWD-OTP-options') // <-- Please note this
  );

  $pointers['tutorial-seven'] = array(
    'title'     => "<h3>" . 'Need More Help?' . "</h3>",
    'content'   => "<div><p><a href='https://wordpress.org/support/view/plugin-reviews/order-tracking?filter=5'>Help us spread the word with a 5 star rating!</a><br><br>We've got a number of videos on how to use the plugin:<br /><iframe width='570' height='315' src='https://www.youtube.com/embed/lIDnXamyh6c?list=PLEndQUuhlvSqa6Txwj1-Ohw8Bj90CIRl0' frameborder='0' allowfullscreen></iframe></p></div><div class='ewd-otp-pointer-count'><p>7 of 7</p></div>",
    'anchor_id' => '#wp-admin-bar-site-name',
    'edge'      => 'top',
    'align'     => 'left',
    'nextTab'   => 'Dashboard',
    'width'     => '600',
    'where'     => array( 'toplevel_page_EWD-OTP-options') // <-- Please note this
  );
  
  return $pointers; 
}

?>