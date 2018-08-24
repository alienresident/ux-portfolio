<?php

// -----------------------------------------
// semplice child theme
// functions.php
// -----------------------------------------

// add your functions here

$video = array(
	'options' => array(
		'title'  	 => 'Options',
		'hide-title' => true,
		'break'		 => '1,1,2,1,1,1,1,1',
		'video' => array(
			'title'			=> 'Video Upload',
			'size'			=> 'span4',
			'help'			=> 'If a \'Download\' button is visible in the frontend instead of your video it means that you are using a wrong format. (compatible formats for most browsers are .mp4 and .webm)',
			'data-input-type' => 'video-upload',
			'default'		=> '',
			'data-is-content' => true,
			'data-upload'	=> 'contentVideo',
		),
		'video_url' => array(
			'data-input-type'	=> 'input-text',
			'title'		 	=> 'Video Url',
			'help'			=> 'If your video is to big for a upload into the WordPress media library or you just want to include it from an external source (like a cdn), you can paste the link here. <br /><br />If a \'Download\' button is visible in the frontend instead of your video it means that you are using a wrong format. (compatible formats for most browsers are .mp4 and .webm)',
			'size'		 	=> 'span4',
			'placeholder'	=> 'http://my.cdn.com/video.mp4',
			'default'		=> '',
			'class'				=> 'editor-listen',
			'data-handler'		=> 'save',
		),
		'poster' => array(
			'title'			=> 'Poster',
			'size'			=> 'span2',
			'data-input-type'	=> 'editor-image-upload',
			'default'		=> '',
		),
		'ratio' => array(
			'data-input-type' 	=> 'input-text',
			'title'				=> 'Aspect Ratio',
			'size'				=> 'span2',
			'class'				=> 'editor-listen',
			'data-handler'		=> 'save',
			'default' 	 		=> '',
			'placeholder'		=> 'Example: 16:9',
			'help'				=> 'If you experience black bars (mostly with non 16:9 aspect ratios), please add your aspect ratio here. Examples: 16:9. You can even just use your resolution like: 1280:720. (don\'t forget the colon between width and height)',
		),
		'autoplay' => array(
			'data-input-type' => 'onoff-switch',
			'style-class'=> 'first-switch',
			'title'		 => 'Autoplay',
			'hide-title' => true,
			'size'		 => 'span4',
			'class'				=> 'editor-listen',
			'data-handler'		=> 'save',
			'default' 	 => 'off',
			'switch-values' => array(
				'on'	 => 'On',
				'off'	 => 'Off',
			),
		),
		'loop' => array(
			'data-input-type' => 'onoff-switch',
			'title'		 => 'Loop Video',
			'hide-title' => true,
			'size'		 => 'span4',
			'class'				=> 'editor-listen',
			'data-handler'		=> 'save',
			'default' 	 => 'off',
			'switch-values' => array(
				'on'	 => 'On',
				'off'	 => 'Off',
			),
		),
		'muted' => array(
			'data-input-type' => 'onoff-switch',
			'title'		 => 'Muted',
			'hide-title' => true,
			'size'		 => 'span4',
			'class'				=> 'editor-listen',
			'data-handler'		=> 'save',
			'default' 	 => 'off',
			'switch-values' => array(
				'on'	 => 'On',
				'off'	 => 'Off',
			),
		),
		'playsinline' => array(
			'data-input-type' => 'onoff-switch',
			'title'		 => 'Plays Inline',
			'hide-title' => true,
			'size'		 => 'span4',
			'class'				=> 'editor-listen',
			'data-handler'		=> 'save',
			'default' 	 => 'off',
			'switch-values' => array(
				'on'	 => 'On',
				'off'	 => 'Off',
			),
		),
		'transparent_controls' => array(
			'data-input-type' => 'onoff-switch',
			'title'		 => 'Transparent Controls',
			'hide-title' => true,
			'size'		 => 'span4',
			'class'				=> 'editor-listen',
			'data-handler'		=> 'save',
			'data-target'=> '.is-content',
			'default' 	 => 'off',
			'switch-values' => array(
				'on'	 => 'On',
				'off'	 => 'Off',
			),
		),
		'hide_controls' => array(
			'data-input-type' => 'onoff-switch',
			'title'		 => 'Hide Controls',
			'hide-title' => true,
			'size'		 => 'span4',
			'class'				=> 'editor-listen',
			'data-handler'		=> 'save',
			'data-target'=> '.is-content',
			'default' 	 => 'off',
			'switch-values' => array(
				'on'	 => 'On',
				'off'	 => 'Off',
			),
		),
	),
);

if(!class_exists('sm_video')) {
	class sm_video {

		public $output;

		// constructor
		public function __construct() {
			// define output
			$this->output = array(
				'html' => '',
				'css'  => '',
			);
		}

		// output frontend
		public function output_editor($values, $id) {

			// values
			extract( shortcode_atts(
				array(
					'hide_controls'			=> '',
					'transparent_controls'  => '',
					'cover'					=> '',
				), $values['options'] )
			);

			$this->output['html'] = '
				<div class="ce-video" data-hide-controls="' . $hide_controls . '" data-transparent-controls="' . $transparent_controls . '">
					<img src="' . get_template_directory_uri() . '/assets/images/admin/placeholders/video.png' . '" class="is-content" alt="video-placeholder" data-object-fit="' . $cover . '">
				</div>
			';

			// output
			return $this->output;
		}

		// output frontend
		public function output_frontend($values, $id) {

			// values
			extract( shortcode_atts(
				array(
					'video_url'				=> '',
					'poster' 	    		=> '',
					'loop' 					=> '',
					'muted'					=> '',
					'autoplay'				=> '',
					'playsinline'				=> '',
					'hide_controls'			=> '',
					'transparent_controls'  => '',
					'ratio'					=> '',
					'cover'					=> '',
				), $values['options'] )
			);

			// get content
			$content = $values['content']['xl'];

			// get src
			if(!empty($content)) {
				// is numeric and id? if not use old format
				if(is_numeric($content)) {
					$src = wp_get_attachment_url($content);
				} else {
					$src = $content;
				}
			} else {
				$src = $video_url;
			}

			// get video type
			$type = substr($src, -3);

			if($type == 'ogv') {
				$type = 'ogg';
			} elseif ($type == 'ebm') {
				$type = 'webm';
			}

			// set video dim to false per default
			$video_dim = false;

			// poster image
			if(!empty($poster)) {
				if(is_numeric($poster)) {
					// get image src
					$poster = semplice_get_image($poster, 'full');
				} else {
					$poster = semplice_get_external_image($poster);
					$poster = $poster['url'];
				}
				$poster = 'poster="' . $poster . '"';
			}

			// aspect ratio
			if(!empty($ratio)) {
				$video_dim = explode(':', $ratio);
				$video_dim = 'width="' . $video_dim[0] . '" height="' . $video_dim[1] . '"';
			}

			// attributes
			$attributes = array(
				'loop' => $loop,
				'autoplay' => $autoplay,
				'muted' => $muted,
				'playsinline' => $playsinline,
			);

			// define video atts
			$video_atts = '';

			foreach ($attributes as $attribute => $value) {
				if($value == 'on') {
					$video_atts .= $attribute . ' ';
				}
			}

			$this->output['html'] = '
				<div class="ce-video" data-hide-controls="' . $hide_controls . '" data-transparent-controls="' . $transparent_controls . '" style="width: 100%; max-width: 100%">
					<video class="video is-content" ' . $video_dim . ' preload="none" ' . $poster . ' ' . $video_atts . '">
						<source src="' . $src . '" type="video/' . $type . '">
						<p>If you are reading this, it is because your browser does not support the HTML5 video element.</p>
					</video>
				</div>
			';

			// output
			return $this->output;
		}
	}

	// instance
	$this->module['video'] = new sm_video;
}
