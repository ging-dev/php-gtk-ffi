<?php

namespace Gtk
;

    class Widget
    {
        /**
         * FFI Instance.
         */
        protected $ffi = '';

        /**
         * Gtk Instance.
         */
        public $instance = '';

        public function __construct()
        {
            //throw new \Exception("gtk_widget_new not implemented", 1);

            // Get instance of FFI
            $this->ffi = \Gtk::getFFI();
        }

        public function __call($name, $value)
        {
            $function_name = 'gtk_widget_'.$name;
            $widget_cast = 'GtkWidget *';

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
                } elseif (5 == count($value)) {
                    $returned = \Gtk::getFFI()->$function_name(\Gtk::getFFI()->cast($widget_cast, $this->cdata_instance), $value[0], $value[1], $value[2], $value[3], $value[4]);
                }

                $return = $this->parse_variable($returned);
            } catch (\FFI\Exception $e) {
                throw $e;
            }

            return $return;
        }

        public function add_accelerator($signal, $accel_group, $accel_key, $accel_mods, $accel_flags)
        {
            $this->ffi->gtk_widget_add_accelerator($this->ffi->cast('GtkWidget *', $this->cdata_instance), $signal, $accel_group->cdata_instance, $accel_key, $accel_mods, $accel_flags);
        }

        public function destroy()
        {
            $this->ffi->gtk_widget_destroy($this->ffi->cast('GtkWidget *', $this->cdata_instance));
        }

        public function in_destruction(): bool
        {
            return $this->ffi->gtk_widget_in_destruction($this->ffi->cast('GtkWidget *', $this->cdata_instance));
        }

        public function destroyed($widget)
        {
            $this->ffi->gtk_widget_destroyed($this->ffi->cast('GtkWidget *', $this->cdata_instance), $this->ffi->cast('GtkWidget **', \FFI::addr($this->cdata_instance)));
        }

        public function unparent()
        {
            $this->ffi->gtk_widget_unparent($this->ffi->cast('GtkWidget *', $this->cdata_instance));
        }

        public function show()
        {
            $this->ffi->gtk_widget_show($this->ffi->cast('GtkWidget *', $this->cdata_instance));
        }

        public function show_now()
        {
            $this->ffi->gtk_widget_show_now($this->ffi->cast('GtkWidget *', $this->cdata_instance));
        }

        public function hide()
        {
            $this->ffi->gtk_widget_hide($this->ffi->cast('GtkWidget *', $this->cdata_instance));
        }

        public function show_all()
        {
            $this->ffi->gtk_widget_show_all($this->ffi->cast('GtkWidget *', $this->cdata_instance));
        }

        public function map()
        {
            $this->ffi->gtk_widget_map($this->ffi->cast('GtkWidget *', $this->cdata_instance));
        }

        public function unmap()
        {
            $this->ffi->gtk_widget_unmap($this->ffi->cast('GtkWidget *', $this->cdata_instance));
        }

        public function realize()
        {
            $this->ffi->gtk_widget_realize($this->ffi->cast('GtkWidget *', $this->cdata_instance));
        }

        public function queue_draw()
        {
            $this->ffi->gtk_widget_queue_draw($this->ffi->cast('GtkWidget *', $this->cdata_instance));
        }

        public function queue_resize()
        {
            $this->ffi->gtk_widget_queue_resize($this->ffi->cast('GtkWidget *', $this->cdata_instance));
        }

        public function queue_resize_no_redraw()
        {
            $this->ffi->gtk_widget_queue_resize_no_redraw($this->ffi->cast('GtkWidget *', $this->cdata_instance));
        }

        public function queue_allocate()
        {
            $this->ffi->gtk_widget_queue_allocate($this->ffi->cast('GtkWidget *', $this->cdata_instance));
        }

        public function get_scale_factor(): int
        {
            return $this->ffi->gtk_widget_get_scale_factor($this->ffi->cast('GtkWidget *', $this->cdata_instance));
        }

        public function size_allocate(): array
        {
            throw new \Exception('gtk_widget_size_allocate not implemented', 1);
            $allocate = $this->ffi->new('GtkAllocation');
            $this->ffi->gtk_widget_size_allocate($this->ffi->cast('GtkWidget *', $this->cdata_instance), \FFI::addr($allocate));

            return [
                'x' => $allocate->x,
                'y' => $allocate->y,
                'width' => $allocate->width,
                'height' => $allocate->height,
            ];
        }

        public function connect($signal_name, $callback)
        {
            $lookup = $this->ffi->g_signal_lookup($signal_name, $this->G_OBJECT_TYPE($this->cdata_instance));
            $signal_info = \FFI::addr($this->ffi->new('GSignalQuery'));
            $this->ffi->g_signal_query($lookup, $signal_info);
            $closure = $this->ffi->g_cclosure_new_swap(function () use ($signal_info, $callback) {
                $return_param = [];

                // Object
                $return_param[0] = $this;

                for ($i = 0; $i < $signal_info[0]->n_params; ++$i) {
                    $gtype = $this->ffi->g_type_fundamental($signal_info[0]->param_types[$i]);
                    $gname = $this->ffi->g_type_name($gtype);

                    $gdkevent = new \Gdk\Event();
                    $gdkevent->cdata_instance = func_get_arg($i + 1);
                    $return_param[$i + 1] = $gdkevent;
                }

                $return = call_user_func_array($callback, $return_param);

                if (4 != $signal_info[0]->return_type) {
                    $return_p = $this->ffi->new('gpointer');

                    return $return_p;
                }
            }, null, null);
            $this->ffi->g_signal_connect_closure($this->ffi->cast('gpointer', $this->cdata_instance), $signal_name, $closure, true);

            // 			$index = 1;

// 			$this->callbacks[$index] = $callback;

// 			$a = $this->ffi->new("struct st_callback");
// 			$a->index = 1;
// var_dump("1");
// 			$a = $this->ffi->g_signal_connect_object(
// 				$this->ffi->cast("gpointer *", $this->cdata_instance),
// 				$signal_name,
// 				function() use ($index) {
// 					var_dump("lkkk: " . $index);

// 				} ,
// 				NULL,
// 				1
// 			);
// var_dump("2");
        }

        public function G_OBJECT_TYPE($a)
        {
            $g_class = $this->ffi->cast('GTypeInstance *', $a)->g_class;
            $g_type = $this->ffi->cast('GTypeClass *', $g_class)->g_type;

            return $g_type;
        }

        public function G_OBJECT_TYPE_CLASS($a)
        {
            $g_type = $this->ffi->cast('GTypeClass *', $a)->g_type;

            return $g_type;
        }

        public function g_type_name($gtype)
        {
            return $this->ffi->g_type_name($gtype);
        }

        /**
         * Convert an CDATA widget to PHPGTK widget.
         */
        public function PHPGTK_OBJECT($widget)
        {
            // Get type of widget
            $widget = $this->ffi->cast('GtkWidget *', $widget);
            $gtype = $this->G_OBJECT_TYPE($widget);
            $gtype_name = $this->ffi->g_type_name($gtype);

            // Convert it to PHP-GTK class
            $phpgtk_name = '\\Gtk\\'.substr($gtype_name, 3);
            $phpgtk_object = new $phpgtk_name();
            $phpgtk_object->cdata_instance = $widget;

            return $phpgtk_object;
        }

        public function parse_variable($a, $method = '')
        {
            if ('object' == gettype($a)) {
                if ("FFI\CData" == get_class($a)) {
                    // @todo - Find way to verify if $a is void
                    if (\FFI::isNull(\FFI::addr($a))) {
                        return null;
                    }

                    // GObject
                    try {
                        $gtkwidget = $this->ffi->cast('GObject *', $a);
                        $gtype = $this->G_OBJECT_TYPE($gtkwidget);
                    } catch (\FFI\Exception $e) {
                        try {
                            return \FFI::string($a);
                        } catch (\FFI\Exception $e) {
                            return null;
                        }
                    }

                    // preg_match_all('/((?:^|[A-Z])[a-z]+)/', $this->ffi->g_type_name($gtype), $classPart);
                    $classPart = preg_split('/(?=[A-Z])/', $this->ffi->g_type_name($gtype));

                    $className = implode('\\', $classPart);
                    $object = new $className();
                    $object->cdata_instance = $a;

                    return $object;
                }
            }

            return $a;
        }
    }
