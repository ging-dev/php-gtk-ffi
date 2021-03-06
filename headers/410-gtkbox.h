GtkWidget * gtk_box_new (GtkOrientation orientation, gint spacing);
void gtk_box_pack_start (GtkBox *box, GtkWidget *child, gboolean expand, gboolean fill, guint padding);
void gtk_box_pack_end (GtkBox *box, GtkWidget *child, gboolean expand, gboolean fill, guint padding);
gboolean gtk_box_get_homogeneous (GtkBox *box);
void gtk_box_set_homogeneous (GtkBox *box, gboolean homogeneous);
gint gtk_box_get_spacing (GtkBox *box);
void gtk_box_set_spacing (GtkBox *box, gint spacing);
void gtk_box_reorder_child (GtkBox *box, GtkWidget *child, gint position);
void gtk_box_query_child_packing (GtkBox *box, GtkWidget *child, gboolean *expand, gboolean *fill, guint *padding, GtkPackType *pack_type);
void gtk_box_set_child_packing (GtkBox *box, GtkWidget *child, gboolean expand, gboolean fill, guint padding, GtkPackType pack_type);
GtkBaselinePosition gtk_box_get_baseline_position (GtkBox *box);
void gtk_box_set_baseline_position (GtkBox *box, GtkBaselinePosition position);
GtkWidget * gtk_box_get_center_widget (GtkBox *box);
void gtk_box_set_center_widget (GtkBox *box, GtkWidget *widget);