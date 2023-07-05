<?php
$section  = 'footer';
$priority = 1;
$prefix   = 'footer';

Medizin_Kirki::add_field( 'theme', array(
	'type'     => 'textarea',
	'settings' => 'footer_copyright_text',
	'label'    => esc_html__( 'Copyright Text', 'medizin' ),
	'section'  => $section,
	'priority' => $priority++,
	'default'  => esc_html__( 'Copyright &copy; 2020. All rights reserved.', 'medizin' ),
) );
