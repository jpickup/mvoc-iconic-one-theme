<?php
/**
 * View: List View - Single Event Date
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/list/event/date.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @since 4.9.9
 * @since 5.1.1 Move icons into separate templates.
 *
 * @var WP_Post $event The event post object with properties added by the `tribe_get_event` function.
 *
 * @see tribe_get_event() For the format of the event object.
 *
 * @version 5.1.1
 */
use Tribe__Date_Utils as Dates;

$event_date_attr = $event->dates->start->format( Dates::DBDATEFORMAT );

?>
<div class="tribe-events-calendar-list__event-datetime-wrapper tribe-common-b2">
	<?php $this->template( 'list/event/date/featured' ); ?>
	<time class="tribe-events-calendar-list__event-datetime" datetime="<?php echo esc_attr( $event_date_attr ); ?>">
		<?php echo $event->schedule_details->value(); ?>
	</time>
	<div class="mvoc-event-list-distance">
		<?php
			require_once get_stylesheet_directory() . '/mvoc-events.php';
			$tribe_ecp = Tribe__Events__Main::instance();
			$categories = get_the_terms( $event->ID, $tribe_ecp->get_event_taxonomy());
			if ($categories) {
				echo '<b>';
				$prev = false;
				foreach($categories as $category) {
					if ($prev) {
						echo ', ';
					}
					if ($category->description) {
						echo '<a class="tribe-common-anchor-thin" href="' . $category->description . '" target="_blank" rel="noopener">' . ($category->name) . '</a>';
					} else {
						echo ($category->name);
					}
					$prev = true;
				}
				echo '</b>';
			}

			$distance = get_post_meta( $event->ID, "_mvoc_distance", true);
			if ($distance) {
				echo ' (' . $distance . ' miles)';
			} else {
				$latitude = get_post_meta($event->ID, "_mvoc_latitude", true);
				$longitude = get_post_meta($event->ID, "_mvoc_longitude", true);
				$calc_distance = event_distance($latitude, $longitude);
				if ($calc_distance) {
					echo ' (' . $calc_distance . ' miles)';
				}
			}
		?>
	</div>
	<?php $this->template( 'list/event/date/meta', [ 'event' => $event ] ); ?>
</div>
