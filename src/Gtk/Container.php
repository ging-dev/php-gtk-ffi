<?php

namespace Gtk
;

    class Container extends Widget
    {
        protected $name = 'GtkContainer';

        public function __construct()
        {
            parent::__construct();
        }

        public function __call($name, $value)
        {
            $function_name = 'gtk_container_'.$name;
            $widget_cast = 'GtkContainer *';

            try {
                if (0 == count($value)) {
                    $returned = \Gtk::getFFI()->$function_name(\Gtk::getFFI()->cast($widget_cast, $this->cdata_instance));
                } elseif (1 == count($value)) {
                    $returned = \Gtk::getFFI()->$function_name(\Gtk::getFFI()->cast($widget_cast, $this->cdata_instance), $value[0]);
                } elseif (2 == count($value)) {
                    $returned = \Gtk::getFFI()->$function_name(\Gtk::getFFI()->cast($widget_cast, $this->cdata_instance), $value[0], $value[1]);
                } elseif (3 == count($value)) {
                    $returned = \Gtk::getFFI()->$function_name(\Gtk::getFFI()->cast($widget_cast, $this->cdata_instance), $value[0], $value[1], $value[2]);
                } elseif (4 == count($value)) {
                    $returned = \Gtk::getFFI()->$function_name(\Gtk::getFFI()->cast($widget_cast, $this->cdata_instance), $value[0], $value[1], $value[2], $value[3]);
                }

                $return = $this->parse_variable($returned, $name);
            } catch (\FFI\Exception $e) {
                if (false !== strpos($e->getMessage(), 'Attempt to call undefined C function')) {
                    $return = parent::__call($name, $value);
                }

                throw $e;
            }

            return $return;
        }

        public function add($widget)
        {
            $this->ffi->gtk_container_add($this->ffi->cast('GtkContainer *', $this->cdata_instance), $this->ffi->cast('GtkWidget *', $widget->cdata_instance));
        }

        public function remove($widget)
        {
            $this->ffi->gtk_container_remove($this->ffi->cast('GtkContainer *', $this->cdata_instance), $this->ffi->cast('GtkWidget *', $widget->cdata_instance));
        }

        public function foreach($callback)
        {
            // Create the user data, removing callback argument
            $userdata = func_get_args();
            array_shift($userdata);

            // Call the method
            $this->ffi->gtk_container_foreach($this->ffi->cast('GtkContainer *', $this->cdata_instance), function ($widget) use ($callback, $userdata) {
                // Get type of widget
                $object = $this->PHPGTK_OBJECT($widget);

                // Add the widget as the first parameter
                array_unshift($userdata, $object);

                // Call the user function
                call_user_func_array($callback, $userdata);
            }, null);
        }

        public function get_children()
        {
            $children = [];

            $this->foreach(function ($widget) use (&$children) {
                $children[] = $widget;
            });

            return $children;
        }

        // /**
        //  *
        //  */
        // public function get_focus_child()
        // {
        // 	$children = [];

        // 	$widget = $this->ffi->gtk_container_get_focus_child($this->ffi->cast("GtkContainer *", $this->cdata_instance));

        // 	$object = $this->PHPGTK_OBJECT($widget);

        // 	return $object;
        // }

        public function set_focus_child($widget)
        {
            $this->ffi->gtk_container_set_focus_child($this->ffi->cast('GtkContainer *', $this->cdata_instance), $this->ffi->cast('GtkWidget *', $widget->cdata_instance));
        }

        public function child_type()
        {
            $a = $this->ffi->gtk_container_child_type($this->ffi->cast('GtkContainer *', $this->cdata_instance));

            return $a;
        }

        public function child_notify($widget, $child_property)
        {
            $this->ffi->gtk_container_child_notify($this->ffi->cast('GtkContainer *', $this->cdata_instance), $this->ffi->cast('GtkWidget *', $widget->cdata_instance), $child_property);
        }
    }
