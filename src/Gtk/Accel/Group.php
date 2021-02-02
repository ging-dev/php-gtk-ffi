<?php

namespace Gtk\Accel
;

    class Group extends \Gtk\Widget
    {
        public function __construct()
        {
            parent::__construct();

            // Create the window
            $this->cdata_instance = $this->ffi->gtk_accel_group_new();
        }

        public function __call($name, $value)
        {
            $function_name = 'gtk_accel_group_'.$name;
            $widget_cast = 'GtkAccelGroup *';

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
                if (false !== strpos('Attempt to call undefined C function', $e->getMessage())) {
                    $return = parent::__call($name, $value);
                }

                throw $e;
            }

            return $return;
        }
    }
