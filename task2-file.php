<?php
/**
 * Get the available service times of a restaurant on a specified date to book.
 *
 * @param Restaurant $restaurant The restaurant for which to get booking times.
 * @param Carbon $date The date for which to get booking times.
 * @param bool $ignoreBookingDuration Flag to ignore booking duration adjustments.
 * @return array An array of available booking times.
 */
public function getServiceTimesForRestaurant(Restaurant $restaurant, Carbon $date, $ignoreBookingDuration = false)
{
    // Initialize arrays to store booking times and filtered booking times
    $booking_times = [];
    $filtered_booking_times = [];
    $opening_hours = [];

    // Get the day of the week from the given date
    $day = $date->englishDayOfWeek;

    // Get the default booking time step in minutes (e.g., 15 or 30 minutes)
    $step = $restaurant->default_booking_time_step_minutes;

    try {
        // Check if there are special service hours for the given date
        if ($ssh = $restaurant->inSpecialServiceHoursActive($date)) {
            // Get special service hours for the day, hiding specific attributes
            $service_hours = $restaurant->specialServiceHours($day, $ssh->id)->makeHidden('id', 'day', 'restaurant_id', 'created_at', 'updated_at');
        } else {
            // Get regular service hours for the day, hiding specific attributes
            $service_hours = $restaurant->serviceHours($day)->makeHidden('id', 'day', 'restaurant_id', 'created_at', 'updated_at');
        }
    } catch (\Throwable $th) {
        // Return empty booking times array if there's an error fetching service hours
        return $booking_times;
    }

    // Initialize an empty array for skipped times and a counter
    $skip = [];
    $c = 0;

    // Loop through each service hour period
    foreach ($service_hours as $service_hour) {
        // Increment the counter
        $c++;

        // Convert the opening and closing times to Carbon instances
        $open = Carbon::createFromFormat('H:i:s', $service_hour->open);
        $close = Carbon::createFromFormat('H:i:s', $service_hour->close);

        // If one sitting is enforced, add only the opening time and continue to the next period
        if ($service_hour->enforce_one_sitting) {
            $booking_times[] = $open->format('H:i');
            continue;
        }

        // Check if the booking duration should be ignored
        if ($service_hour->ingore_booking_duration) {
            $ignoreBookingDuration = true;
        }

        // For the last service hour period, adjust the closing time if booking duration is not ignored
        if ($c == count($service_hours) && !$ignoreBookingDuration) {
            $close->subMinutes($restaurant->default_booking_duration_hours);
        }

        // Calculate the difference in minutes between opening and closing times
        $diff = $open->diffInMinutes($close);

        // Add the opening time to the booking times array
        $booking_times[] = $open->format('H:i');

        // Loop to add time slots based on the step until closing time
        while ($diff > 0 && ($close->format('i') == '59' || $open->copy()->addMinutes($step)->lte($close))) {
            $booking_times[] = $open->addMinutes($step)->format('H:i');
            $diff -= $step;
        }
    }

    // If the date is today, filter out past booking times
    if ($date->isToday()) {
        $firstBookingTime = Carbon::now()->addMinutes($restaurant->widget_booking_minutes_before);

        // Remove booking times that are before the first booking time
        foreach ($booking_times as $idx => $bt) {
            $bt_carbon = Carbon::createFromTimeString($bt);
            if ($firstBookingTime >= $bt_carbon) {
                unset($booking_times[$idx]);
            }
        }
    }

    // Remove duplicate booking times and reindex the array
    $booking_times = array_unique($booking_times);
    $booking_times = array_values($booking_times);

    // Remove '00:00' from the end of the array if exists
    if (end($booking_times) == '00:00') {
        array_pop($booking_times);
    }

    // Sort the booking times in ascending order
    sort($booking_times);

    // Return the final array of booking times
    return $booking_times;
}
