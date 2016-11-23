<?php

namespace GeditLab\Render;

/**
 * @brief Interface for template engines.
 */

interface TemplateEngine {
	public function replace_macros($s, $v);
	public function get_markup_template($file, $root='');
}
