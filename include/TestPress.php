<?php

namespace TestPress;

class TestPress
{
    private static $instance;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new TestPress();
        }
        return self::$instance;
    }

    public function initAction()
    {
        $this->autoGenerateCss('style.less', '_generate.css');
        $this->changePostObjectLabel();
    }

    public function adminInitAction()
    {
        $this->autoGenerateCss('admin.less', '_generate_admin.css');
    }

    public function editorSettingsFilter($settings)
    {
        $settings['tinymce'] = false;
        $settings['quicktags'] = false;
        $settings['media_buttons'] = false;
        return $settings;
    }

    public function enqueueScriptsAction()
    {
        $uri = get_template_directory_uri();

        wp_enqueue_style('generate-less', $uri . '/style/_generate.css');
        wp_enqueue_style( 'dashicons' );
        add_action( 'wp_enqueue_scripts', 'load_dashicons_front_end' );

        /* jQuery */
        wp_enqueue_script('jquery-3.2.1', $uri . '/lib/jquery/jquery-3.2.1.min.js');

        /* Vue */
        wp_enqueue_script('vuejs', $uri . '/lib/vue/vue-2.5.11.min.js');

	    /* Aes */
	    wp_enqueue_script('aes', $uri . '/lib/aes/aes.js');

        /* Popper */
        wp_enqueue_script('popper-js', $uri . '/lib/popper/popper.min.js');

        /* Bootstrap */
        wp_enqueue_style('bootstrap-css', $uri . '/lib/bootstrap/bootstrap.min.css');
        wp_enqueue_script('bootstrap-js', $uri . '/lib/bootstrap/bootstrap.min.js');

        /* Theme Script */
        wp_enqueue_script('base-script', $uri . '/script/script.js');
    }

    public function adminEnqueueScriptsAction()
    {
        $uri = get_template_directory_uri();

        /* CodeMirror */
        wp_enqueue_style('codemirror-css', $uri . '/lib/codemirror/codemirror.css');
        wp_enqueue_script('codemirror-js', $uri . '/lib/codemirror/codemirror.js');
        //wp_enqueue_script('codemirror-lib-javascript', $uri . '/lib/codemirror/mode/javascript/javascript.js');
        wp_enqueue_script('codemirror-lib-php', $uri . '/lib/codemirror/mode/php/php.js');
        wp_enqueue_script('codemirror-addon-matchbrackets', $uri . '/lib/codemirror/addon/edit/matchbrackets.js');
        wp_enqueue_script('codemirror-addon-comment', $uri . '/lib/codemirror/addon/comment/comment.js');

        /* Less Style*/
        wp_enqueue_style('generate-less', $uri . '/style/_generate_admin.css');

        /* Js File */
        wp_enqueue_script('admin-js', $uri . '/script/admin.js');
    }

	function getPostMetaCallBack( $post ) {
		return get_post_meta( $post['id'] );
	}

	/**
	 * @param $args
	 * @param $request
	 *
	 * @return mixed
	 *
	 * Wodpress default disable filter param in rest api. This function enable the filter parameter, and
	 * add meta data query support.
	 */
	function enableRestApiFilterParam($args, $request ) {
		if ( empty( $request['filter'] ) || ! is_array( $request['filter'] ) ) {
			return $args;
		}
		$filter = $request['filter'];

		if(isset($filter['posts_per_page'])) {
			$posts_per_page = (int)$filter['posts_per_page'];
			if($posts_per_page >=1  && $posts_per_page <= 100) {
				$args['posts_per_page'] = $posts_per_page;
			}
		}

		global $wp;
		$vars = apply_filters( 'query_vars', $wp->public_query_vars );
		$vars = array_merge($vars, array('meta_key', 'meta_value', 'meta_query'));
		foreach ( $vars as $var ) {
			if ( isset( $filter[ $var ] ) ) {
				$args[ $var ] = $filter[ $var ];
			}
		}
		if(isset($args['meta_query'])) { $args['meta_query'] = json_decode($args['meta_query'], true); }
		return $args;
	}

	public function restApiInitAction() {
		/* https://n8finch.com/getting-post-meta-wp-rest-api/ */
		register_rest_field( 'post', 'meta', array(
				'get_callback' => array($this, 'getPostMetaCallBack'),
				'schema' => null,
			)
		);

		foreach ( get_post_types( array( 'show_in_rest' => true ), 'objects' ) as $post_type ) {
			add_filter( 'rest_' . $post_type->name . '_query', array($this, 'enableRestApiFilterParam'), 10, 2 );
		}
	}

    public function autoGenerateCss($source, $target)
    {
        $templateDir = get_template_directory();

        $lessFile = $templateDir . '/style/' . $source;
        if (!file_exists($lessFile)) {
            return false;
        }

        $generateFile = $templateDir . '/style/' . $target;
        if (file_exists($generateFile)) {
            $changed = filemtime($lessFile) > filemtime($generateFile);
        } else {
            $changed = true;
        }

        if ($changed) {
            $parser = new \Less_Parser(array('compress' => true));
            $parser->parseFile($lessFile);
            file_put_contents($generateFile, $parser->getCss());
            touch($generateFile, filemtime($lessFile));
        }
    }

    public function changePostObjectLabel() {
        global $wp_post_types;
        $labels = &$wp_post_types['post']->labels;
        foreach($labels as $k => $v) {
            $v = str_replace('post', 'test', $v);
            $labels->$k = str_replace('Post', 'Test', $v);
        }
    }

    /**
     * bind to after_switch_theme
     */
    public function setUserRolesAction() {
        global $wp_roles;

        $roles = array_keys($wp_roles->roles);
        foreach($roles as $name) {
            $role = get_role($name);
            $role->remove_cap('edit_pages');
        }
    }

    /**
     * bind to add_meta_boxes
     */
    public function addMetaBoxesAction() {
        add_meta_box(
            'run-test',
            'Run Test',
            function() { include get_template_directory() . '/template/metabox/run-test.php'; },
            'post',
            'advanced',
            'high'
        );
    }

    /**
     * bind to after_setup_theme
     */
    public function removeAdminBar() {
        show_admin_bar(false);
    }
}