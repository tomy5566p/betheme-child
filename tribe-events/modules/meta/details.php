<?php
/**
 * Single Event Meta (Details) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/details.php
 *
 * @package TribeEventsCalendar
 */


$time_format = get_option( 'time_format', Tribe__Date_Utils::TIMEFORMAT );
$time_range_separator = tribe_get_option( 'timeRangeSeparator', ' - ' );

$start_datetime = tribe_get_start_date();
$start_date = tribe_get_start_date( null, false );
$start_time = tribe_get_start_date( null, false, $time_format );
$start_ts = tribe_get_start_date( null, false, Tribe__Date_Utils::DBDATEFORMAT );

$end_datetime = tribe_get_end_date();
$end_date = tribe_get_display_end_date( null, false );
$end_time = tribe_get_end_date( null, false, $time_format );
$end_ts = tribe_get_end_date( null, false, Tribe__Date_Utils::DBDATEFORMAT );

$time_formatted = null;
if ( $start_time == $end_time ) {
	$time_formatted = esc_html( $start_time );
} else {
	$time_formatted = esc_html( $start_time . $time_range_separator . $end_time );
}

$event_id = Tribe__Main::post_id_helper();
/**
 * Returns a formatted time for a single event
 *
 * @var string Formatted time string
 * @var int Event post id
 */
$time_formatted = apply_filters( 'tribe_events_single_event_time_formatted', $time_formatted, $event_id );

/**
 * Returns the title of the "Time" section of event details
 *
 * @var string Time title
 * @var int Event post id
 */
$time_title = apply_filters( 'tribe_events_single_event_time_title', __( 'Time:', 'the-events-calendar' ), $event_id );

$cost = tribe_get_formatted_cost();
$website = tribe_get_event_website_link();
?>

<div class="tribe-events-meta-group tribe-events-meta-group-details">
	<h3 class="tribe-events-single-section-title mb-3"> <?php esc_html_e( '活動詳細', 'the-events-calendar' ) ?> </h3>
	<div>

		<?php
		do_action( 'tribe_events_single_meta_details_section_start' );

		// All day (multiday) events
		if ( tribe_event_is_all_day() && tribe_event_is_multiday() ) :
			?>

			<div class="mb-3">
				<div class="label">
					<?php esc_html_e( '活動詳細:', 'the-events-calendar' ) ?>
				</div>
				<div>
					<abbr class="tribe-events-abbr tribe-events-start-datetime published dtstart" title="<?php esc_attr_e( $start_ts ) ?>"> <?php esc_html_e( $start_date ) ?> </abbr>
				</div>
			</div>

			<div class="mb-3">
				<div class="label">
					<?php esc_html_e( 'End:', 'the-events-calendar' ) ?>
				</div>
				<div>
					<abbr class="tribe-events-abbr dtend" title="<?php esc_attr_e( $end_ts ) ?>"> <?php esc_html_e( $end_date ) ?> </abbr>
				</div>
			</div>

		<?php
		// All day (single day) events
		elseif ( tribe_event_is_all_day() ):
			?>

			<div class="">
				<?php esc_html_e( '活動詳細:', 'the-events-calendar' ) ?>
			</div>

			<div class="hidden">
				<abbr class="tribe-events-abbr tribe-events-start-datetime published dtstart" title="<?php esc_attr_e( $start_ts ) ?>"> <?php esc_html_e( $start_date ) ?> </abbr>
			</div>
		<?php
		// Multiday events
		elseif ( tribe_event_is_multiday() ) :
			?>

			<div> <?php esc_html_e( '活動詳細:', 'the-events-calendar' ) ?> </div>
			<div>
				<abbr class="tribe-events-abbr updated published dtstart" title="<?php esc_attr_e( $start_ts ) ?>"> <?php esc_html_e( $start_datetime ) ?> </abbr>
			</div>

			<div> <?php esc_html_e( 'End:', 'the-events-calendar' ) ?> </div>
			<div>
				<abbr class="tribe-events-abbr dtend" title="<?php esc_attr_e( $end_ts ) ?>"> <?php esc_html_e( $end_datetime ) ?> </abbr>
			</div>

		<?php
		// Single day events
		else :
			?>
			<div class="">
				<?php esc_html_e( '活動詳細:', 'the-events-calendar' ) ?>
			</div>
			<div class="">
				<?php esc_html_e( $start_date ) ?>
			</div>
			<div class="hidden">
				<abbr class="tribe-events-abbr tribe-events-start-date published dtstart" title="<?php esc_attr_e( $start_ts ) ?>"> </abbr>
			</div>
			<div class="">
				<?php echo esc_html( $time_title ); ?>
			</div>
			<div class="">
				<?php echo $time_formatted; ?>
			</div>
		<?php endif ?>

		<?php
		// 活動分類
		echo tribe_get_event_categories(
			get_the_id(), array(
				'before'       => '',
				'sep'          => ', ',
				'after'        => '',
				'label'        => '活動分類', // An appropriate plural/singular label will be provided
				'label_before' => '<div>',
				'label_after'  => '</div>',
				'wrap_before'  => '<div class="tribe-events-event-categories">',
				'wrap_after'   => '</div>',
			)
		);
		?>

		<?php //echo tribe_meta_event_tags( sprintf( esc_html__( '%s Tags:', 'the-events-calendar' ), tribe_get_event_label_singular() ), ', ', false ) ?>
		<?php
		// Event Website
		if ( ! empty( $website ) ) : ?>

			<div> <?php esc_html_e( 'Website:', 'the-events-calendar' ) ?> </div>
			<div class="tribe-events-event-url"> <?php echo $website; ?> </div>
		<?php endif ?>

		<?php do_action( 'tribe_events_single_meta_details_section_end' ) ?>
	</div>
</div>
