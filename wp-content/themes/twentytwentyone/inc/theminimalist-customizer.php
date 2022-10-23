<?php 

/**
 * 
 */
class TheMinimalist_Customizer 
{
	
	public function __construct()
	{
		add_action('customize_register', array($this, 'register_customize_sections'));
	}

	public function register_customize_sections ($wp_customize)
	{
		// initialize section
		$this->banner_callout_section($wp_customize);
	}
	//Background section and settings
	private function banner_callout_section($wp_customize)
	{
		// new section panel
		$wp_customize->add_section('banner-callout-section', array(
			'title' => 'Banner',
			'priority' => 20,
			'description' => __('Header banner area for the background image and text with image content on home page.')
			)
		);

		// Add settings
		$wp_customize->add_setting('background-callout-display', array(
				'default' => "No",
				'senitize_callback' => array($this,'senitize_custom_option')
		));

		// Add control BG
		$wp_customize->add_control(new Wp_Customize_Control($wp_customize, 'background-callout-display-control',array(
				'label' => 'Display Banner section',
				'section' => 'banner-callout-section',
				'settings' => 'background-callout-display',
				'type' => 'select',
				'choices' => array('Yes'=> 'Yes', 'No' => 'No') 
			)
		));

		// Display text
		$wp_customize->add_setting('text-callout-display', array(
				'default' => '',
				'senitize_callback' => array($this,'senitize_custom_text')
		));

		// Add control text
		$wp_customize->add_control(new Wp_Customize_Control($wp_customize, 'text-callout-display-control',array(
				'label' => 'Title',
				'section' => 'banner-callout-section',
				'settings' => 'text-callout-display',
				'type' => 'textarea'
			)
		));

		
		// Display Image
		$wp_customize->add_setting('image-callout-display', array(
				'default' => '',
				'type' => 'theme_mod',
				'capability' => 'edit_theme_options',
				'senitize_callback' => array($this,'senitize_custom_image')
		));

		// Add control text
		$wp_customize->add_control(new Wp_Customize_Cropped_Image_Control($wp_customize, 'image-callout-display-control',array(
				'label' => 'Image',
				'section' => 'banner-callout-section',
				'settings' => 'image-callout-display',
				'width' => '500',
				'height' => '300'
			)
		));




	}



	public function senitize_custom_option($input) {
		return ($this === 'Yes') ? "Yes" : "No";
	}

	public function senitize_custom_text($input) {
		return filter_var($input, FILTER_SANITIZE_STRING);
	}

	public function senitize_custom_image($input) {
		return filter_var($input, FILTER_SANITIZE_URL);
	}

}

?>