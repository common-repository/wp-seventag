<?php

namespace Clearcode;

if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( __NAMESPACE__ . '\Seventag' ) ) {
	/**
	 * Class Seventag
	 * @package Clearcode
	 */
	class Seventag extends Seventag\Plugin {
		public function __construct() {
			parent::__construct();

			add_filter( 'plugin_action_links_' . plugin_basename( self::get( 'file' ) ), array(
				$this,
				'plugin_action_links'
			) );
		}

		/**
		 * If option is not exists, add option with default values on plugin activation.
		 */
		public function activation() {
			if ( ! self::get_option() ) {
				self::add_option( array(
					'url'          => null,
					'id'           => null,
					'synchronous'  => 'wp_head',
					'asynchronous' => 'wp_body_open',
				) );
			}
		}

		/**
		 *  Remove option on deactivation.
		 */
		public function deactivation() {
			self::delete_option();
		}

		/**
		 * Return list of links to display on the plugins page.
		 *
		 * @param array $links List of links.
		 *
		 * @return mixed List of links.
		 */
		public function plugin_action_links( $links ) {
			array_unshift( $links, self::get_template( 'link.php', array(
				'url'   => self::apply_filters( 'template\links\url',  get_admin_url( null, 'options-general.php?page=seventag' ) ),
				'id'    => self::apply_filters( 'template\links\id',   self::get( 'dir' ) ),
				'link'  => self::apply_filters( 'template\links\link', self::__( 'Settings' ) ),
				'links' => self::apply_filters( 'template\links',      $links )
			) ) );

			return $links;
		}

		/**
		 * Add JavaScript code to 7tag settings page.
		 */
		public function action_admin_enqueue_scripts( $page ) {
			if ( 'settings_page_seventag' == $page ) {
				wp_register_script( 'seventag', self::get( 'url' ) . '/assets/js/script.js', array( 'jquery' ), self::get( 'Version' ), true );
				wp_enqueue_script( 'seventag' );
			}
		}

		/**
		 * Add 7tag settings page.
		 */
		public function action_admin_menu() {
			add_options_page(
				self::__( '7tag Settings' ),
				self::__( '7tag' ),
				'manage_options',
				'seventag',
				array( $this, 'page' )
			);
		}
		
		/**
		 * Echo custom settings page template.
		 */
		public function page() {
			echo self::get_template( 'page.php', array(
				'fields'   => 'seventag',
				'sections' => 'seventag'
			) );
		}
		
		/**
		 * Add fields to a 7tag section of a settings page.
		 * Register a setting and its sanitization callback.
		 */
		public function action_admin_init() {
			register_setting(     'seventag', self::get( 'slug' ), array( $this, 'sanitize' ) );
			add_settings_section( 'seventag', self::__( '7tag' ),  array( $this, 'section'  ), 'seventag' );

			add_settings_field( 'url', self::__( 'Server URL' ), array(
					$this,
					'input'
				), 'seventag', 'seventag', array(
					'field'   => 'url',
					'type'    => 'input',
					'class'   => '',
					'id'      => self::get( 'slug' ) . '\url',
					'name'    => self::get( 'slug' ) . '[url]',
					'value'   => self::get_option( 'url' ),
					'checked' => '',
					'before'  => 'http(s)://',
					'after'   => '',
					'desc'    => sprintf(
						self::__( 'Learn more about %s on the 7tag documentation page.' ),
						'<a href="https://7tag.org/docs/installation/" target="_blank">' . self::__( 'Installation' ) . '</a>'
					)
				)
			);

			add_settings_field( 'id', self::__( 'Container ID' ), array(
					$this,
					'input'
				), 'seventag', 'seventag', array(
					'field'   => 'id',
					'type'    => 'input',
					'class'   => '',
					'id'      => self::get( 'slug' ) . '\id',
					'name'    => self::get( 'slug' ) . '[id]',
					'value'   => self::get_option( 'id' ),
					'checked' => '',
					'before'  => '',
					'after'   => '',
					'desc'    => sprintf(
						self::__( 'Learn more about %s on the 7tag documentation page.' ),
						'<a href="https://7tag.org/docs/containers/" target="_blank">' . self::__( 'Containers' ) . '</a>'
					)
				)
			);

			add_settings_field( 'synchronous\wp_head', self::__( 'Include tags synchronous' ), array(
					$this,
					'input'
				), 'seventag', 'seventag', array(
					'field'   => 'synchronous',
					'type'    => 'checkbox',
					'class'   => 'synchronous',
					'id'      => self::get( 'slug' ) . '\synchronous\wp_head',
					'name'    => self::get( 'slug' ) . '[synchronous]',
					'value'   => 'wp_head',
					'checked' => 'wp_head' == self::get_option( 'synchronous', 'wp_head' ) ? 'checked' : '',
					'before'  => '',
					'after'   => 'wp_head',
					'desc'    => self::__( 'Preferred method' )
				)
			);

			add_settings_field( 'synchronous\output_buffering', '', array(
					$this,
					'input'
				), 'seventag', 'seventag', array(
					'field'   => 'synchronous',
					'type'    => 'checkbox',
					'class'   => 'synchronous',
					'id'      => self::get( 'slug' ) . '\synchronous\output_buffering',
					'name'    => self::get( 'slug' ) . '[synchronous]',
					'value'   => 'output_buffering',
					'checked' => 'output_buffering' == self::get_option( 'synchronous' ) ? 'checked' : '',
					'before'  => '',
					'after'   => 'output buffering',
					'desc'    => sprintf(
						self::__( 'Use this option if you are not sure if the %s function is added to your theme.' ) . '<br />' .
						self::__( 'It will add the 7tag snippet directly before the %s tag using %s.' ),
						'<code>wp_head</code>',
						'<code>' . htmlspecialchars( '</head>' ) . '</code>',
						'<code>output buffering</code>'
					)
				)
			);

			add_settings_field( 'asynchronous\wp_body_open', self::__( 'Include tags asynchronous' ), array(
					$this,
					'input'
				), 'seventag', 'seventag', array(
					'field'   => 'asynchronous',
					'type'    => 'checkbox',
					'class'   => 'asynchronous',
					'id'      => self::get( 'slug' ) . '\asynchronous\wp_body_open',
					'name'    => self::get( 'slug' ) . '[asynchronous]',
					'value'   => 'wp_body_open',
					'checked' => 'wp_body_open' == self::get_option( 'asynchronous', 'wp_body_open' ) ? 'checked' : '',
					'before'  => '',
					'after'   => 'wp_body_open',
					'desc'    => sprintf(
						self::__( 'Add the following code directly after the %s tag in your theme (preferred method)' ) . ':' .
						'<pre><code>' . htmlspecialchars( "<?php if ( function_exists( 'wp_body_open' ) ) : wp_body_open(); ?>" ) . '</code></pre>',
						'<code>' . htmlspecialchars( '<body>' ) . '</code>'
					)
				)
			);

			add_settings_field( 'asynchronous\output_buffering', '', array(
					$this,
					'input'
				), 'seventag', 'seventag', array(
					'field'   => 'asynchronous',
					'type'    => 'checkbox',
					'class'   => 'asynchronous',
					'id'      => self::get( 'slug' ) . '\asynchronous\output_buffering',
					'name'    => self::get( 'slug' ) . '[asynchronous]',
					'value'   => 'output_buffering',
					'checked' => 'output_buffering' == self::get_option( 'asynchronous' ) ? 'checked' : '',
					'before'  => '',
					'after'   => 'output buffering',
					'desc'    => sprintf(
						self::__( 'Use this option if you cannot add the %s function to your theme.' ) . '<br />' .
						self::__( 'It will add the 7tag snippet directly after the %s tag using %s.' ),
						'<code>wp_body_open</code>',
						'<code>' . htmlspecialchars( '<body>' ) . '</code>',
						'<code>output buffering</code>'
					)

				)
			);
		}

		/**
		 * A callback function that sanitizes the option's value.
		 *
		 * @param array $option Array of value to sanitize.
		 *
		 * @return mixed Sanitized value.
		 */
		public function sanitize( $option = array() ) {
			foreach( array( 'id', 'url', 'synchronous', 'asynchronous' ) as $key ) {
				if ( empty ( $option[$key] ) ) {
					$option[ $key ] = null;
				}
			}

			return array(
				'url'          => esc_html( $option['url'] ),
				'id'           => esc_html( $option['id'] ),
				'synchronous'  => in_array( $option['synchronous'], array( 'wp_head', 'output_buffering' ) ) ? $option['synchronous'] : null,
				'asynchronous' => in_array( $option['asynchronous'], array( 'wp_body_open', 'output_buffering' ) ) ? $option['asynchronous'] : null
			);
		}

		/**
		 * Echo custom section template.
		 */
		public function section() {
			echo self::get_template( 'section.php', array(
				'content' => self::apply_filters( 'template\section\content', self::__( 'Settings' ) ),
			) );
		}

		/**
		 * Join array elements changing array representation key => value to key="value".
		 *
		 * @param array $atts Array of html properties
		 *
		 * @return string String containing a string representation of all the array
		 * elements in the same order, with the glue string between each element.
		 */
		protected function implode( $atts = array() ) {
			array_walk( $atts, function ( &$value, $key ) {
				$value = sprintf( '%s="%s"', $key, esc_attr( $value ) );
			} );

			return implode( ' ', $atts );
		}

		/**
		 * Echo custom field template with custom input.
		 *
		 * @param string $args Name of field.
		 */
		public function input( $args ) {
			extract( $args, EXTR_SKIP );

			echo self::get_template( 'input.php', array(
					'attrs' => self::implode( array(
							'type'  => self::apply_filters( "template\\input\\$field\\type",  $type  ),
							'class' => self::apply_filters( "template\\input\\$field\\class", $class ),
							'id'    => self::apply_filters( "template\\input\\$field\\id",    $id ),
							'name'  => self::apply_filters( "template\\input\\$field\\name",  $name ),
							'value' => self::apply_filters( "template\\input\\$field\\value", $value )
						)
					),
					'checked' => $checked,
					'before'  => self::apply_filters( "template\\input\\$field\\before", $before ),
					'after'   => self::apply_filters( "template\\input\\$field\\after",  $after ),
					'desc'    => self::apply_filters( "template\\input\\$field\\desc",   $desc )
				)
			);
		}

		/**
		 * Retrieve option value based on name of 7tag option and key.
		 *
		 * @param null|string $key Key of element in 7tag option array.
		 * @param false|mixed $default Default return element.
		 *
		 * @return array|mixed|void Element from 7tag option array.
		 */
		static public function get_option( $key = null, $default = false ) {
			if ( ! $option = get_option( self::get( 'slug' ) ) ) {
				return $default;
			}
			if ( $key ) {
				return array_key_exists( $key, $option ) ? $option[ $key ] : $default;
			}

			return $option;
		}

		/**
		 * Add option value based on name of 7tag option and key.
		 *
		 * @param null|string $value Value of element in 7tag option array.
		 * @param null|string $key Key of element in 7tag option array.
		 * @param null|string $autoload Autoload of element in 7tag option array.
		 *
		 * @return bool True if success or false if not.
		 */
		static public function add_option( $value, $key = null, $autoload = 'yes' ) {
			if ( self::get_option() ) {
				return self::update_option( $value, $key, $autoload );
			} elseif ( $key ) {
				return add_option( self::get( 'slug' ), array( $key => $value ), null, $autoload );
			} else {
				return add_option( self::get( 'slug' ), $value, null, $autoload );
			}
		}

		/**
		 * Update option value based on name of 7tag option and key.
		 *
		 * @param null|string $value Value of element in 7tag option array.
		 * @param null|string $key Key of element in 7tag option array.
		 * @param null|string $autoload Autoload of element in 7tag option array.
		 *
		 * @return bool True if success or false if not.
		 */
		static public function update_option( $value, $key = null, $autoload = null ) {
			if ( ! $option = self::get_option() ) {
				return self::add_option( $value, $key, $autoload );
			}
			if ( $key ) {
				$option[$key] = $value;
				return update_option( self::get( 'slug' ), $option, $autoload );
			}
			return update_option( self::get( 'slug' ), $value, $autoload );
		}

		/**
		 * Delete option value based on name of 7tag option and key.
		 *
		 * @param null|string $key Key of element in 7tag option array.
		 *
		 * @return bool True if success or false if not.
		 */
		static public function delete_option( $key = null ) {
			if ( ! $option = self::get_option() ) {
				return false;
			}
			if ( $key && array_key_exists( $key, $option )) {
				unset( $option[$key] );
				return self::update_option( $option );
			}
			return delete_option( self::get( 'slug' ) );
		}

		/**
		 *  Echo synchronous snippet.
		 */
		public function action_wp_head() {
			if ( 'wp_head' == self::get_option( 'synchronous', 'wp_head' ) ) {
				echo $this->get_snippet( 'synchronous' );
			}
		}

		/**
		 *  Echo asynchronous snippet.
		 */
		public function action_wp_body_open() {
			if ( 'wp_body_open' == self::get_option( 'asynchronous', 'wp_body_open' ) ) {
				echo $this->get_snippet( 'asynchronous' );
			}
		}

		/**
		 *  Get snippet template - special container for tag.
		 */
		protected function get_snippet( $method ) {
			$option = self::get_option();
			if ( ! empty( $option['url'] ) && ! empty( $option['id'] ) ) {
				return self::get_template( $method . '.php', array(
					'url' => $option['url'],
					'id'  => $option['id']
				) );
			}

			return '';
		}

		/**
		 * Start output buffering.
		 *
		 * @param string Template name.
		 *
		 * @return string Template name.
		 */
		public function filter_template_include_0( $template ) {
			if ( 'output_buffering' == self::get_option( 'synchronous' ) or
			     'output_buffering' == self::get_option( 'asynchronous' ) ) {
				ob_start();
			}

			return $template;
		}

		/**
		 * Echo buffered output.
		 *
		 */
		public function filter_shutdown_0() {
			if ( is_admin() ) return;

			$content = '';
			if ( 'output_buffering' == self::get_option( 'synchronous' ) or
			     'output_buffering' == self::get_option( 'asynchronous' ) ) {
				$content = ob_get_clean();
			}

			if ( 'output_buffering' == self::get_option( 'synchronous' ) ) {
				$pos = stripos( $content, '</head>' );
				$content = substr_replace( $content, $this->get_snippet( 'synchronous' ), $pos, 0 );
			}

			if ( 'output_buffering' == self::get_option( 'asynchronous' ) ) {
				$pos = stripos( $content, '<body' );
				$pos = stripos( $content, '>', $pos );
				$content = substr_replace( $content, $this->get_snippet( 'asynchronous' ), $pos + 1, 0 );
			}

			echo $content;
		}
	}
}
