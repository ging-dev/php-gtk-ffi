<?php

namespace Gtk
;

    class Box extends Container
    {
        protected $name = 'GtkBox';

        /**
         * GtkPackType.
         */
        const PACK_START = 0;
        const PACK_END = 1;

        /**
         * GtkOrientation.
         */
        const ORIENTATION_HORIZONTAL = 0;
        const ORIENTATION_VERTICAL = 1;

        /**
         * GtkBaselinePosition.
         */
        const BASELINE_POSITION_TOP = 0;
        const BASELINE_POSITION_CENTER = 1;
        const BASELINE_POSITION_BOTTOM = 2;

        public function __construct(int $orientation, int $spacing = null)
        {
            parent::__construct();

            // Create the window
            $this->cdata_instance = $this->ffi->gtk_box_new($orientation, $spacing);
        }

        public function __call($name, $value)
        {
            $function_name = 'gtk_box_'.$name;

            try {
                if (0 == count($value)) {
                    $return = $this->ffi->$function_name($this->ffi->cast('GtkBox *', $this->cdata_instance));
                } elseif (1 == count($value)) {
                    $return = $this->ffi->$function_name($this->ffi->cast('GtkBox *', $this->cdata_instance), $value[0]);
                } elseif (2 == count($value)) {
                    $return = $this->ffi->$function_name($this->ffi->cast('GtkBox *', $this->cdata_instance), $value[0], $value[1]);
                } elseif (3 == count($value)) {
                    $return = $this->ffi->$function_name($this->ffi->cast('GtkBox *', $this->cdata_instance), $value[0], $value[1], $value[2]);
                } elseif (4 == count($value)) {
                    $return = $this->ffi->$function_name($this->ffi->cast('GtkBox *', $this->cdata_instance), $value[0], $value[1], $value[2], $value[3]);
                }
            } catch (\FFI\Exception $e) {
                $return = parent::__call($name, $value);
            }

            return $this->parse_variable($return);
        }

        public function pack_start(Widget $widget, bool $expand = false, bool $fill = false, int $padding = 0)
        {
            $this->ffi->gtk_box_pack_start($this->ffi->cast('GtkBox *', $this->cdata_instance), $widget->cdata_instance, $expand, $fill, $padding);
        }

        public function pack_end(Widget $widget, bool $expand = false, bool $fill = false, int $padding = 0)
        {
            $this->ffi->gtk_box_pack_end($this->ffi->cast('GtkBox *', $this->cdata_instance), $widget->cdata_instance, $expand, $fill, $padding);
        }

        public function reorder_child(Widget $widget, int $position)
        {
            $this->ffi->gtk_box_reorder_child($this->ffi->cast('GtkBox *', $this->cdata_instance), $widget->cdata_instance, $position);
        }

        public function query_child_packing(Widget $child, bool $expand = false, bool $fill = false, int $padding = 0, int $pack_type)
        {
            $this->ffi->gtk_box_query_child_packing($this->ffi->cast('GtkBox *', $this->cdata_instance), $child->cdata_instance, $expand, $fill, $padding, $pack_type);
        }

        public function set_child_packing(Widget $child, bool $expand = false, bool $fill = false, int $padding = 0, int $pack_type)
        {
            $this->ffi->gtk_box_set_child_packing($this->ffi->cast('GtkBox *', $this->cdata_instance), $child->cdata_instance, $expand, $fill, $padding, $pack_type);
        }

        public function set_center_widget(Widget $child, bool $expand = false, bool $fill = false, int $padding = 0, int $pack_type)
        {
            $this->ffi->gtk_box_set_center_widget($this->ffi->cast('GtkBox *', $this->cdata_instance), $child->cdata_instance);
        }
    }
