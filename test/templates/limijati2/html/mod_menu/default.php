<?php

defined('_JEXEC') or die;

require_once dirname(__FILE__) . str_replace('/', DIRECTORY_SEPARATOR, '/../../functions.php');

if (!defined('modMainMenuArtxExtensions'))
{
	function artxMenuDecorator($content)
	{
		$result = '';
		ob_start();
?>
<div class="art-nav">
	<div class="l"></div>
	<div class="r"></div>
<?php
		$result .= ob_get_clean() . $content;
		ob_start();
?>
</div>
<?php
		$result .= ob_get_clean();
		return $result;
	}

	define('modMainMenuArtxExtensions', true);
}

// Note. It is important to remove spaces between elements.

$tag = ($params->get('tag_id') != NULL) ? ' id="' . $params->get('tag_id') . '"' : '';
if (isset($attribs['name']) && $attribs['name'] == 'user3') {
    $menutype = 'horizontal';
    ob_start();
    echo '<ul class="art-menu"' . $tag . '>';
    foreach ($list as $i => & $item) {
        $id = ($item->id == $active_id) ? ' id="current"' : '';
        $class = ' class="' . (in_array($item->id, $path) ? 'active ' : '') . 'item' . $item->id . '"';
        echo '<li' . $id . $class . '>';
        // Render the menu item.
        switch ($item->type) {
            case 'separator':
            case 'url':
            case 'component':
                require JModuleHelper::getLayoutPath('mod_menu', 'default_' . $item->type);
                break;
            default:
                require JModuleHelper::getLayoutPath('mod_menu', 'default_url');
                break;
        }
        if ($item->deeper)
            echo '<ul>';
        elseif ($item->shallower)
            echo '</li>' . str_repeat('</ul></li>', $item->level_diff);
        else
            echo '</li>';
    }
    echo '</ul>';
    echo artxMenuDecorator(ob_get_clean());
} elseif (preg_match('/\bart-vmenu\b/', $params->get('moduleclass_sfx'))) {
    $menutype = 'vertical';
    ob_start();
    echo '<ul class="art-vmenu"' . $tag . '>';
    foreach ($list as $i => & $item) {
        $id = ($item->id == $active_id) ? ' id="current"' : '';
        $class = ' class="' . (in_array($item->id, $path) ? 'active ' : '') . 'item' . $item->id . '"';
        echo '<li' . $id . $class . '>';
        // Render the menu item.
        switch ($item->type) {
            case 'separator':
            case 'url':
            case 'component':
                require JModuleHelper::getLayoutPath('mod_menu', 'default_' . $item->type);
                break;
            default:
                require JModuleHelper::getLayoutPath('mod_menu', 'default_url');
                break;
        }
        if ($item->deeper)
            echo '<ul>';
        elseif ($item->shallower)
            echo '</li>' . str_repeat('</ul></li>', $item->level_diff);
        else
            echo '</li>';
    }
    echo '</ul>';
    echo ob_get_clean();
} else {
    $menutype = 'default';
    echo '<ul class="menu' . $params->get('class_sfx') . '"' . $tag . '>';
    foreach ($list as $i => &$item) {
        $id = '';
        if ($item->id == $active_id)
            $id = ' id="current"';
        $class = '';
        if (in_array($item->id, $path))
            $class .= 'active ';
        if ($item->deeper)
            $class .= 'parent ';

        $class = ' class="' . $class . 'item' . $item->id . '"';

        echo '<li' . $id . $class . '>';

        // Render the menu item.
        switch ($item->type) {
            case 'separator':
            case 'url':
            case 'component':
                require JModuleHelper::getLayoutPath('mod_menu', 'default_'.$item->type);
                break;
            default:
                require JModuleHelper::getLayoutPath('mod_menu', 'default_url');
                break;
        }

        if ($item->deeper)
            echo '<ul>';
        elseif ($item->shallower)
            echo '</li>' . str_repeat('</ul></li>', $item->level_diff);
        else
            echo '</li>';
    }
    echo '</ul>';
}
