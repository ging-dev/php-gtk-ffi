<?php

require_once 'phpgtk3.php';

function debug($var, $tag = '')
{
    return 1;

    echo "\n--------\n";
    echo (strlen($tag) > 0) ? ($tag."\n") : ('');
    var_dump($var);
    echo "\n--------\n";
}

\Gtk::init();

// Window 1
$window = new \Gtk\Window(\Gtk\Window::TOPLEVEL);
$window->set_title('PHP-GTK3 FFI');
$window->set_modal(true);
debug($window->get_modal(), 'get_modal');
$window->set_default_size(500, 500);
debug($window->get_default_size(), 'get_default_size');
$window->set_position(\Gtk\Window::POS_CENTER);
debug($window->get_position(), 'get_position');
$window->set_hide_titlebar_when_maximized(true);

$window->connect('delete-event', function ($window = null, $a = null) {
    echo "destroyed\n";

    \Gtk::main_quit();

    return true;
});

$entry = new \Gtk\Entry();
$window->add($entry);

$window->connect('button-press-event', function ($entry = null, $a = null) {
    echo "button released\n";

    // var_dump($a->button->axes);
});

$entry->connect('key-release-event', function ($entry = null, $a = null) {
    echo "pressed\n";

    // var_dump($a->key);
    if ($a->key->state & \Gdk::SHIFT_MASK) {
        var_dump('SHIFT + '.chr($a->key->keyval));
    } elseif ($a->key->state & \Gdk::CONTROL_MASK) {
        var_dump('CTRL + '.chr($a->key->keyval));
    }
});

$window->show_all();
// var_dump($window->get_title()); // PROBLEM WITH STRING RETURN
$entry->set_visibility(true);
// var_dump($entry->set_text("Test Field"));
// var_dump($entry->get_text());
$entry->set_icon_from_icon_name(\Gtk\Entry::ICON_SECONDARY, 'gtk-refresh');
$entry->set_icon_activatable(\Gtk\Entry::ICON_SECONDARY, true);
$entry->set_icon_tooltip_text(\Gtk\Entry::ICON_SECONDARY, 'Test field');
// var_dump($entry->get_visibility());

// $window->foreach(function($widget) {
// 	$widget->set_text("OK");
// });

// $children = $window->get_children();
// var_dump($children);

// $focus = $window->get_focus_child();
// var_dump($focus);

// $gtype = $window->child_type();
// var_dump($window->g_type_name($gtype));

$window2 = new \Gtk\Window(\Gtk\Window::TOPLEVEL);
$window2->set_transient_for($window);
$window2->set_resizable(false);
debug($window2->get_resizable(), 'get_resizable');
$window2->set_position(\Gtk\Window::POS_CENTER_ON_PARENT);
$window2->set_modal(true);
// $window2->show_all();

\Gtk::main();
