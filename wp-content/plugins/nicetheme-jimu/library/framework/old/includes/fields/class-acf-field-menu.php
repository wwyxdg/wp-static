<?php

if( ! class_exists('acf_field_menu') ) :

class acf_field_menu extends acf_field {
	
	
	/*
	*  __construct
	*
	*  This function will setup the field type data
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function initialize() {
		
		// vars
		$this->name = 'nav_menu';
		$this->label = __('Nav Menu');
		$this->category = 'relational';
		$this->defaults = array(
			'save_format' => 'id',
			'allow_null'  => 0
		);
		
	}
	
	/*
	*  render_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field - an array holding all the field's data
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/
	
	function render_field( $field ) {
        $allow_null = $field['allow_null'];
		$nav_menus  = $this->get_nav_menus( $allow_null );

		if ( empty( $nav_menus ) ) {
			return;
		}
		?>
		<select id="<?php esc_attr( $field['id'] ); ?>" class="<?php echo esc_attr( $field['class'] ); ?>" name="<?php echo esc_attr( $field['name'] ); ?>">
		<?php foreach( $nav_menus as $nav_menu_id => $nav_menu_name ) : ?>
			<option value="<?php echo esc_attr( $nav_menu_id ); ?>" <?php selected( $field['value'], $nav_menu_id ); ?>>
				<?php echo esc_html( $nav_menu_name ); ?>
			</option>
		<?php endforeach; ?>
		</select>
		<?php
	}
		
	
	/*
	*  render_field_settings()
	*
	*  Create extra options for your field. This is rendered when editing a field.
	*  The value of $field['name'] can be used (like bellow) to save extra data to the $field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field	- an array holding all the field's data
	*/
	
	function render_field_settings( $field ) {
        
        acf_render_field_setting( $field, array(
			'label'        => __( 'Return Value' ),
			'instructions' => __( 'Specify the returned value on front end' ),
			'type'         => 'radio',
			'name'         => 'save_format',
			'layout'       => 'horizontal',
			'choices'      => array(
				'object' => __( 'Nav Menu Object' ),
				'id'     => __( 'Nav Menu ID' ),
			),
        ) );
        
		// Register the Allow Null setting
		acf_render_field_setting( $field, array(
			'label'        => __( 'Allow Null?', 'acf' ),
			'type'         => 'radio',
			'name'         => 'allow_null',
			'layout'       => 'horizontal',
			'choices'      => array(
				1 => __( 'Yes' ),
				0 => __( 'No' ),
			),
		) );
			
	}
    
    /**
	 * Gets a list of Nav Menus indexed by their Nav Menu IDs.
	 *
	 * @param bool $allow_null If true, prepends the null option.
	 *
	 * @return array An array of Nav Menus indexed by their Nav Menu IDs.
	 */
	private function get_nav_menus( $allow_null = false ) {
		$navs = get_terms( 'nav_menu', array( 'hide_empty' => false ) );

		$nav_menus = array();

		if ( $allow_null ) {
			$nav_menus[''] = ' - Select - ';
		}

		foreach ( $navs as $nav ) {
			$nav_menus[ $nav->term_id ] = $nav->name;
		}

		return $nav_menus;
	}
	
    /**
	 * Renders the Nav Menu Field.
	 *
	 * @param int   $value   The Nav Menu ID selected for this Nav Menu Field.
	 * @param int   $post_id The Post ID this $value is associated with.
	 * @param array $field   The array representation of the current Nav Menu Field.
	 *
	 * @return mixed The Nav Menu ID, or the Nav Menu HTML, or the Nav Menu Object, or false.
	 */
	public function format_value( $value, $post_id, $field ) {
		// bail early if no value
		if ( empty( $value ) ) {
			return false;
		}

		// check format
		if ( 'object' == $field['save_format'] ) {
			$wp_menu_object = wp_get_nav_menu_object( $value );

			if( empty( $wp_menu_object ) ) {
				return false;
			}

			$menu_object = new stdClass;

			$menu_object->ID    = $wp_menu_object->term_id;
			$menu_object->name  = $wp_menu_object->name;
			$menu_object->slug  = $wp_menu_object->slug;
			$menu_object->count = $wp_menu_object->count;

			return $menu_object;
		} elseif ( 'menu' == $field['save_format'] ) {
			ob_start();

			wp_nav_menu( array(
				'menu' => $value,
				'container' => $field['container']
			) );

			return ob_get_clean();
		}

		// Just return the Nav Menu ID
		return $value;
	}
	
}


// initialize
acf_register_field_type( 'acf_field_menu' );

endif; // class_exists check

?>